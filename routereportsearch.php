<?php session_start();
include "con.php"; 
    if (empty($_GET['route']) || $_SESSION["Axel"] != "Awesome" ) {
        header('Location: routes.php'); // Redirecting To Routes Page
}
    else {
$Route = mysqli_real_escape_string($con, $_GET['route']);
$rtsql = "Select CustomerName, HouseNum, StreetName, Route, Action from customers where Route = '" . $Route . "' and SubStatus='Active'";
$rtresult = $con->query($rtsql);
                            if ($rtresult->num_rows < 1) {
                                $_SESSION["Notification"] = "No Customers in that Route";
                                }
    
                            else {
//                                Loop through all the results and display the fields in a nice table
                                $rtrow = $rtresult->fetch_assoc();                                
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
            <h2><?php echo $_SESSION["displayname"]; ?> - View and manage Flag Routes</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead"><?php echo $Route; ?> Route Report - Created <?php echo date('l jS \of F Y h:i:s A') ?></h2>
            <p><?php echo $_SESSION["Notification"]; ?></p>
            
            <table style="width:100%">

                            <tr>

                                <th class="RouteHeader">Name</th>
                                <th class="RouteHeader">Address</th>
                                <th class="RouteHeader">Action</th>
                                

                            </tr>
            <?php 
                    while($rtrow = $rtresult->fetch_assoc()) {

        echo "<tr><td>" . $rtrow["CustomerName"]. "</td><td>" . $rtrow["HouseNum"]. " " . $rtrow["StreetName"] . " Mansfield, TX 76063</td><td>" . $rtrow["Action"] . "</td></tr>";

    }
                
    
    ?>
                </table>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>

