<?php
session_start();
$_SESSION["quesno"]=0;
?>
<link rel="stylesheet" type="text/css" href="displayquiz.css">
<?php
  $servername="localhost";
  $username="root";
  $password="";
  $dbname="quizdb";
// Create connection
$conn =new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!($_SESSION["quesno"]))
$quesno=$_SESSION["quesno"]=1;
else
    $quesno=$_SESSION["quesno"];
$sql = "SELECT * FROM physics WHERE id='$quesno'";
$result = $conn->query($sql);
 $flag=0;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["id"]== $quesno)
        {
            echo "<div id='question'>".$row['question']."</div>";
            echo "<div id='optiona'>".$row['optiona']."</div>";
            echo "<div id='optionb'>".$row['optionb']."</div>";
            echo "<div id='optionc'>".$row['optionc']."</div>";
            echo "<div id='optiond'>".$row['optiond']."</div>";
            $_SESSION["answer"]=$row["answer"];
            $flag=1;
        }
    }

}
if($flag==0)
    echo "<script>alert(\"You won\");window.location.href=\"quizup.php\";</script>";

?>
<script src="annyang.min.js"></script>
<script>


    if (annyang) {
        // Let's define a command.
        var commands = {
            'option A': function() { document.getElementById("optiona").className="selected";
                document.getElementById("optionb").className="";
                document.getElementById("optionc").className="";
                document.getElementById("optiond").className="";
                checkoption('optiona');},
            'option B': function() { document.getElementById("optionb").className="selected";
                    document.getElementById("optiona").className="";
                    document.getElementById("optionc").className="";
                    document.getElementById("optiond").className=""; checkoption('optionb');},
            'option C': function() { document.getElementById("optionc").className="selected";
                        document.getElementById("optiona").className="";
                        document.getElementById("optionb").className="";
                        document.getElementById("optiond").className="";checkoption('optionc'); },
            'option D': function() {document.getElementById("optiond").className="selected";
                            document.getElementById("optiona").className="";
                            document.getElementById("optionc").className="";
                            document.getElementById("optionb").className=""; checkoption('optiond');}
        };

        // Add our commands to annyang
        annyang.addCommands(commands);

        // Start listening.
        annyang.start();
    }
    function checkoption(option)
    {
       setTimeout(function(){
           var xhttp=new XMLHttpRequest();
           var formdata=new FormData();
           formdata.append("optionselected",option);
          // alert("came here");
           xhttp.onreadystatechange=function () {
               if(xhttp.status==200&&xhttp.readyState==4) {
                   alert(xhttp.responseText);
                   if (xhttp.responseText === "True") {
                       document.getElementById(option).className = "correct";
                       setTimeout(function () {
                           location.reload();
                       }, 2000);
                   }
                   else if (xhttp.responseText) {
                       document.getElementById(option).className = "wrong";
                       alert("wrong answer.Better luck next time");
                       window.location.href = "quizup.php";

                   }
               }
           };
           xhttp.open("POST", "checkoption0.php", true);
           xhttp.send(formdata);
           
           
       },2000);
    }
</script>
</body>