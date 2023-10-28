<?php 


//DBに接続
require('data_connect.php');
//DBに追加
if(isset($_POST['task_name'], $_POST['task_priority'], $_POST['task_start'], $_POST['task_end'])){
    //クエリを作成しデータベースに挿入

    $taskName = htmlspecialchars($_POST["task_name"], ENT_QUOTES); // フォームから直接値を取得
    $taskPriority = htmlspecialchars($_POST["task_priority"], ENT_QUOTES);
    $taskStart = htmlspecialchars($_POST["task_start"], ENT_QUOTES);
    $taskEnd = htmlspecialchars($_POST["task_end"], ENT_QUOTES);

    $stmt = $db->prepare("insert into todo_task (task_name, priority, start_date, end_date) values (?,?,?,?)");
    $stmt->bind_param("ssss", $taskName, $taskPriority, $taskStart, $taskEnd);
    $stmt->execute();



    $stmt->close();
    $db->close();

}
?>