<?php
$db = new mysqli('localhost:8889', 'root', 'root', 'mydb');
if ($db->connect_error) {
    echo "データベース接続エラー: " . $db->connect_error;
}
?>