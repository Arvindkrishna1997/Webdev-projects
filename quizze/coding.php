<script>
    function nextq()
    {  //alert("came to nextq");
        var xhttp=new XMLHttpRequest();
        var formdata=new FormData();
        formdata.append('query',"nextq");


        xhttp.onreadystatechange=function()
        {//alert(xhttp.status+"  "+xhttp.readyState);
            if(xhttp.status==200&&xhttp.readyState==4)
            {   //alert("<p>" + xhttp.responseText + "</p>");
                if(xhttp.responseText) {

                    if (xhttp.responseText == "finish") {
                        alert("You win");
                        window.location.href = "quizup.php";
                        document.getElementById("title").innerHTML = "";
                        document.getElementById("question").innerHTML = "";
                        document.getElementById("inputformat").innerHTML = "";
                        document.getElementById("outputformat").innerHTML = "";
                        document.getElementById("sampleinput").innerHTML = "";
                        document.getElementById("sampleoutput").innerHTML = "";
                        document.getElementById("wrong").innerHTML = "";
                        document.getElementById("textarea").innerHTML = "";

                    }

                    else {


                        document.getElementById("question").innerHTML = xhttp.responseText;
                        document.getElementById("wrong").innerHTML = " ";
                        document.getElementById("textarea").innerHTML = " ";
                        window.location.href="reload.php";
                    }


                }
            }
        };
        xhttp.open("POST","nextquestion.php",true);
        xhttp.send(formdata);
    }</script>
<?php
session_start();
$wrong="";
$error="";
$source="";
if($_SERVER["REQUEST_METHOD"] !=="POST") {
    if(!isset($_SESSION["question"])) {
        $_SESSION["title"]="";
        $_SESSION["question"] = "";
        $_SESSION["inputformat"]="";
        $_SESSION["outputformat"]="";
        $_SESSION["sampleinput"]="";
        $_SESSION["sampleoutput"]="";
        $_SESSION['quesno'] = 0;
        $_SESSION["answerinput"] = -1;
        $_SESSION["answeroutput"]= -1;
        $_SESSION["score"] = 0;
       
    }
}

if($_SERVER["REQUEST_METHOD"]==="POST")
{   // echo "<script>alert('came to post');</script>";
    $lang=$_POST["lang"];
    $source=$_POST["source"];
    $wrong="";
    $error="";
    $answerinput=$_SESSION["answerinput"];
    $file=fopen("input.txt","w");
    fwrite($file,$answerinput);
    if($lang==="c")
    {
        $myfile=fopen("program.c","w");
        fwrite($myfile,$source);
        exec("del program.exe");
        $array="";
        exec("gcc program.c -o program.exe 2>&1",$array);
        if($array)
            $error="yes";
        else
        {
            $out=shell_exec("program.exe < input.txt");
            if($out===$_SESSION["answeroutput"]) {
                $source="";
                echo "<script>nextq();</script>";
                $_SESSION["score"]++;
                $wrong="correct";
            }
            else
                $wrong="Wrong answer";
        }

    }
    else if($lang==="c++")
    {
        $myfile=fopen("programcplus.cpp","w");
        fwrite($myfile,$source);
        exec("del programcplus.exe");
        $array="";
        exec("g++ programcplus.cpp -o programcplus.exe 2>&1",$array);
        if($array)
            $error="yes";
        else
        {
            $out=shell_exec("programcplus.exe < input.txt");
            if($out===$_SESSION["answeroutput"])
            {   $source="";
                echo "<script>nextq();</script>";
             $_SESSION["score"]++;
                $wrong="correct";
            }
            else
                $wrong="Wrong answer";

        }

    }
}?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="coding.css" type="text/css">
    <title>code quiz</title>
</head>
<body >
<h2>Code your way out</h2>
<h3 id="title"><?php echo $_SESSION["title"]; ?></h3>
<br/>
<div id="question"><?php echo $_SESSION["question"]; ?></div>
<div id="input">
    <div id="inputtext"><strong>InputFormat</strong></div>
    <div id="inputformat"><?php echo $_SESSION["inputformat"]; ?></div>
</div>   
<div id="output">
    <div id="outputtext"><strong>OutputFormat</strong></div>
    <div id="outputformat"><?php echo $_SESSION["outputformat"]; ?></div>
</div>
<div id="samplein">
    <div id="intext"><strong>SampleInput</strong></div>
    <div id="sampleinput"><?php echo $_SESSION["sampleinput"]; ?></div>
</div> 
<div id="sampleout">
    <div id="outtext"><strong>SampleOutput</strong></div>
    <div id="sampleoutput"><?php echo $_SESSION["sampleoutput"]; ?></div>
</div>    
<form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
    Language:<select id="lang" name="lang">
        <option value="c" name="c">c</option>
        <option name="c++" value="c++" selected>c++</option>
    </select>
    <br/><br/>
    <textarea cols="100" rows="20" name="source" id="textarea" spellcheck="false" placeholder="Paste your code here"><?php echo $source; ?></textarea>
    <br/>
    <input type="submit" value="Submit Code">
</form>
<div id="score"><?php echo "Score: ".$_SESSION["score"]; ?></div>
<div id="error"><?php if($error==="yes"){echo "<br/>Compilation Errors<br/>";var_dump($array);}?></div>
<div id="wrong"><?php echo $wrong; ?></div>
<script>
   var q=<?php echo $_SESSION["quesno"]; ?>;
    if(q==0)
     {
        //alert("firstq"+<?php echo $_SESSION["quesno"]; ?>);
        nextq();
    }
    window.onblur=function(){
        alert("To avoid cheating please stay on the same tab");

    };

</script>
</body>
</html>
