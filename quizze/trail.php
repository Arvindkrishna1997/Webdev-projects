
<?php
session_start();

?>
<?php
$optionselected=$_POST["optionselected"];
$quesno=$_SESSION["quesno"];
$servername="localhost";
$username="root";
$password="";
$database="quizDB";
$conn= new mysqli($servername,$username,$password,$database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if($quesno)
    $sql="SELECT * FROM physics WHERE id='$quesno' ";
else { $quesno++;
    $sql = "SELECT * FROM physics WHERE id='$quesno' ";
}
    $result=$conn->query($sql);
if($result->num_rows>0)
{
    while($row=$result->fetch_assoc())
    {
        if($quesno==$row["id"])
        {
            if($optionselected===$row['answer']||$optionselected=="nextq"||$optionselected=="firstq") {
                $_SESSION["quesno"]++;
                $quesno=$_SESSION["quesno"];
                $sql1 = "SELECT * FROM physics WHERE id='$quesno'";
                $result1 = $conn->query($sql1);
                $flag=0;
                if ($result1->num_rows > 0) {
                    // output data of each row
                    while($row1 = $result1->fetch_assoc()) {
                        if($row1["id"]== $quesno)
                        {   echo "{\"quesno\":\"".$quesno."\"\"question\":\"".$row1['question']."\",\"optiona\":\"".$row1['optiona']."\",\"optionb\":\"".$row1['optionb']."\",\"optionc\":\"".$row1['optionc']."\",\"optiond\":\"".$row1['optiond']."\",\"Response\":\"True\"}";
                            $_SESSION["answer"]=$row1["answer"];
                            $flag=1;
                        }
                    }

                }
                if($flag==0)
                {
                    echo "{\"Response\":\"finish\"}";
                }

            }
            else
                echo "{\"answer\":\"".$row['answer']."\",\"Response\":\"False\"}";

        }


    }

}
$conn->close();
?>