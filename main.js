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
                            "テスト昼4",
                            "テスト昼5",
]

let Charactor_Serif_Evening = [
                            "夜だね。",
                            "テスト夜2",
                            "テスト夜3",
                            "テスト夜4",
                            "テスト夜5"
                            ]
let Add_Task_Serif = [
                    "タスク追加テスト1",
                    "タスク追加テスト2",
                    "タスク追加テスト3",
                    "タスク追加テスト4",
                    "タスク追加テスト5"
                ]

let Complete_Task_Serif = [
                    "タスク完了テスト1",
                    "タスク完了テスト2",
                    "タスク完了テスト3",
                    "タスク完了テスト4",
                    "タスク完了テスト5",
]
//0~4のランダムな数字を作成

//現在の時間を取得
const hour = new Date().getHours();

// この変数で現在のタイムアウトを保持
let currentTimeout;

//6時~11時59分　朝だったら「朝のセリフリスト」からランダムにセリフを表示させる
function setCharactorSerif() {
    let rand_num = Math.floor(Math.random()*4);

    if(6<=hour && hour<12){
    document.getElementById("charactor_serif").textContent = Charactor_Serif_Morning[rand_num];
//12時~17時59分　昼だったら「朝のセリフリスト」からランダムにセリフを表示させる
}else if(12<=hour && hour<18){
    document.getElementById("charactor_serif").textContent = Charactor_Serif_Afternoon[rand_num];
//18時~5時59分　夜だったら「朝のセリフリスト」からランダムにセリフを表示させる
}else{
    document.getElementById("charactor_serif").textContent = Charactor_Serif_Evening[rand_num];
}

//currentTimeout = setTimeout(() => setCharactorSerif(), 5000);
}    

//タスク完了をクリックしたらキャラクターの吹き出しにセリフを表示、時間経過で元に戻す
function TaskCompleteSerif(){
    let rand_num = Math.floor(Math.random()*4);
    document.getElementById("charactor_serif").textContent = Complete_Task_Serif[rand_num];
    setTimeout(() => {setCharactorSerif()}, 5000);
}

//タスク追加をクリックしたらキャラクターの吹き出しにセリフを表示、時間経過で元に戻す
function TaskAddSerif(){
    let rand_num = Math.floor(Math.random()*4);
    document.getElementById("charactor_serif").textContent = Add_Task_Serif[rand_num];
    setTimeout(() => {setCharactorSerif()}, 100000);
}


//キャラクターのセリフを初期化
setCharactorSerif();