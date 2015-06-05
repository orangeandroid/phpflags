<?php include "conn.php"; 
session_start();
if(!isset($_SESSION["Username"])) {
    // session isn't started
header('Location: index.php'); // Redirecting To Home Page
}
    if (empty($_GET['houseNum']) || empty($_GET['streetName'])) {
        echo "";
}
    else {
        $StreetName = mysqli_real_escape_string($con, $_GET['streetName']);
        $HouseNum = mysqli_real_escape_string($con, $_GET['houseNum']);
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
            <h1>Customer History</h1>
            <h2>All Changes to Account</h2>
        </div>

        <div class="tcontent">
            <h2 class="content-subhead">Renewals</h2>          
            <table class="pure-table pure-table-bordered">
                <tr>
                    <th>Date Modified</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Payment Method</th>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Veteran?</th>
                    <th>Route</th>
                    <th>SubStatus</th>
                    <th>Expiration Date</th>
                </tr>
                <?php 
$rtsql = "Select * from customers_audit where HouseNum = '" . $HouseNum . "' and StreetName='" . $StreetName . "' ORDER By `UpdatedDate` DESC";
$rtresult = $con->query($rtsql);
if ($rtresult->num_rows < 1) {
    $_SESSION["Notification"] = "Customer Does Not Exist";
}
    
else {
//                                Loop through all the results and display the fields in a nice table
   while($rtrow = $rtresult->fetch_assoc()) {
////       Clean up VetStatus
//       if ($rtrow["VetStatus"] = 1) {
//           $Vet = "Yes";
//       } 
//       elseif ($rtrow["VetStatus"] = 0) { 
//           $Vet = "No";
//       } 
//       else { 
//           $Vet = "?";
//       }
       
       
       
       echo "<tr><td>" . $rtrow["UpdatedDate"]. "</td><td>" . $rtrow["CustomerName"]. "</td><td>" . $rtrow["HouseNum"]. " " . $rtrow["StreetName"] . "</td><td>" . $rtrow["Phone"] . "</td><td><a href=\"Mailto:" . $rtrow["Email"] . "\">" . $rtrow["Email"] . "</a></td><td>" . $rtrow['PaymentMethod'] . "</td><td>" . $rtrow['PaymentID'] . "</td><td>" . $rtrow['PaymentDate'] . "</td><td>" . $rtrow['VetStatus'] . "</td><td>" . $rtrow['Route'] . "</td><td>" . $rtrow["SubStatus"]. "</td><td>" . $rtrow["ExpirationDate"]. "</td></tr>";

                    }
}
    ?>
                </table>
            <?php echo "<a class='pure-button' href='cxsearch.php?houseNum=" . $HouseNum . "&" . "streetName=" . $StreetName . "'>Back to Customer</a>"; ?>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>