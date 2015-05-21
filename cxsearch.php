<?php include "con.php"; 
$StreetName = mysqli_real_escape_string($con, $_GET['streetName']);
$HouseNum = mysqli_real_escape_string($con, $_GET['houseNum']);

$cxsql = "Select * from customers where HouseNum = '" . $HouseNum . "' and StreetName='" . $StreetName . "' LIMIT 0,1";
$cxresult = $con->query($cxsql);
                            if ($cxresult->num_rows < 1) {
                                $LookupResultMessage = "No Customers found, would you like to add a new one?";
                                $NewCX = "True";
                                }
    
                            else {
                                $LookupResultMessage = "Customer Found, Do you want to update?";
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
                ?>
            </p>
            <form class="pure-form pure-form-stacked" action="cxupdate.php" method="POST">
                <fieldset>
                    <legend>Add/Edit Information</legend>
                    
                    <label for="name">Customer Name</label>
                    <input id="name" type="text" placeholder="John Smith" name="customername" 
                           <?php 
    if (empty($CXName)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXName . "\"";
    }
                           ?>>
                    
                    <label for="phone">Phone Number</label>
                    <input id="phone" type="tel" placeholder="555-555-1234" name="phone" 
                           <?php 
    if (empty($CXPhone)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXPhone . "\"";
    }
                           ?>>
                    
                    <label for="email">E-mail</label>
                    <input id="email" type="email" placeholder="yourname@example.com" name="email" 
                           <?php 
    if (empty($CXEmail)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXEmail . "\"";
    }
                           ?>>                    
                    
                    <label for="paymentmethod">Payment Method</label>
                    <select id="paymentmethod" name="paymentmethod">
                       <option value="">Choose One</option>
                        <?php 
                            $sql = "select PaymentMethod from options where PaymentMethod<>''";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["PaymentMethod"]. "\">" . $row["PaymentMethod"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    
                    <label for="paymentid">Payment ID</label>
                    <input id="paymentid" type="text" placeholder="Check Number or Transaction ID" name="paymentid" 
                           <?php 
    if (empty($CXPaymentID)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXPaymentID . "\"";
    }
                           ?>>     

                    <label for="paymentdate">Payment Date</label>
                    <input id="paymentdate" type="date" placeholder="01/04/2015" name="paymentdate" 
                           <?php 
    if (empty($CXPaymentDate)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXPaymentDate . "\"";
    }
                           ?>> 
                    
                    <label for="vetstatus">VetStatus</label>
                    <select id="vetstatus" name="vetstatus">
                       <option value="">Choose One</option>
                        <?php 
                            $sql = "select VetStatus from options where VetStatus<>''";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["VetStatus"]. "\">" . $row["VetStatus"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    
                    <label for="Route">Route</label>
                    <select id="Route" name="route">
                       <option value="">Choose One</option>
                        <?php 
                            $sql = "select Route from options where Route<>''";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["Route"]. "\">" . $row["Route"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>                    
                    
                    <label for="scoutcredit1">Scout Credit 1</label>
                    <select id="scoutcredit1" name="scoutcredit1">
                       <option value="">Choose One</option>
                        <?php 
                            $sql = "select Name from users where Role = 'Scout'";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["Name"]. "\">" . $row["Name"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    
                    <label for="scoutcredit2">Scout Credit 2</label>
                    <select id="scoutcredit2" name="scoutcredit2">
                       <option value="">Choose One</option>
                        <?php 
                            $sql = "select Name from users where Role = 'Scout'";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["Name"]. "\">" . $row["Name"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    
                    <label for="submittedby">Submitted By</label>
                    <select id="submittedby" name="submittedby">
                       <option value="">Choose One</option>
                        <?php 
                            $sql = "select Name from users";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["Name"]. "\">" . $row["Name"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    <input type="hidden" value="<?php echo $HouseNum; ?>" name="HouseNum">
                    <input type="hidden" value="<?php echo $StreetName; ?>" name="StreetName">
                    <input type="hidden" value="<?php echo $NewCX; ?>" name="newcx">
                    <button type="submit" class="pure-button pure-button-primary">Submit</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>