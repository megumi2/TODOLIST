<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ログアウト</title>
    </head>
    <body>
    <?php 
    session_start();
    $_SESSION = array();
    session_destroy();
    ?>
    <!-- ナビゲーションバー -->
    <div class="nav-bar navbar-expand-lg p-3">
            <a id ="Top_Link" href ="../index.php"><h2>TodoApp</h2></a>
    </div>
    <div class="container center-block col-8" style="background-color: white;">
    <h3 id="logout_title">ログアウトしました</h3>
        <!-- 画像とセリフ -->
        <div class="container">
        <img src="../img/キャラクター.png" id="image" alt=""width="150px" height="150px">
        <div class='arrow_box'><p id='charactor_serif'>また来てね。ぼくはいつでも待っているよ。</p></div>
    </div>
    <div class="container center-block">

        <button size="80" class="btn btn-primary mx-auto" type ="submit" style ="display: block;" id="login_transision">ログインページに戻る</button>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

    
$('#login_transision').on('click', function(){
    window.location.href = "entry.php";
});

</script>
