<?php include "conn.php";
session_start();

if(isset($_GET['step']) and $_GET['step'] == '1') {
    $StreetName = mysqli_real_escape_string($con, $_GET['streetName']);
    $HouseNum = mysqli_real_escape_string($con, $_GET['houseNum']);
    $checksql = "select Route from alladdresses where HouseNum = '" . $HouseNum . "' and streetName = '" . $StreetName . "'";
    $checkresult = $con->query($checksql);
    if ($checkresult->num_rows == 1) {
                                    
        $checkrow = $checkresult->fetch_assoc();
        if ($checkrow['Route'] != '') {   
            echo "congrats, you're on the " . $checkrow['Route'] . " Route.";
        }
        
        else {
            echo "Blank Route";
        }
        
    }
    else {
        echo "More or less than one row returned";
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

<form class="pure-form pure-form-stacked" action="cxsignup.php" method="GET">
                <fieldset>
                    <legend>Sign up for our Troop's Flag Service</legend>
                    
                    <label for="houseNum">House Number</label>
                    <input id="houseNum" type="number" placeholder="e.g. 436" name="houseNum" required>
                    
                    <label for="streetName">Street Name</label>
                    <select id="streetName" name="streetName" required>
                        <option value="">Choose One</option>
                        <?php
//                            $cxsql = "select distinct StreetName from customers";
//                            $cxresult = $con->query($cxsql);
                            $sql = "select distinct StreetName from alladdresses order by StreetName ASC";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["StreetName"]. "\">" . $row["StreetName"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    <input type="hidden" name="step" value='1'>
                    <button type="submit" class="pure-button pure-button-primary">Next</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>


</body>
</html>
            