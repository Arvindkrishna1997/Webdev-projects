<?php
session_start();
?>
<?php
$quesno=++$_SESSION["quesno"];
$servername="localhost";
$username="root";
$password="";
$database="quizDB";
$conn= new mysqli($servername,$username,$password,$database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT * FROM physcis WHERE id='$quesno' ";
$result=$conn->query($sql);
$flag=0;
if($result->num_rows>0) {
    while ($row = $result->fetch_assoc()) {
        if ($quesno == $row["id"]) {
            echo "{\"question\":\"" . $row['question'] . "\",\"optiona\":\"" . $row['optiona'] . "\",\"optionb\":\"" . $row['optionb'] . "\",\"optionc\":\"" . $row['optionc'] . "\",\"optiond\":\"" . $row['optiond'] . "\",\"Response\":\"True\"}";
            $_SESSION["answer"] = $row["answer"];
            $flag = 1;
        }
        if ($flag == 0)
            echo "{\"Response\":\"finish\"}";

    }
}
$conn->close();
?>