<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    echo $_POST['task_name'];
    echo $_POST['task_priority'];
    echo $_POST['task_start'];
    echo $_POST['task_end'];

    //クエリを作成しデータベースに挿入
    $db = new mysqli('localhost:8889', 'root', 'root', 'mydb');
    if ($db->connect_error) {
        echo "データベース接続エラー: " . $db->connect_error;
    }
    $taskName = $_POST["task_name"]; // フォームから直接値を取得
    $taskPriority = $_POST["task_priority"];
    $taskStart = $_POST["task_start"];
    $taskEnd = $_POST["task_end"];

    $stmt = $db->prepare("insert into todo_task (task_name, priority, start_date, end_date) values (?,?,?,?)");
    $stmt->bind_param("ssss", $taskName, $taskPriority, $taskStart, $taskEnd);
    $stmt->execute();
    echo "データ格納しました";

    $stmt->close();
    $db->close();

    ?>
</body>
</html>