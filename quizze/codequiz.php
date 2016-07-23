<?php
session_start();

$_SESSION['quesno']=1;
$_SESSION["answer"]=-1;
$_SESSION["score"]=0;
?>
<!DOCTYPE html>
    <html>
<head>
    <meta charset="UTF-8">
    <title>code quiz</title>
</head>
<body onload="init()">
<h2>Code your way out</h2>
<div id="question"></div>
<form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Language:<select id="lang" name="lang">
        <option value="c" name="c">c</option>
        <option name="c++" value="c++" selected>c++</option>
    </select>
    <br/>
    <textarea cols="100" rows="20" name="textarea" id="textarea" placeholder="Paste your code here"></textarea>
    <input type="submit" value="submit">
</form>
<div id="score"></div>
<div id="correct"></div>

<script>
    var sourcecode,answer,lang;
    function init(){
        alert("came here to init");
        checkanswer('qa');
    }
    document.getElementById("form").addEventListener("submit",function(e){
       e.preventDefault();
        alert("came to submit");
        answer=document.getElementById("textarea").value;
        lang=document.getElementById("lang").value;
        checkanswer(answer,lang);
    });
    
    
    
    function checkanswer(answer,lang){
       /* if(array.answer==answer)
            score++;
        else {

            document.getElementById("correct").innerHTML="Wrong Answer";
            return;
        }*/
        alert("came to check");
        var xhttp=new XMLHttpRequest();
        var formdata=new FormData();
        formdata.append('answerselected',answer);
        formdata.append('lang',lang);
        // var formdata={"optionselected":option};
        xhttp.onreadystatechange=function(){
            if(xhttp.status==200&&xhttp.readyState==4)
            {  //alert(xhttp.responseText+"res");
                if(xhttp.responseText)
                {  alert(xhttp.responseText);
                    array=JSON.parse(xhttp.responseText);
                    alert(array.array+array.Response);
                    getdetails(array);
                }
            }
        };
        xhttp.open("POST","checkanswer.php",true);
        xhttp.send(formdata);

    }
    function getdetails(array)
    {
        if(array.Response=="True")
        {

            document.getElementById("question").innerHTML =array.question ;
            document.getElementById("textarea").innerHTML =" ";


        }
        if(array.Response=="finish")
        {
            document.getElementById("score").innerHTML="Score:  "+score;
            alert("Your score is  "+score);
            window.location.href="quizup.php";
            document.getElementById("question").style.display="none";
            document.getElementById("form").style.display ="none";

        }
        document.getElementById("score").innerHTML="Score:  "+<?php echo $_SESSION["score"]; ?>;


    }
</script>
</body>
</html>

