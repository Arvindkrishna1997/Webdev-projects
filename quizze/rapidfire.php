<?php
session_start();
$_SESSION["quesno"]=0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rapid Fire</title>
    <link rel="stylesheet" type="text/css" href="rapidfire.css">
</head>
<body onload="init()">
<h2>Rapid Fire Round</h2>
<div id="timerbox">
    <div id="second" class="timer_box" >
        <span id="secondNumber" class="timerNumber"></span>
        <div class="timerText">Seconds</div>
    </div>

</div>
<br/>
<div id="question"></div>
<br/>
<button id="optiona" onclick="buttonA()"></button>
<br/>
<button id="optionb" onclick="buttonB()"></button>
<br/>
<button id="optionc" onclick="buttonC()"></button>
<br/>
<button id="optiond" onclick="buttonD()"></button>
<div id="score"></div>

<div id="win"></div>
<script>
    var second=60;
    var array=0;
    var score=0;
    var time=setInterval(timer,1000);
    function timer()
    {
        if(second==0)
        {clearInterval(time);stop=1;
            alert("Your score is  "+score);
            window.location.href="quizup.php";
        }
        else
            second--;
        document.getElementById("secondNumber").innerHTML=second;

    }

    function init(){
    checkoption('qa');
   // alert("came here");
        }
    function buttonA(){
      checkoption('optiona');
    }
    function buttonB(){
        checkoption('optionb');
    }
    function buttonC(){
        checkoption('optionc');
    }
    function buttonD(){
        checkoption('optiond');
    }
    function checkoption(option){
        if(array.answer==option)
            score++;
        var xhttp=new XMLHttpRequest();
        var formdata=new FormData();
        formdata.append('optionselected',option);
      // var formdata={"optionselected":option};
        xhttp.onreadystatechange=function(){
            if(xhttp.status==200&&xhttp.readyState==4)
            {
                if(xhttp.responseText)
                {  //alert(xhttp.responseText);
                     array=JSON.parse(xhttp.responseText);

                    getdetails(array);
                }
            }
        };
        xhttp.open("POST","checkoption1.php",true);
        xhttp.send(formdata);

    }
    function getdetails(array)
    {
        if(array.Response=="True")
        {

            document.getElementById("question").innerHTML =array.question ;
            document.getElementById("optiona").innerHTML =array.optiona;
            document.getElementById("optionb").innerHTML = array.optionb;
            document.getElementById("optionc").innerHTML =array.optionc;
            document.getElementById("optiond").innerHTML=array.optiond;
            document.getElementById("optiona").className="";
            document.getElementById("optionb").className="";
            document.getElementById("optionc").className="";
            document.getElementById("optiond").className="";

        }
        if(array.Response=="finish")
        {  clearInterval(time);stop=1;
            document.getElementById("score").innerHTML="Score:  "+score;
            alert("Your score is  "+score);
            window.location.href="quizup.php";
            document.getElementById("question").style.display="none";
            document.getElementById("optiona").style.display ="none";
            document.getElementById("optionb").style.display ="none";
            document.getElementById("optionc").style.display ="none";
            document.getElementById("optiond").style.display ="none";
        }
        document.getElementById("score").innerHTML="Score:  "+score;
    }
</script>
</body>
</html>