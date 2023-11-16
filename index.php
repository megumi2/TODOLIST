<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoApp</title>
</head>
<?php
session_start(); // セッションを開始

//ログイン済かどうかを確認する
if(!isset($_SESSION["user"])){
    header('Location:login/entry.php');
    exit;
}
?>
<body>
<!-- ナビゲーションバー -->
<div class="nav-bar navbar-expand-lg p-3 container center-block">
        <h2>TodoApp</h2>

        <ul class="nav-bar-list">
            <li class="list_1">ようこそ<?php echo $_SESSION["user"]?>さん</li>
            <li id="list_logout"><a href="login/logout.php">ログアウト</a></li>
        </ul>
</div>

<div class="container center-block"  style="background-color: white;">
    <!-- 画像とセリフ -->
    <div class="container">
        <img src="img/キャラクター.png" id="image" alt=""width="150px" height="150px">
        <div class='arrow_box'><p id='charactor_serif'></p></div>
    </div>

    <!-- タスクの入力フォーム -->
    <div style="display: inline-block; margin-right: 10px;">
    <form method="post" action = "" id="form_list">
        <div style="display: inline-block; margin-right: 10px;">
            <label for="taskName" style="display: inline-block; margin-right: 5px;">タスク</label>
            <input type="text" size="80" class="form-control" id="taskName"  name="task_name">
        </div>
        <div style="display: inline-block; margin-right: 10px;">
        <label for="taskPriority">優先度</label>
        <select  class="form-control" id="taskPriority" name="task_priority">
            <option>低</option>
            <option selected>中</option>
            <option>高</option>
        </select>
        </div>
        <div style="display: inline-block; margin-right: 10px;">
            <label for="taskStart" style="display: inline-block; margin-right: 5px;">開始日</label>
            <input type="date" class="form-control" id="taskStart" name="task_start">
        </div>
        <div style="display: inline-block; margin-right: 10px;">
        <label for="taskEnd" style="display: inline-block; margin-right: 5px;">終了日</label>
        <input type="date" class="form-control" id="taskEnd"  name="task_end">
    </div>
        <!-- タスクの追加ボタン -->
        <div style="display: inline-block; margin-right: 10px;">
        <input type="submit" class="btn btn-primary"id="task_add" value="タスクの追加">
    </div>

    </div>



    <!-- タスク一覧のテーブル -->

    <table class="task-table table" id="task-table">
        <thead>
            <tr>
                <th scope="col">タスク</th>
                <th scope="col">優先度</th>
                <th scope="col">開始日</th>
                <th scope="col">終了日</th>
                <th scope="col">編集</th>
                <th scope="col">完了</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</form>

    <!-- タスク削除ボタン -->
    <div class="delete_button">
    <button type="button" class="btn btn-danger mx-auto" id="task_delete">タスク完了</button>
    </div>
</div>

</body>
</html>
<script src="main.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>


$.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        });


//タスク追加非同期通信

$('#task_add').on('click', function(event){   
    //現在の日程を取得
    const today =  new Date()

    //タスクの開始日、終了日が過去かどうかを比較するための変数
    const input_start_date = new Date($("#taskStart").val());
    const input_end_date = new Date($("#taskEnd").val());

    //タスクの開始日、終了日と今日の日程を比較する際にバグが出ないための調整
    input_start_date.setHours(23, 59);
    input_end_date.setHours(23, 59); 
    
    //タスクが未入力の場合
    if($("#taskName").val() ===""){
        //処理を中断
        NotionSerif("おーい。タスク名書き忘れているよ。ちゃんと書いてあげてー。");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    //タスクの開始日、終了日が未入力の場合
    }else if($("#taskStart").val() ==="" || $("#taskEnd").val() ===""){
        NotionSerif("開始日もしくは終了日を書いてないよ。大事なことだから書いてあげて。");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    //タスクの開始日、終了日が今日よりも過去の場合フォームの送信を中止
    }else if(today.getTime() > input_start_date.getTime() || today.getTime() > input_end_date.getTime()){
        NotionSerif("開始日もしくは終了日が過去になってるよ。時間旅行にでも行ってきた？");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    }else if($("#taskStart").val() > $("#taskEnd").val()){
        event.preventDefault(); // フォームの送信を中止
        NotionSerif("終了日が開始日よりも早くなってるよ。時間の流れが違う世界にいたの？");
        return;// ここで return して処理を中断
    }else{
    // フォームのデータを取得
    event.preventDefault();
    var taskName = $("#taskName").val();
    var taskPriority = $("#taskPriority").val();
    var taskStart = $("#taskStart").val();
    var taskEnd = $("#taskEnd").val();
    var user_id = <?php echo $_SESSION["ID"]; ?>;
    
    }

    $.ajax({
        type:"POST",
        url:"insert_task.php",
        data:{
            task_name: taskName,
            task_priority: taskPriority,
            task_start: taskStart,
            task_end: taskEnd,
            user_id: user_id
        },
        success: function(response){
            //セリフを変更
            TaskAddSerif();
            // タスクテーブルの内容を更新
            loadTaskData();
            
        },
        error: function(xhr, status, error){
            console.log("エラー："+error);
        }
    });
    
    

});

//タスク編集ページ遷移
$(document).on('click', ".btn-edit", function(){
    var task_id = $(this).closest('tr').find('td').attr('id');;
    // タスク編集ページへの遷移
    window.location.href = 'task_edit.php?id=' + task_id; // 遷移先の URL に task_id を渡します
})


//タスク削除非同期通信

$('#task_delete').on('click', function(){
    //チェックボックスにチェックがついているクエリを取得
    var selected_rows = [];
    var chk = document.getElementsByName("check_box");
    for(let i = 0; i < chk.length; i++){
        if(chk[i].checked){
            selected_rows.push(chk[i].value);
        }

    }
    if(selected_rows.length == 0){
        //処理を中断  
        event.preventDefault();
        document.getElementById("charactor_serif").textContent = "タスクを選択し忘れているよ。もう１回選択してみて。";
        setTimeout(() => {setCharactorSerif()}, 100000);
        return;// ここで return して処理を中断
        }
    $.ajax({
        type: "POST",
        url: "delete_task.php",
        data: { taskIds: selected_rows }, // タスクIDを配列として送信
        success: function(response) {
            // 削除が成功した場合の処理
            // タスクテーブルの内容を更新
            loadTaskData();
            //セリフを変更
            TaskCompleteSerif();
            

        },
        error: function(xhr, status, error) {
            // エラーハンドリング
            console.log("エラー：" + error);
        }
        
    
    });
});

//追加、削除したデータを画面に反映
function loadTaskData(){
    var user_id = <?php echo $_SESSION["ID"]; ?>;
    $.ajax({
        type:"POST",
        url:"load_task.php",
        success: function(response){
            $("#task-table tbody").html(response); // タスクテーブルを更新;
        },
        error: function(xhr, status, error){
            console.log("エラー："+error);
        }
    });
}


loadTaskData();
</script>
