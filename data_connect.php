<?php
require_once 'config.php';

$db = new mysqli($ServerName, $UserName, $PassWord, $DataBase);
if ($db->connect_error) {
    echo "データベース接続エラー: " . $db->connect_error;
}
?>