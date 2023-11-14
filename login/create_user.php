<?php
require('data_connect.php');

if(isset($_POST['UserName'], $_POST['MailAddress'], $_POST['PassWord'])){

    $UserName = htmlspecialchars($_POST['UserName'], ENT_QUOTES);
    $MailAddress = htmlspecialchars($_POST['MailAddress'], ENT_QUOTES);
    $PassWord = htmlspecialchars($_POST['PassWord'], ENT_QUOTES);

    $hashedPassword = password_hash($PassWord, PASSWORD_BCRYPT);

    $stmt = $db->prepare('select * from todo_user where mailaddress= ?');
    $stmt ->bind_param("s", $MailAddress);
    $stmt -> execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;

    //データベースに既にメールアドレスが存在する場合、エラーメッセージを返す
    if($num_rows > 0){
        echo "このメールアドレスは既に使われているよ。別のにしてね";

    }else{



    $stmt = $db->prepare('insert into todo_user (user, mailaddress, password) values (?,?,?)');
    $stmt->bind_param("sss", $UserName, $MailAddress, $hashedPassword);
    $stmt->execute();

    $stmt->close();
    $db->close();
    }
}
?>