<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>会員登録</title>
    </head>
    <body>
    <!-- ナビゲーションバー -->
    <div class="nav-bar navbar-expand-lg p-3 container center-block  col-6">
            <a id ="Top_Link" href ="index.php"><h2>TodoApp</h2></a>
    </div>
    <div class="container center-block col-6"  style="background-color: white;">
        <!-- 画像とセリフ -->
        <div class="container">
        <img src="../img/キャラクター.png" id="image" alt=""width="150px" height="150px">
        <div class='arrow_box'><p id='charactor_serif'></p></div>
    </div>
    <div style="container center-block col-9">
    <form method="post" action = "entry.html" id="login_list">  
    <h1 class="title text-center">会員登録</h1>
        <!--ユーザー名を登録-->
        <div class="container center-block col-11" style="padding-bottom: 30px;">
            <label for="userName">ユーザー名</label>
            <input type="text" size="40" class="form-control" id="username" name="user_name">
        </div>
        <!--メールアドレスを登録-->
        <div class="container center-block col-11" style="padding-bottom: 30px;">
            <label for="userName">メールアドレス</label>
            <input type="text" size="40" class="form-control" id="mailaddress" name="mail_address">
        </div>
        <!--パスワードを登録-->
        <div class="container center-block  col-11"  style="padding-bottom: 30px;">
            <label for="password">パスワード</label>
            <input type="password" size="40" class="form-control" id="password" name="pass_word">
        <!--パスワードを間違えた際に注意書きを表示-->
            <div id = "password_caution"  style="color: red;">
            </div>
        </div>
        <!--パスワードを間違っていないか確認するためのフォーム-->
        <div class="container center-block col-11"  style="padding-bottom:30px;">
            <label for="password">パスワード(確認)</label>
            <input type="password" size="40" class="form-control" id="required">
            <!--パスワードを間違えた際に注意書きを表示-->
            <div id = "check_caution" style="color: red;">
            </div>
        </div>
        
        <button class="btn btn-primary mx-auto" style ="display: block;" id="resistration_button">会員登録</button>
    </form>   
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    //セリフを喋らせる
    function NotionSerif(text){
    document.getElementById("charactor_serif").textContent = text;
    }

    //入力されたメールアドレスが問題無いかを確認
    function ValidateMailAddress(str){
        let reg = /[\w\-._]+@[\w\-._]+\.[A-Za-z]+$/
        return reg.test(str)
    }

       //入力されたパスワードが半角になっているかを確認
    function ValidateLowerPassword(str){
        return /^[\x20-\x7e]*$/.test(str);
    };

    //入力されたパスワードが数字が含まれているかを確認
    function ValidateNumberPassword(str){
        return /\d/.test(str);
    };

    //入力されたパスワードに記号が含まれているか確認
    function ValidateKigouPassword(str){
        var symbolPattern = /[!\"#$%&'()\*\+\,\-\.\/:;<=>?@\[\\\]^_`{|}~]/;
        return symbolPattern.test(str);
    };

    //入力されたパスワードにスペースが入っていないか確認
    function ValidateSpacePassword(str){
        var space = new RegExp(' ');
        return space.test(str);
    };

     //入力されたパスワードが8文字以上か確認
    function ValidateLengthPassword(str){
        if(str.length > 8){
            return true;
        }else{
            return false;
        };
    };

    //入力したパスワードと確認用で入力したパスワードが一致しているかを確認する関数
    function CheckPassword(str1, str2){
        if(str1 == str2){
            return true;
        }else{
            return false;
        };
    };


//パスワード入力欄と確認用パスワードが一致しているかを確認し、違っていたらメッセージを表示
$('#required') .on('input', function(){
    let password_input = $('#password').val();
    let password_kakunin = this.value;
    let message = "";
    let check_caution = document.getElementById('check_caution');
    if(!CheckPassword(password_input, password_kakunin)){
        message = "パスワードが一致しません";
    };
    check_caution.innerHTML = message;
})


    //入力されているパスワードに数字や記号が含まれていない場合注意書きを表示する
$('#password').on('input', function(){
    let password = this.value;
    let password_caution = document.getElementById('password_caution');
    //改行タグを生成
    let br_tag = document.createElement('br');
    
    let messages = [];  // メッセージの配列

    if(!ValidateLowerPassword(password)){
        messages.push("パスワードは半角にしてください");
    };
    if(!ValidateNumberPassword(password)){
        messages.push("パスワードに数字を入れてください");
    };
    if(!ValidateKigouPassword(password)){
        messages.push("パスワードに記号を入れてください");
    };
    if(ValidateSpacePassword(password)){
        messages.push("スペースは入れないでください");
    };
    if(!ValidateLengthPassword(password)){
        messages.push("パスワードは8文字以上にしてください");
    };

    //メッセージを表示
    password_caution.innerHTML = messages.join("<br>");
    });
        
    

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        });
    
$('#resistration_button').on('click', function(event){
    event.preventDefault(); // フォームの送信を中止

    if($('#username').val()==="" || $('#password')==="" || $('#mailaddress')===""){
        NotionSerif("あれれ、ユーザー名かメールアドレスかパスワードを書き忘れてるよ。書かないと登録できないよ")
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    }else if($('#required').val()===""){
        NotionSerif("確認用のところ入力してないね。そこ入力するの大事だよ。");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    }else if(!ValidateMailAddress($('#mailaddress').val())){
        NotionSerif("メールアドレスがおかしいね。ちゃんと入力した？");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    }else if($('#password').val()==="password"){
        NotionSerif("「password」は論外って言ったじゃん。話聞いてた？");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    }else if(!ValidateLowerPassword($('#password').val()) || !ValidateNumberPassword($('#password').val()) || !ValidateKigouPassword($('#password').val()) || ValidateSpacePassword($('#password').val()) || !ValidateLengthPassword($('#password').val())){
        NotionSerif("パスワードは半角英数字で記号もつけてね。スペースは入れないでね");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    //パスワードが確認用の欄と一致しているのか確認
    }else if(!CheckPassword($('#password').val(), $('#required').val())){
        NotionSerif("パスワードが一致していないよ");
        event.preventDefault(); // フォームの送信を中止
        return;// ここで return して処理を中断
    }else{

        // フォームのデータを取得
        var UserName = $('#username').val();
        var MailAddress = $('#mailaddress').val();
        var PassWord = $('#password').val();

    };

    $.ajax({
        type:"POST",
        url:"create_user.php",
        data:{
            UserName: UserName,
            MailAddress: MailAddress,
            PassWord: PassWord
        },
        success: function(response){
            if(response == "このメールアドレスは既に使われているよ。別のにしてね"){
                NotionSerif(response);
                event.preventDefault(); // フォームの送信を中止
                return false;// ここで return して処理を中断
                
            }else{
                //ログイン画面に遷移
            window.location.href = "entry.php";
            };
    
        },
        error: function(xhr, status, error){
            console.log("エラー："+error);
        }
    });
});

//}
NotionSerif("パスワードは半角英数字8文字以上で登録してね。「password」なんて論外だよ。");
</script>