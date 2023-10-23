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
$db = new mysqli('localhost:8889', 'root', 'root', 'mydb');
if ($db->connect_error) {
    echo "データベース接続エラー: " . $db->connect_error;
}?>
<body>
<!-- ナビゲーションバー -->
<div class="nav-bar navbar-expand-lg p-3">
        <h2 style="color:white;">TodoApp</h2>
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
        <input type="submit" class="btn btn-primary"id="task_add" value="タスクの追加" onclick="TaskAddSerif()">
    </div>

    </div>



    <!-- タスク一覧のテーブル -->
    <?php 
    $query='select task_name, id, priority, start_date, end_date, complete from todo_task;';
    $result= $db->query($query);
    if (!$result) {
        die("クエリエラー: " . $db->error);
    }
    ?>
    <table class="task-table table">
        <thead>
            <tr>
                <th scope="col">タスク</th>
                <th scope="col">優先度</th>
                <th scope="col">開始日</th>
                <th scope="col">終了日</th>
                <th scope="col">完了</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()){
                echo '<tr>';
                echo '<td>'.$row['task_name'].'</td>';
                echo '<td>'.$row['priority'].'</td>';
                echo '<td>'.$row['start_date'].'</td>';
                echo '<td>'.$row['end_date'].'</td>';
                echo '<td><input class="form-check-input" type="checkbox" value="'.$row['id'].'"name = "check_box" id="flexCheckChecked_'.$row['id'].'"></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</form>

    <!-- タスク削除ボタン -->
    <div class="delete_button">
    <button type="button" class="btn btn-danger" id="task_delete">タスク削除</button>
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
$('#form_list').on('submit', function(event){
   // フォームのデータを取得
    var taskName = $("#taskName").val();
    var taskPriority = $("#taskPriority").val();
    var taskStart = $("#taskStart").val();
    var taskEnd = $("#taskEnd").val();

    $.ajax({
        type:"POST",
        url:"insert_task.php",
        data:{
            task_name: taskName,
            task_priority: taskPriority,
            task_start: taskStart,
            task_end: taskEnd
        },
        success: function(response){
            console.log("データ格納しました");
        },
        error: function(xhr, status, error){
            console.log("エラー："+error);
        }
    });

});

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
    $.ajax({
        type: "POST",
        url: "delete_task.php",
        data: { taskIds: selected_rows }, // タスクIDを配列として送信
        success: function(response) {
            // 削除が成功した場合の処理
            console.log("タスクを削除しました");
            // ここで必要に応じてページをリロードまたはタスク一覧を更新する処理を追加できます
        },
        error: function(xhr, status, error) {
            // エラーハンドリング
            console.log("エラー：" + error);
        }
    
    });
});


</script>
