<?php 


//DBに接続
$db = new mysqli('localhost:8889', 'root', 'root', 'mydb');
if ($db->connect_error) {
    echo "データベース接続エラー: " . $db->connect_error;
}
//DBに追加
if(isset($_POST['task_name'], $_POST['task_priority'], $_POST['task_start'], $_POST['task_end'])){
    //クエリを作成しデータベースに挿入

    $taskName = $_POST["task_name"]; // フォームから直接値を取得
    $taskPriority = $_POST["task_priority"];
    $taskStart = $_POST["task_start"];
    $taskEnd = $_POST["task_end"];

    $stmt = $db->prepare("insert into todo_task (task_name, priority, start_date, end_date) values (?,?,?,?)");
    $stmt->bind_param("ssss", $taskName, $taskPriority, $taskStart, $taskEnd);
    //$stmt->execute();

    if ($stmt->execute()) {
        // データが正常に挿入されたらJavaScriptの関数を呼び出す
        echo '<script>';
        echo 'TaskAddSerif();';
        echo '</script>';
    }

    $stmt->close();
    $db->close();

}
?>