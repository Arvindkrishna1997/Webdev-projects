<?php
session_start();
$_SESSION['quesno']++;
$question=$_SESSION["quesno"];
$servername="localhost";
$usename="root";
$password="";
$dbname="quizdb";
$conn=new mysqli($servername,$usename,$password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT * FROM coding WHERE id='$question'";
$result=$conn->query($sql);
$flag=0;
if($result->num_rows>0)
{
    while($row=$result->fetch_assoc())
    {
        $_SESSION["question"]=$row["question"];
        $_SESSION["answerinput"]=$row["answerinput"];
        $_SESSION["answeroutput"]=$row["answeroutput"];
        $_SESSION["title"]=$row["title"];
        $_SESSION["inputformat"]=$row["inputformat"];
        $_SESSION["outputformat"]=$row["outputformat"];
        $_SESSION["sampleinput"]=$row["sampleinput"];
        $_SESSION["sampleoutput"]=$row["sampleoutput"];
            echo "{\"title\":\"".$row['title']."\",\"question\":\"".$row['question']."\",\"inputformat\":\"".$row['inputformat']."\",\"outputformat\":\"".$row['outputformat']."\",\"sampleinput\":\"".$row['sampleinput']."\",\"sampleoutput\":\"".$row['sampleoutput']."\",\"Response\":\"True\"}";
        $flag=1;
    }
}
if($flag==0)
    echo "finish";
$conn->close();
?>