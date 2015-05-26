<?php include "conn.php";
session_start();
if (empty($_POST['username'])) { 
         echo "";
    }
    else {
        $Username = mysqli_real_escape_string($con, $_POST['username']);
        $Password = mysqli_real_escape_string($con, $_POST['password']);
        $loginsql = "Select Name, Password from users where Email = '" . $Username . "' and Password = '" . $Password . "'";
        $loginresult = $con->query($loginsql);
                            if ($loginresult->num_rows == 1) {
                                    $loginrow = $loginresult->fetch_assoc();
                                    $_SESSION["displayname"] = $loginrow["Name"];
                                    $_SESSION["Username"] = $Username;
                                }
                                
                            else {
                                echo "Looks like you've entered an incorrect combination. ";
//                                echo "You entered " . $Password;
//                                    $loginrow = $loginresult->fetch_assoc();
//                                echo " Your username was " . $Username;
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
            <h1>Flag Subscription Manager</h1>
            <h2><?php if(isset($_SESSION["displayname"])){ 
        echo $_SESSION["displayname"]; }?> - View and manage Flag Subscriptions</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Subscription Management</h2>
            <p><?php if(isset($_SESSION["Notification"])){ echo $_SESSION["Notification"];} ?></p>
            <?php 
                if(!isset($_SESSION["Username"]) ) {
                    // session isn't started
                    include("loginform.php");
                }
                else {
                    echo "You Are Logged In";
                    
                }
    
    ?>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>
]