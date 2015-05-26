<?php session_start();
include "conn.php"; 
    if (empty($_GET['route']) || $_SESSION["Axel"] != "Awesome" ) {
        header('Location: routes.php'); // Redirecting To Routes Page
}
    else {

        $Route = mysqli_real_escape_string($con, $_GET['route']);

        //define sql
        $rtsql = "Select CustomerName, HouseNum, StreetName, Route, Action from customers where Route = '" . $Route . "' and SubStatus in ('Active','Expiring Soon') ORDER BY StreetName, HouseNum";
        //execute query
        $rtresult = $con->query($rtsql);
        
        //see if any results were returned
                            if ($rtresult->num_rows < 1) {
                                $_SESSION["Notification"] = "No Customers in that Route";
                                }
    
                            else {
//                                Loop through all the results and display the fields in a nice table
//                                $rtrow = $rtresult->fetch_assoc();                                
                            }
        $countsql = "Select count(*) as COUNT from customers where Route = '" . $Route . "' and SubStatus in ('Active','Expiring Soon')";
        $countresult = $con->query($countsql);
                                    if ($countresult->num_rows < 1) {
                                $_SESSION["Notification"] = "No Customers in that Route";
                                }
    
                            else {
                                $countrow = $countresult->fetch_assoc();
                                $Count = $countrow['COUNT'];        
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
            <h2 class="content-subhead"><?php echo $Route; ?> Route: <?php echo $Count; ?> Flags - Created <?php echo date('l jS \of F Y h:i:s A') ?></h2>
            <p><form class="pure-form pure-form-stacked" action="printedroutes.php" method="GET">
                <input type="hidden" value="<?php echo $Route; ?>" name="route">
                <button type="submit" class="pure-button pure-button-primary">Printer-Friendly Version</button>
            </form></p>
            
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

