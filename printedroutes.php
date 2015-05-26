<?php session_start();
include "conn.php"; 
    if (empty($_GET['route']) || !isset($_SESSION["Username"]) ) {
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

        <div class="content">
            <h2 class="content-subhead"><?php echo $Route; ?> Route: <?php echo $Count; ?> Flags - Created <?php echo date('l jS \of F Y h:i:s A') ?></h2>
            
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