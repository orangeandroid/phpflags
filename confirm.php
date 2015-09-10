<?php session_start();
include "conn.php"; 
    if (empty($_GET['cb']) || !isset($_GET["id"])) {
        header('Location: index.php'); // Redirecting To Routes Page
}
    else {
// e.g. http://flags.local/confirm.php?cb=user@email.tld&id=1&g2g=yes
        $ConfirmedBy = mysqli_real_escape_string($con, $_GET['cb']);
        $ID = mysqli_real_escape_string($con, $_GET['id']);
        $Today = date("Y-m-d");
        $G2G = mysqli_real_escape_string($con, $_GET['g2g']);

        //define sql
        if ($G2G == 'y'){
        $cbsql = "UPDATE `schedule` SET `ConfirmedBy`= '".$ConfirmedBy."',`ConfirmedDate`='".$Today."' WHERE `ID` = '".$ID."'";
        //execute query
        $cbresult = $con->query($cbsql);
        }
        else {
            //Send an e-mail
        }
        
        $schedsql = "Select * from schedule where ID = '" . $ID . "'";
        //execute query
        $schedresult = $con->query($schedsql);
        
        if ($schedresult->num_rows > 0) {
    while($row = $schedresult->fetch_assoc()){
        $HolidayName =  $row['HolidayName'];
        $HolidayDate = $row['HolidayDate'];
        $ScoutName = $row['Name'];
        $Task = $row['Task'];
        $Route = $row['Route'];
    }
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
        </div>

        <div class="content">
            <h2 class="content-subhead">Thank You</h2>
            <p><?php if ($GoodtoGo == 'Yes') {
                    
                       
    }
        
        
        You have confirmed your <?php echo $Task; ?> assignment for <?php echo $ScoutName; ?> on <?php echo $HolidayName; ?> (<?php echo $HolidayDate; ?>) along the <?php echo $Route; ?> Route. </p>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>

