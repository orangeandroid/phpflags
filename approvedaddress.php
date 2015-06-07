<?php include "conn.php";
session_start();
    
if(!isset($_SESSION["Username"]) or $_SESSION["role"] != 'Admin') {
    // session isn't started
    header('Location: index.php'); // Redirecting To Home Page
}


if (isset($_POST['newstreet'])) {
        $newStreet = mysqli_real_escape_string($con, $_POST['newstreet']);
    
        $addsql = "INSERT INTO approvedaddresses(StreetName) VALUES ('" . $newStreet . "')";
        $addresult = $con->query($addsql);
                            if ($addresult == "True") {
                                $_SESSION['Notification'] = $newStreet . " added";
                                }
                                
                            else {
                                $_SESSION['Notification'] = "Street NOT added. Try again.";
                                
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
            <h1>Approved Address</h1>
            <h2><?php if(isset($_SESSION["displayname"])){ 
        echo $_SESSION["displayname"]; }?> - Add a New Street</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Approved Address Management</h2>
            <p><?php if(isset($_SESSION["Notification"])){ echo $_SESSION["Notification"]; $_SESSION['Notification'] = '';} ?></p>
            <form class="pure-form pure-form-stacked" method="post" action="approvedaddress.php">
                <fieldset>
                    <legend>Add a New Street</legend>

                    <label for="newstreet">Street Name</label>
                    <input id="newstreet" type="text" placeholder="Example Dr" name="newstreet" required>
                    
                    <button type="submit" class="pure-button pure-button-primary">Add Street</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>


</body>
</html>