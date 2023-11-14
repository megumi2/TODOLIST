<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>タスク編集</title>
    </head>
    <body>
    <!-- ナビゲーションバー -->
    <div class="nav-bar navbar-expand-lg p-3">
            <a id ="Top_Link" href ="index.html"><h2>TodoApp</h2></a>
    </div>
    <div class="container center-block col-8" style="background-color: white;">
        <!-- 画像とセリフ -->
        <div class="container">
        <img src="../img/キャラクター.png" id="image" alt=""width="150px" height="150px">
        <div class='arrow_box'><p id='charactor_serif'></p></div>
    </div>
    <div class="container center-block">
    <form method="post" id="login_list">  
    <h1 class="title text-center">ログイン</h1>
        <div class="container center-block col-11" style="padding-bottom: 30px;">
            <label for="taskName">メールアドレス</label>
            <input type="text" size="40" class="form-control" id="mailAddress" name="mail_address">
        </div>
        <div class="container center-block  col-11"  style="padding-bottom: 30px;">
        <label for="password">パスワード</label>
        <input type="password" size="40" class="form-control" id="passWord" name="pass_word">
        </div>
        
        <button size="80" class="btn btn-primary mx-auto" type ="submit" style ="display: block;" id="login_button">ログイン</button>
    </form>   
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    //セリフを喋らせる
    function NotionSerif(text){
    console.log("NotionSerif:", text); // この行を追加
    document.getElementById("charactor_serif").textContent = text;
    }

NotionSerif("ぼくはねこもどき。あなたはだーれ？")

$.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        });
    
$('#login_button').on('click', function(event){
    event.preventDefault(); // フォームの送信を中止

    //パスワードかメールアドレスが入力されていない
    if($('#mailAddress').val()==="" || $('#passWord').val()=== ""){
        NotionSerif("パスワードかメールアドレスを入力してないね。それじゃログイン出来ないよ。")
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    }else{
        // フォームのデータを取得
        var MailAddress = $('#mailAddress').val();
        var PassWord = $('#passWord').val();
    }

    $.ajax({
        type:"POST",
        url:"login_check.php",
        data:{
            MailAddress: MailAddress,
            PassWord: PassWord
        },
        success: function(response){
            console.log(response);
            console.log(response.success); // この行を追加してください
            if(response.success === true){
                // ログイン成功時の処理
            window.location.href = "../index.php";
        } else if(response.success === false) {
            // ログイン失敗時の処理
            NotionSerif(String(JSON.parse('"' + response.message + '"')));
            
            };
    
        },
        error: function(xhr, status, error){
            console.log("エラー："+error);
        }
    });

    });
</script>
