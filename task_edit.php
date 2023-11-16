<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>タスク編集</title>
    </head>
    <body>
    <!-- ナビゲーションバー -->
    <div class="nav-bar navbar-expand-lg p-3 container center-block">
            <a id ="Top_Link" href ="index.php"><h2>TodoApp</h2></a>
    </div>
    <div class="container center-block col-6"  style="background-color: white;">
        <!-- 画像とセリフ -->
        <div class="container">
        <img src="img/キャラクター.png" id="image" alt=""width="150px" height="150px">
        <div class='arrow_box'><p id='charactor_serif'></p></div>
    </div>
    <div style="container center-block">
    <form method="post" action = "" id="form_list">  
        <?php require('data_connect.php'); 
        $task_id = $_GET['id'];
        $query = 'select * from todo_task where todo_task.id = ?';
        $stmt = $db->prepare($query);
        $stmt-> bind_param('s', $task_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $task = $result->fetch_assoc();
        $stmt->execute();
        if ($stmt->error) {
            die('Error: ' . $stmt->error);
        }
        ?>
        <h1 class="title text-center">タスク編集</h1>
        <div class="container center-block col-11" style="padding-bottom: 30px;">
            <input type = "hidden" id="taskId" value="<?php echo $task['id']; ?>">
            <label for="taskName">タスク</label>
            <input type="text" size="40" class="form-control" id="taskName" name="task_name" value="<?php echo $task['task_name']; ?>">
        </div>
        <div class="container center-block  col-11"  style="padding-bottom: 30px;">
        <label for="taskPriority">優先度</label>
        <select  class="form-control" id="taskPriority" name="task_priority">
        <?php if ($task['priority'] == '高'):?>
            <?php echo '<option>低</option>';
            echo '<option>中</option>';
            echo '<option selected>高</option>?>'; ?>
        <?php elseif($task['priority'] == '中'):?>
            <?php echo '<option>低</option>';
            echo '<option selected>中</option>';
            echo '<option>高</option>?>'; ?>
        <?php elseif($task['priority'] == '低'):?>
            <?php echo '<option selected>低</option>';
            echo '<option>中</option>';
            echo '<option>高</option>?>'; ?>
        <?php endif; ?>
        </select>
        </div>
        <div class="container center-block col-11"  style="padding-bottom: 30px;">
            <label for="taskStart" style="display: inline-block;">開始日</label>
            <input type="date" size="80" class="form-control" id="taskStart" name="task_start" value ="<?php echo $task['start_date']?>">
        </div>
        <div class="container center-block col-11"  style="padding-bottom: 30px;">
            <label for="taskEnd" style="display: inline-block;">終了日</label>
            <input type="date" class="form-control" id="taskEnd"  name="task_end" value ="<?php echo $task['end_date']?>">
        </div>
        <button size="80" class="btn btn-primary  mx-auto" style ="display: block;" id="edit_button">編集する</button>
    </form>

    
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    //キャラクターにセリフを喋らせる
    function NotionSerif(text){
    document.getElementById("charactor_serif").textContent = text;
}
//デフォルトのセリフ
NotionSerif("ここは編集画面。好きに編集していってくれ。")

//編集ボタンをクリック
    $('#edit_button').on('click', function(){
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
        return;
    //タスクの開始日、終了日が未入力の場合
    }else if($("#taskStart").val() ==="" || $("#taskEnd").val() ===""){
        NotionSerif("開始日もしくは終了日を書いてないよ。大事なことだから書いてあげて。");
        event.preventDefault(); // フォームの送信を中止
        return;
    //タスクの開始日、終了日が今日よりも過去の場合フォームの送信を中止
    }else if(today.getTime() > input_start_date.getTime() || today.getTime() > input_end_date.getTime()){
        NotionSerif("開始日もしくは終了日が過去になってるよ。時間旅行にでも行ってきた？");
        event.preventDefault(); // フォームの送信を中止
        return;
    }else if($("#taskStart").val() > $("#taskEnd").val()){
        event.preventDefault(); // フォームの送信を中止
        NotionSerif("終了日が開始日よりも早くなってるよ。時間の流れが違う世界にいたの？");
        return;
    }else{
    // フォームのデータを取得
    var taskId = $("#taskId").val();
    var taskName = $("#taskName").val();
    var taskPriority = $("#taskPriority").val();
    var taskStart = $("#taskStart").val();
    var taskEnd = $("#taskEnd").val();

    }

    

    $.ajax({
        type:"POST",
        url:"update_task.php",
        data:{
            task_id: taskId,
            task_name: taskName,
            task_priority: taskPriority,
            task_start: taskStart,
            task_end: taskEnd
        },
        success: function(response){
            //ホーム画面に遷移

            window.location.href = "index.php";
        },
        error:function(jqXHR, textStatus, errorThrown) {
        // エラーハンドリング
        console.log("エラー：" + error);
        }
    });
    
    

});





</script>

</html>