<?php include "conn.php";
session_start();
$Notification = '';
$signup = '';

if(isset($_GET['step']) and $_GET['step'] == '1') {
    $StreetName = mysqli_real_escape_string($con, $_GET['streetName']);
    $HouseNum = mysqli_real_escape_string($con, $_GET['houseNum']);
    $checksql = "select Route from alladdresses where HouseNum = '" . $HouseNum . "' and streetName = '" . $StreetName . "'";
    $checkresult = $con->query($checksql);
    if ($checkresult->num_rows == 1) {
                                    
        $checkrow = $checkresult->fetch_assoc();
        if ($checkrow['Route'] != '') {   
            $Notification = "congrats, you're on the " . $checkrow['Route'] . " Route.";
            $signup = 'customer';
        }
        
        else {
            $Notification =  "You're not currently on one of our routes, If you give us your information we'll contact you once we have enough interest in your area.";
            $signup = 'interest';
        
        }
    }
    elseif($checkresult->num_rows == 0) {
        $Notification =  "We don't have that address in our records, try again?";
    }
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
            <h1>User Management</h1>
            <h2><?php if(isset($_SESSION["displayname"])){ 
        echo $_SESSION["displayname"]; }?> - Add a New User</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Subscription Management</h2>
            <?php echo $Notification;
            
            if($signup=='customer') {
                include 'cxsignupform.php';
            }
            elseif($signup == 'interest'){
                include 'cxinterestform.php';
            }
            else {
                include 'cxaddresscheckform.php';
            }
            
            ?>


        </div>
    </div>
</div>

<script src="js/ui.js"></script>


</body>
</html>
            