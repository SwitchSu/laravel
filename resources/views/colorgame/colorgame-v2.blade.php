<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #F06060;
        }

        .first,
        .last {
            width: 100vw;
            height: 100vh;
            background-color: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .start,
        .again {
            width: 30%;
            height: 10%;
            font-size: 24px;
            border-radius: 15px;
        }

        .container {
            width: 100vw;
            height: 100vh;
            justify-content: center;
            align-items: center;
            display: none;
        }

        .nav {
            width: 100%;
            display: flex;
            position: fixed;
            justify-content: space-around;
            top: 5px;
            left: 0;
        }

        .plate {
            width: 500px;
            height: 500px;
            background-color: azure;
            gap: 15px;
            display: flex;
            flex-wrap: wrap;
            padding: 15px;
        }

        .box {
            width: calc((100% - 15px) / 2);
            height: calc((100% - 15px) / 2);
            background-color: aquamarine;
            border-radius: 10%;
            /* border: 5px solid #DDDDDD; */
        }

        .remain {
            text-align: center;
        }

        .timer {
            font-size: 30px;
        }

        .stop {
            width: 70px;
            height: 40px;
            font-size: 16px;
            border-radius: 15px;
        }

        .score {
            font-size: 24px;
        }

        .func {
            position: fixed;
            bottom: 10px;
        }

        .down-nav {
            width: 100px;
            height: 40px;
            font-size: 16px;
            margin: 0px 100px;
            border-radius: 15px;
        }

        .disappear {
            display: none;
        }

        .appear {
            display: flex;
        }
        .active{
            border: 10px solid yellow;
        }
    </style>
</head>

<body>
    <div class="first">
        <button type="button" class="start">開始</button>
    </div>
    <div class="container">
        <div class="nav">
            <span class="score">得分:0</span>
            <div class="remain">剩餘秒數<br><span class="timer">60s</span></div>
            <button type="button" class="stop">暫停</button>
        </div>
        <div class="plate">
        </div>
        <div class="func">
            <button type="button" class="down-nav hint">提示次數:3</button>
            <button type="button" class="down-nav restart">重新開始</button>
        </div>

    </div>
    <div class="last disappear">
        <p class="output"></p>
        <button type="button" class="again">再來一次</button>
    </div>
</body>
<script>
    const plate = document.querySelector('.plate');
    const box = document.querySelector('.box')
    const score = document.querySelector('.score')
    const btnStop = document.querySelector('.stop');
    const btnStart = document.querySelector('.start');
    const first = document.querySelector('.first');
    const container = document.querySelector('.container');
    const last = document.querySelector('.last');
    const btnRestart = document.querySelector('.restart');
    const btnAgain = document.querySelector('.again');
    const btnHint = document.querySelector('.hint');
    let timerText = document.querySelector('.timer');
    let output = document.querySelector('.output');
    let count = 0;
    let level = 1;
    let hintTimes = 3;

    addBoxes();
    // 點擊事件會獲得event，需自行寫變數取得
    plate.addEventListener('click', function (event) {
        if (!event.target.classList.contains('box', 'box-1')) return;

        if (event.target.classList.contains('ans')) {
            plate.innerHTML = '';
            count++;
            score.textContent = `得分:${count}`;
            addBoxes();
            // hint.classList.remove('active');
            if (count == scoreRecord(level)) {
                levelUp();
            }
        } else {
            alert('不夠認真扣你分!');
            // 答錯分數減少
            if (count < 2) {
                count = 0;
            } else {
                count -= 2;
            }
            score.textContent = `得分:${count}`;
            // 依據等級區間分數減少影響等級
            if (count < scoreRecord(level - 1)) {
                levelDown();
            }
        }

    })
    let totalTime = 59;
    let timer;
    // 控制開關
    let flag = true;
    btnStart.addEventListener('click', startTime);
    function startTime() {
        first.classList.add('disappear');
        container.classList.add('appear');
        if (!flag) return;
        timer = setInterval(function () {
            timerText.textContent = `${totalTime}s`;
            if (totalTime <= 0) {
                clearInterval(timer);
                container.classList.remove('appear');
                last.classList.remove('disappear');
                if(level === 1){
                    output.innerHTML = `這才level.1而已，加油好嗎`;
                } else if(level === 2){
                    output.innerHTML = `摁...是level.2喔，再接再厲`;
                } else if(level === 3){
                    output.innerHTML = `是level.3的程度，可以再更好`;
                } else if(level === 4){
                    output.innerHTML = `level.4，這是應該的`;
                } else if(level === 5){
                    output.innerHTML = `level.5，似乎還不錯`;
                } else if(level === 6){
                    output.innerHTML = `來到level.6，好像很厲害`;
                } else if(level === 7){
                    output.innerHTML = `哦，level.7，給你一個大拇指`;
                } else if(level === 8){
                    output.innerHTML = `哇!level.8是孫悟空了吧!`;
                } else{
                    output.innerHTML = `看來你已不是凡人了`;
                }
            }
            totalTime--;
        }, 1000)
        flag = false;
    }

    btnStop.addEventListener('click', function () {
        if (flag) return;
        clearInterval(timer);
        flag = true;
        first.classList.remove('disappear');
        container.classList.remove('appear');
    })
    btnHint.addEventListener('click', function () {
        if(hintTimes === 0) return;
        let hint = document.querySelector('.ans');
        hint.classList.add('active');
        hintTimes--;
        btnHint.textContent = `提示次數:${hintTimes}`;
    })
    // btnRestart.addEventListener('click', function () {
    //     location.reload();
    // });
    btnRestart.addEventListener('click', replay);
    // btnAgain.addEventListener('click', function(){
    //     location.reload();
    // });
    btnAgain.addEventListener('click', replay);
    function addBoxes() {
        plate.innerHTML = '';
        let inc = boxAdd(level);
        const ansNum = getRandomInt(inc, 0)
        let wh = boxRange(level);
        let op = levelOp(level);
        let r = getRandomInt(255, 1);
        let g = getRandomInt(255, 1);
        let b = getRandomInt(255, 1);
        // rgb(255, 255,255)時重設
        while (r == 255 && g == 255 && b == 255) {
            r = getRandomInt(255, 1);
            g = getRandomInt(255, 1);
            b = getRandomInt(255, 1);
        }
        for (i = 0; i < inc; i++) {
            if (i == ansNum) {
                plate.innerHTML += `<div class="box ans" style="width:${wh}px; height:${wh}px; background-color: rgb(${r}, ${g}, ${b}); opacity:${op};"></div>`
            } else {
                plate.innerHTML += `<div class="box" style="width:${wh}px; height:${wh}px; background-color: rgb(${r}, ${g}, ${b});"></div>`
            }
        }
    }

    function getRandomInt(max, min) {
        return Math.floor(Math.random() * max) + min;
    }
    function boxRange(lv) {
        return ((470 - 15 * lv) / (lv + 1));
    }
    function boxAdd(lv) {
        return (lv + 1) * (lv + 1);
    }
    function scoreRecord(lv) {
        return lv * 5;
    }
    function levelUp() {
        level++;
        addBoxes();
    }
    function levelDown() {
        level--;
        addBoxes();
    }
    function levelOp(lv) {
        if (lv < 7) {
            return lv * 0.1 + 0.2;
        } else {
            return 0.8;
        }
    }
    function replay() {
        timerText.textContent = `60s`;
        totalTime = 59;
        clearInterval(timer);
        flag = true;
        count = 0;
        score.textContent = `得分:${count}`;
        level = 1;
        addBoxes();
        first.classList.remove('disappear');
        container.classList.remove('appear');
        last.classList.add('disappear');
    }

    //作業需求 1.得分，需顯示在畫面上 2.要依據得分，增加等級
    //        3.答案透明度愈來愈不透明(0.3~0.6)  4.進入遊戲時顏色不能固定(不能都是255)
    //        5.承4.，選到正解要能換色換答案   6.選錯要有懲罰

    //挑戰(11/21檢討):1.設置開始頁面 ok  2.計時器考察，嘗試加入計時器 ok
    //    3.承上，加入暫停與再開功能 ok 4.時間到需顯示分數及評語 ok
    //    5.提示功能:提示答案位置(可設置使用次數) 6.有重新遊玩功能 ok
</script>

</html>