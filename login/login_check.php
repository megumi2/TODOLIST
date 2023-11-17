<?php
require('data_connect.php');

if(isset($_POST['MailAddress'], $_POST['PassWord'])){
    // レスポンスのContent-TypeをJSONに設定
    header('Content-Type: application/json');

    $MailAddress = htmlspecialchars($_POST['MailAddress'], ENT_QUOTES);
    $PassWord = htmlspecialchars($_POST['PassWord'], ENT_QUOTES);

    $stmt = $db->prepare('select * from todo_user where mailaddress= ?');
    $stmt->bind_param('s', $MailAddress);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_assoc();
    if ($member === null) {
        // ユーザーが見つからなかった場合の処理
        echo json_encode(array("success" => false, "message" => "メールアドレスかパスワードが間違っているようだね。"));
        exit;
    }

    if(password_verify($PassWord, $member['password']) && $MailAddress == $member['mailaddress']){
        //DBのユーザー情報をセッションに保存
        session_start();
        $_SESSION['ID'] = $member['ID'];
        $_SESSION['user'] = $member['user'];
        $stmt->close();
        $db->close();

        echo json_encode(array("success" => true));
    };

    
};
?>