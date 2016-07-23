<?php
session_start();
session_unset();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Choose mode</title>
    <link rel="stylesheet" type="text/css" href="quizup.css">
</head>
<body onload="swipe()">
    <div id="myModal" class="modal">
        <div id="container">
        <div id="modal-content" class="modal-content">
             <br/>
            swipe hands to start!!!
        </div>
            </div>
    </div>
    <div id="up" class="box" onclick="code()">code your way out</div>
    <br/>
    <div id="left" class="box">rapid fire</div>
    <div id="right" class="box">Take a Break,Play Mario</div>
    <br/>
    <div id="down" class="box">challenge a player</div>
</body>
<script type="text/javascript" src="gest.min.js"></script>
<script>
    function code(){window.location.href='coding.php';}
    var modal=document.getElementById("myModal");
    function swipe() {
        modal.style.display = "block";
        gest.start();
    }

    gest.options.subscribeWithCallback(function(gesture) {
            if (gesture.direction && modal.style.display === "block") {
                modal.style.display = "none";
            }

        if(modal.style.display == "none") {
            gest.start();
            if (gesture.up)window.location.href="coding.php";
            if (gesture.down)window.location.href="player.php";
            if (gesture.left)window.location.href="rapidfire.php";
            if (gesture.right)window.location.href="mygame.html";
        }
                });
</script>
</html>