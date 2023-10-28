<?php
require('data_connect.php');

$Task_ids = $_POST['taskIds'];

$query ="delete from todo_task where todo_task.id = ?";
$stmt = $db->prepare($query);
foreach($Task_ids as $taskid){
    $stmt->bind_param("i", $taskid);
    if($stmt->execute()){
        // タスクの削除が成功した場合の処理
        echo "タスクを削除しました";
    }else{
         // エラーハンドリング
        echo "削除エラー: " . $stmt->error;
    }
}   
    $stmt->reset();
    $stmt->close();


?>