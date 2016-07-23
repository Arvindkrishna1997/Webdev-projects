<?php
session_start();
?>
<?php 
$answerselected=$_POST["answerselected"];
$lang=$_POST["lang"];
if($answerselected!="qa")
{
    if($lang==='c')
    {
        $myfile=fopen("program.c","w");
        fwrite($myfile,$answerselected);
        exec("del program.exe");
        $array="";
        exec("gcc  program.c -o program.exe 2>&1",$array);
        if($array)
            echo "{\"Response\":\"wrong\",\"array\":\"".print_r($array)."\"}";

        $out=exec("program.exe");

    }

    
}
/*
$quesno=$_SESSION["quesno"];
$servername="localhost";
$username="root";
$password="";
$database="quizDB";
$conn= new mysqli($servername,$username,$password,$database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

*/