<?php
session_start();
$_SESSION["quesno"]=0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multi-player</title>
    <script src="https://cdn.couchfriends.com/api/couchfriends.api-latest.js"></script>
    <link rel="stylesheet" type="text/css" href="player.css">
</head>
<body>
<h2>Multi-Player Quiz</h2>

        <div id="question"></div>

<div id="container" >
    <hr>
        <div id="optiona" ></div>
        <br/>
        <div id="optionb" ></div>
        <br/>
        <div id="optionc" ></div>
        <br/>
        <div id="optiond" ></div>
    </div>
    <br/>
    <div id="win"></div>
   <script>

    var name=0;
    var correctanswer;
    var questionno=0;
    COUCHFRIENDS.settings.apiKey = '<your couchfriends.com api key>';
    COUCHFRIENDS.settings.host = 'ws.couchfriends.com';
    COUCHFRIENDS.settings.port = '80';
    COUCHFRIENDS.connect();

    var  players=[];
    COUCHFRIENDS.on('connect', function() {

        var jsonData = {
            topic: 'game',
            action: 'host',
            data: {
                sessionKey: ''
            }
        };
        COUCHFRIENDS.send(jsonData);
    });
    COUCHFRIENDS.on('playerJoined', function(data) {
        
        if(questionno===0 ) {
            checkoption('firstq', -2);
           // alert("came here");
        questionno++;
        }
        var clientId = data.id;
      var  player1=new player(clientId);
        players.push(player1);
    });

    COUCHFRIENDS.on('playerLeft', function(data) {
        for (var i = 0; i < players.length; i++) {
            if (players[i].clientId == data.id) {
                players.splice(i,1);
            }
        }
    });
    COUCHFRIENDS.on('playerOrientation',function(data){
       if(document.getElementById("win").innerHTML!=="")
           window.location.href="quizup.php";
    });
    function player(id)
    {
        this.clientId=id;
        this.score=0;
        this.name1=++name;
        this.wrong=0;
    }
    COUCHFRIENDS.on('buttonUp', function(data) {
        console.log('Player pressed button. Player id: ' + data.playerId + ' Button: ' + data.id);
       // alert("player  "+data.playerId+ 'button: '+data.id);
        if(data.id=='y'&&document.getElementById("win").innerHTML=="") {
            document.getElementById("optiona").className = "selected";
            document.getElementById("optionb").className = "option";
            document.getElementById("optionc").className = "option";
            document.getElementById("optiond").className = "option";

            checkoption('optiona', data.playerId);
        }
        else if(data.id=='a'&&document.getElementById("win").innerHTML=="")
        {document.getElementById("optiona").className="option";
            document.getElementById("optionb").className="option";
            document.getElementById("optionc").className="option";
            document.getElementById("optiond").className="selected";
            checkoption('optiond', data.playerId);
        }
        else if(data.id=='x'&&document.getElementById("win").innerHTML=="")
        {
            document.getElementById("optiona").className="option";
            document.getElementById("optionb").className="selected";
            document.getElementById("optionc").className="option";
            document.getElementById("optiond").className="option";
            checkoption('optionb', data.playerId);
        }
        else if(data.id=='b'&&document.getElementById("win").innerHTML=="")
        {
            document.getElementById("optiona").className="option";
            document.getElementById("optionb").className="option";
            document.getElementById("optionc").className="selected";
            document.getElementById("optiond").className="option";
            checkoption('optionc', data.playerId);
        }
       
    });
    function checkoption(option,playerId)
    {  // alert(option+"  "+playerId);
        setTimeout(function() {
                var xhttp = new XMLHttpRequest();
                var formdata = new FormData();
                formdata.append("optionselected", option);
                xhttp.onreadystatechange = function () {
                    if (xhttp.status == 200 && xhttp.readyState == 4)
                    //alert("came here");
                        if (xhttp.responseText) {
                           // alert(xhttp.responseText);

                            var array = JSON.parse(xhttp.responseText);
                            // alert(array);

                            if (array.Response === "True" || array.Response === "finish")  //document.getElementById(option).className = "correct";
                                for (var i = 0; i < players.length; i++) {
                                    if (players[i].clientId == playerId) {
                                        players[i].score++;
                                        break;
                                    }
                                }

                            if (array.Response === "False") {
                                document.getElementById(option).className = "wrong";
                                for (i = 0; i < players.length; i++) {
                                    if (players[i].clientId == playerId) {
                                        players[i].wrong = 1;
                                        break;
                                    }
                                }
                                wrong = 0;
                                for (i = 0; i < players.length; i++) {
                                    if (players[i].wrong)
                                        wrong++;
                                }
                                //alert("wrong : "+wrong+ "playerslenght "+players.length);
                                if (wrong == players.length)
                                {   document.getElementById(array.answer).className="correct";
                                    correctanswer=array.answer;
                                    checkoption("nextq", -1);
                                }
                            }

                            getDetails(array);
                        }


                };
                xhttp.open("POST", "checkoption.php", true);
                xhttp.send(formdata);
            }

        ,1000);
    }

    function getDetails(array){       //A function the assign the datas. 
        if(array.Response==="True") {
          //alert("came to getdetails   "+array);

            document.getElementById("question").innerHTML =array.question ;
            document.getElementById("optiona").innerHTML =array.optiona;
            document.getElementById("optionb").innerHTML = array.optionb;
            document.getElementById("optionc").innerHTML =array.optionc;
            document.getElementById("optiond").innerHTML=array.optiond;
            document.getElementById("optiona").className="option";
            document.getElementById("optionb").className="option";
            document.getElementById("optionc").className="option";
            document.getElementById("optiond").className="option";
            
            for(i=0;i<players.length;i++)
            {
                players[i].wrong=0;

            }
        }
       if(array.Response==="finish")
       {document.getElementById("question").innerHTML ="";
           document.getElementById("optiona").className = "blank";
           document.getElementById("optionb").className = "blank";
           document.getElementById("optionc").className = "blank";
           document.getElementById("optiond").className = "blank";
           for (var i = 0; i < players.length; i++) {
               //alert(players[i].name1+"   "+players[i].score);
               document.getElementById("win").innerHTML+="Player "+players[i].name1+"     Score :"+players[i].score+"<br/>";
           }
           document.getElementById("win").innerHTML+="Move controller randomly to go back to home page.";
       }

    }
</script>



</body>
</html>
