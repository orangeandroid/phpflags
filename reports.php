<?php include "conn.php"; 
session_start();
    if(!isset($_SESSION["Username"])) {
    // session isn't started
        header('Location: index.php'); // Redirecting To Home Page
    }

if(isset($_GET["scout"])) {
    $Scout = mysqli_real_escape_string($con, $_GET['scout']);
}
else {
    $Scout = "";
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
            <h1>Reports</h1>
            <h2>Run Reports</h2>
        </div>

        <div class="content">
             <form class="pure-form" action="reports.php" method="GET">
                <fieldset>
                    <legend>How Many I have I Sold?</legend>
                    
                    <label for="scoutName">Scout Name</label>
                    <select id="scoutName" name="scout" required>
                        <option value="">Choose One</option>
                        <?php
//                            $cxsql = "select distinct StreetName from customers";
//                            $cxresult = $con->query($cxsql);
                            $sql = "select Name from users order by Name ASC";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["Name"]. "\">" . $row["Name"]. "</option>";
                                }
//                                while($cxrow = $cxresult->fetch_assoc()) {
//                                    echo "<option value= \"" . $cxrow["StreetName"]. "\">" . $cxrow["StreetName"]. "</option>";
//                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    
                    <button type="submit" class="pure-button pure-button-primary">Look Up Scout</button>
                </fieldset>
            </form>
            
            <h2 class="content-subhead">Renewals</h2>          
            <table class="pure-table pure-table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Payment Method</th>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Scout Credit 1</th>
                    <th>Scout Credit 2</th>
                    <th>SubStatus</th>
                    <th>Expiration Date</th>
                </tr>
                <?php 
$rtsql = "Select * from customers WHERE ScoutCredit1 = '" . $Scout . "' OR ScoutCredit2 = '" . $Scout . "' ORDER By `StreetName` ASC";
$rtresult = $con->query($rtsql);
if ($rtresult->num_rows < 1) {
    $_SESSION["Notification"] = "No Customers in that Route";
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
       
       
       
       echo "<tr><td>" . $rtrow["CustomerName"]. "</td><td><a href='cxsearch.php?houseNum=" . $rtrow["HouseNum"] . "&" . "streetName=" . $rtrow["StreetName"] . "'>" . $rtrow["HouseNum"]. " " . $rtrow["StreetName"] . "</a></td><td>" . $rtrow["Phone"] . "</td><td><a href=\"Mailto:" . $rtrow["Email"] . "\">" . $rtrow["Email"] . "</a></td><td>" . $rtrow['PaymentMethod'] . "</td><td>" . $rtrow['PaymentID'] . "</td><td>" . $rtrow['PaymentDate'] . "</td><td>" . $rtrow['ScoutCredit1'] . "</td><td>" . $rtrow['ScoutCredit2'] . "</td><td>" . $rtrow["SubStatus"]. "</td><td>" . $rtrow["ExpirationDate"]. "</td></tr>";

                    }
}
    ?>
                </table>

            
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>