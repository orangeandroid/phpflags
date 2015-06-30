<?php include "conn.php";
session_start();

$sql = "select * from users where Username = '" . $_SESSION["Username"] . "' ";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$primaryemail = $row["Email"];
$secondaryemail = $row["AlternateEmail"];

if (!empty($_POST['infochange-submit'])) {
   $Testing = "InfoChange";
}

if (!empty($_POST['pwchange-submit'])) {
   $Testing = "PwChange";
}


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
            <?php echo $Testing; ?>
            <p><?php if(isset($_SESSION["Notification"])){ echo $_SESSION["Notification"];} ?></p>
            <?php 
                if(!isset($_SESSION["Username"]) ) {
                    // session isn't started
                    include("loginform.php");
                }
                else {
                    echo "You Are Logged In as " . $_SESSION["Username"] . "<br />";
                    echo "Primary Email: " . $primaryemail . "<br />";
                    echo "Secondary Email: " . $secondaryemail . "<br /><hr>";
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