<?php
session_start();

?>
<?php
$optionselected=$_POST["optionselected"];
$quesno=$_SESSION["quesno"];
if(!isset($_SESSION["ques"]))
{
    $array=array(1,2,3,4,5,6,7,8,9,10);
    for($i=0;$i<10;$i++)
    {
        $j=mt_rand(0,9);
        $tmp=$array[$j];
        $array[$j]=$array[$i];
        $array[$i]=$tmp;
    }
    $_SESSION["ques"]=$array;
}
if($_SESSION["quesno"]<10)
    $quesno=$_SESSION["ques"][$_SESSION["quesno"]];
else
    $quesno=100;
$servername="localhost";
$username="root";
$password="";
$database="quizDB";
$conn= new mysqli($servername,$username,$password,$database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT * FROM physics WHERE id='$quesno' ";

    $result=$conn->query($sql);
if($result->num_rows>0)
{
    while($row=$result->fetch_assoc())
    {
        if($quesno==$row["id"])
        {
            if($optionselected===$row['answer']||$optionselected=="nextq"||$optionselected=="firstq") {
                $_SESSION["nextq"]=0;
                $_SESSION["quesno"]++;
                if($_SESSION["quesno"]<10)
                    $quesno=$_SESSION["ques"][$_SESSION["quesno"]];
                else
                    $quesno=100;
                $sql1 = "SELECT * FROM physics WHERE id='$quesno'";
                $result1 = $conn->query($sql1);
                 $flag=0;
                if ($result1->num_rows > 0) {
                    // output data of each row
                    while($row1 = $result1->fetch_assoc()) {
                        if($row1["id"]== $quesno)
                        {   echo "{\"qno\":\"".$_SESSION['quesno']."\",\"question\":\"".$row1['question']."\",\"optiona\":\"".$row1['optiona']."\",\"optionb\":\"".$row1['optionb']."\",\"optionc\":\"".$row1['optionc']."\",\"optiond\":\"".$row1['optiond']."\",\"Response\":\"True\"}";
                            $_SESSION["answer"]=$row1["answer"];
                            $flag=1;
                        }
                    }

                }
                if($flag==0)
                {
                    echo "{\"qno\":\"".$quesno."\",\"qno\":\"".$_SESSION["quesno"]."\",\"Response\":\"finish\"}";
                }
                
            }
            else
                echo "{\"qno\":\"".$quesno."\",\"qno\":\"".$_SESSION["quesno"]."\",\"answer\":\"".$row['answer']."\",\"Response\":\"False\"}";

        }


    }

}
$conn->close();
?>