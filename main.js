//朝、昼、夜でキャラクターの吹き出しを変える

let Charactor_Serif_Morning = [
                            "今日の一言：ゆく川の流れは絶えずしてしかも元の水にあらず",
                            "おはよう。あいさつは大事だよ。古事記にもそう書かれている。",
                            "朝だね。むかつくぐらいに良い朝だ",
                            "早起きは三文の徳？三文あげるからもうちょっと寝させて・・・。",
                            "僕にとって目覚ましの音ってのは終末を告げるラッパの音だよ。"
                            ]

let Charactor_Serif_Afternoon = [
                            "お昼だね。今日は何食べたの？僕にも分けてくれない？",
                            "お昼だね。三度の飯より～って言葉があるけど三度の飯に勝るものはないよ。",
                            "なんとか午前の忙しい時間を乗り越えたね。でもここからがまあまあ長いよね。",
                            "お昼だね。お昼寝したいね。でもご飯食べる時間無くなっちゃうや。",
                            "お昼時間の電子レンジの混み具合何とかならないかな",
]

let Charactor_Serif_Evening = [
                            "夜だね。夜なんて明けなけりゃいいのにね。",
                            "夜の時間の感覚が鋭くなってるあの感じ、朝の僕には喉から手が出るくらい欲しいよ",
                            "お仕事お疲れ。こんな時間にタスク整理だなんて偉いね。",
                            "今日の夜ご飯は何にしようかな。牛丼にしようかな。",
                            "こんな時間にタスク整理？偉いね。"
                            ]

let Add_Task_Serif = [
                            "お、新しいタスク追加したんだね。いいね。",
                            "よし、タスクを期限内に終わらせられるように僕が応援するね。",
                            "タスクが終わったと思ったらまたタスク。本当にすごいよ君は。",
                            "やるべきタスクを決めたんだね。君ならきっとちゃんと出来るさ。",
                            "君に出来ないタスクなんて無いさ。僕が一番わかっているよ。"
                            ]

let Complete_Task_Serif = [
                    "タスク完了おめでとう！！めんどくさいのが消えたね！！",
                    "よし、タスク終わったご褒美にアイスでも食べちゃおうよ！！",
                    "君ならどんなタスクも終わらせるって信じてたよ。",
                    "ふう。タスク終わったね。お茶でも飲むかい？",
                    "タスクが終わったんだね。君なら出来ると信じていたよ。",
]


//現在の時間を取得
const hour = new Date().getHours();

// この変数で現在のタイムアウトを保持
let currentTimeout;

//6時~11時59分　朝だったら「朝のセリフリスト」からランダムにセリフを表示させる
function setCharactorSerif() {
    let rand_num = Math.floor(Math.random()*4);

    if(6<=hour && hour<12){
    document.getElementById("charactor_serif").textContent = Charactor_Serif_Morning[rand_num];
//12時~17時59分　昼だったら「昼のセリフリスト」からランダムにセリフを表示させる
}else if(12<=hour && hour<18){
    document.getElementById("charactor_serif").textContent = Charactor_Serif_Afternoon[rand_num];
//18時~5時59分　夜だったら「夜のセリフリスト」からランダムにセリフを表示させる
}else{
    document.getElementById("charactor_serif").textContent = Charactor_Serif_Evening[rand_num];
}

}    

//タスク完了をクリックしたらキャラクターの吹き出しにセリフを表示、時間経過で元に戻す
function TaskCompleteSerif(){
    let rand_num = Math.floor(Math.random()*4);
    document.getElementById("charactor_serif").textContent = Complete_Task_Serif[rand_num];
    setTimeout(() => {setCharactorSerif()}, 100000);
}

//タスク追加iをクリックしたらキャラクターの吹き出しにセリフを表示、時間経過で元に戻す
function TaskAddSerif(){

    let rand_num = Math.floor(Math.random()*4);
    document.getElementById("charactor_serif").textContent = Add_Task_Serif[rand_num];
    setTimeout(() => {setCharactorSerif()}, 100000);
}

function NotionSerif(text){
    document.getElementById("charactor_serif").textContent = text;
}

//キャラクターのセリフを初期化
setCharactorSerif();