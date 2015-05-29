<?php session_start();
include "conn.php"; 
    if (empty($_GET['houseNum']) || empty($_GET['streetName'])) {
        echo "";
}
    else {
$StreetName = mysqli_real_escape_string($con, $_GET['streetName']);
$HouseNum = mysqli_real_escape_string($con, $_GET['houseNum']);

$cxsql = "Select * from customers where HouseNum = '" . $HouseNum . "' and StreetName='" . $StreetName . "' LIMIT 0,1";
$cxresult = $con->query($cxsql);
                            if ($cxresult->num_rows < 1) {
                                $LookupResultMessage = "No Customers found, would you like to add a new one?";
                                $NewCX = "True";
                                }
    
                            else {
                                $LookupResultMessage = "Customer Found.<br />";
                                $cxrow = $cxresult->fetch_assoc();
                                $CXName = $cxrow["CustomerName"];
                                $CXPhone = $cxrow["Phone"];
                                $CXEmail= $cxrow["Email"];
                                $CXPaymentMethod = $cxrow["PaymentMethod"];
                                $CXPaymentID = $cxrow["PaymentID"];
                                $CXPaymentDate = $cxrow["PaymentDate"];
                                $CXVetStatus = $cxrow["VetStatus"];
                                $CXRoute = $cxrow["Route"];
                                $CXScoutCredit1 = $cxrow["ScoutCredit1"];
                                $CXScoutCredit2 = $cxrow["ScoutCredit2"];
                                $CXSubmittedBy = $cxrow["SubmittedBy"];
                                $NewCX = "False";
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
            <h2>View and manage Flag Subscriptions</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Subscription Management</h2>
            <p>
                This should be the street number: 
                <?php
//                    $StreetName = mysqli_real_escape_string($con, $_POST['streetName']);
                    echo $CXName . " " . $HouseNum . " " . $StreetName; 
                    echo "<br>" . $LookupResultMessage;
                    echo "Name: " . $CXName . "<br />";
                    echo "Phone: " . $CXPhone . "<br />";
                    echo "Email: " . $CXEmail . "<br />";
                    echo "PMethod: " . $CXPaymentMethod . "<br />";
                    echo "PID: " . $CXPaymentID . "<br />";
                    echo "PDate: " . $CXPaymentDate . "<br />";
                    echo "VetStatus: " . $CXVetStatus . "<br />";
                    echo "Route: " . $CXRoute . "<br />";
                    echo "Scout1: " . $CXScoutCredit1 . "<br />";
                    echo "Scout2: " . $CXScoutCredit2 . "<br />";
                    echo "Submitted: " . $CXSubmittedBy . "<br />";
                    echo "SubStatus: " . $cxrow["SubStatus"] ."<br />";

                ?>
            </p>
            <?php 
                    
                    if(!isset($_SESSION["Username"])) {
                    // session isn't started
                        include("loginform.php");
                    }
                    else {
                        include("cxform.php");
                }
    
    ?>
            
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>