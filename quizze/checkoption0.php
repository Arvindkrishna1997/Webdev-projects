<?php
session_start();
?>
<?php
$optionselected=$_POST["optionselected"];
$quesno=$_SESSION["quesno"];
$servername="localhost";
$username="root";
$password="";
$database="quizdb";
$conn= new mysqli($servername,$username,$password,$database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo $quesno;
$sql="SELECT * FROM physcis WHERE id='$quesno'";
$result=$conn->query($sql);
if($result->num_rows>0)
{
    while($row=$result->fetch_assoc())
    {
        if($quesno==$row["id"])
        {
            if($optionselected===$row['answer']) {
                echo "True";
                $_SESSION["quesno"]++;
            }
            else
                echo $row["answer"];
            
        }    
        
            
    }

}
$conn->close();
?>