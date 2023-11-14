<?php
require('data_connect.php');

//DBに追加
if(isset($_POST['task_name'], $_POST['task_priority'], $_POST['task_start'], $_POST['task_end'])){
    //クエリを作成しデータベースに挿入
    $taskId = htmlspecialchars($_POST["task_id"], ENT_QUOTES);
    $taskName = htmlspecialchars($_POST["task_name"], ENT_QUOTES); // フォームから直接値を取得
    $taskPriority = htmlspecialchars($_POST["task_priority"], ENT_QUOTES);
    $taskStart = htmlspecialchars($_POST["task_start"], ENT_QUOTES);
    $taskEnd = htmlspecialchars($_POST["task_end"], ENT_QUOTES);
    //SQL文を作成、実行
    $stmt = $db->prepare("update todo_task set task_name = ?, priority = ?, start_date = ?, end_date = ? where id = ?");
    $stmt->bind_param("ssssi", $taskName, $taskPriority, $taskStart, $taskEnd, $taskId);
    $stmt->execute();

    $stmt->close();
    $db->close();
}
?>