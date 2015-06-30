<?php include "conn.php";
session_start();



if (!empty($_POST['infochange-submit'])) {
    $nprimaryemail = mysqli_real_escape_string($con, $_POST['primaryemail']);
    $nsecondaryemail = mysqli_real_escape_string($con, $_POST['secondaryemail']);
    $sql = "UPDATE `users` SET `Email`='". $nprimaryemail ."',`AlternateEmail`='". $nsecondaryemail ."' WHERE `Username` = '" . $_SESSION["Username"] . "'";
    $result = $con->query($sql);
    $Notification = "E-mail Address(es) updated";
}

if (!empty($_POST['pwchange-submit'])) {
    $newpw1 = $_POST['newpw1'];
    $newpw2 = $_POST['newpw2'];
    
    $Username = mysqli_real_escape_string($con, $_SESSION['Username']);
        $rawPassword = mysqli_real_escape_string($con, $_POST['oldpw']);
//        $Password = password_hash($rawPassword, PASSWORD_DEFAULT);
        $loginsql = "Select Password from users where Username = '" . $Username . "'";
        $loginresult = $con->query($loginsql);
                            if ($loginresult->num_rows == 1) {
                                    
                                    $loginrow = $loginresult->fetch_assoc();
                                if (password_verify($rawPassword, $loginrow['Password'])) {   
                                    
                                    if($newpw1 == $newpw2){
                                        $NewPassword = password_hash($newpw1, PASSWORD_DEFAULT);
                                        $sql = "UPDATE `users` SET `Password`='". $NewPassword ."' WHERE `Username` = '" . $Username . "'";
                                        $result = $con->query($sql);
                                        $Notification = "Password Changed";

                                    }
                                    else {
                                        $Notification = "Passwords Don't Match";
                                    }
                                }
                                
                                else {
                                    $Notification = "Wrong Password";
                                }
                                
                            }
}

$sql = "select * from users where Username = '" . $_SESSION["Username"] . "' ";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$primaryemail = $row["Email"];
$secondaryemail = $row["AlternateEmail"];

$sql = "select count(*) as Count from customers where ScoutCredit1 = '" . $_SESSION['displayname'] ."'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$Scout1 = $row['Count'];

$sql = "select count(*) as Count from customers where ScoutCredit2 = '" . $_SESSION['displayname'] ."'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$Scout2 = $row['Count'];

$SoldCount = ($Scout1 + $Scout2) * 0.5;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Interface for managing flag subscriptions.">

    <title>Troop833 Flag Subscription Manager</title>

    


<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">




  
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="css/layouts/side-menu.css">
    <!--<![endif]-->
  




    

</head>
<body>






<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#">Troop 833</a>

            <ul class="pure-menu-list">
                <?php include("menuitems.php"); ?>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Flag Subscription Manager</h1>
            <h2><?php if(isset($_SESSION["displayname"])){ 
        echo $_SESSION["displayname"]; }?> - View and manage Your Account</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Your Account Details</h2>
            <p><?php if(isset($Notification)){ echo $Notification;} ?></p>
            <?php 
                if(!isset($_SESSION["Username"]) ) {
                    // session isn't started
                    include("loginform.php");
                }
                else {
                    echo "You Are Logged In as " . $_SESSION["Username"] . "<br />";
                    echo "Primary Email: " . $primaryemail . "<br />";
                    echo "Secondary Email: " . $secondaryemail . "<br />";
                    echo "Flags Sold: ".$SoldCount . "<br /><hr>";
                    echo "Assignments: "
                    include("userinfochangeform.php");
                    echo "<hr>";
                    include("userpwchangeform.php");
                }
    
    ?>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>