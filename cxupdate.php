<?php session_start();
    include "con.php";
                if($_SESSION["Axel"] != "Awesome") {
                    // session isn't started
                    header('Location: index.php'); // Redirecting To Home Page
                }
                else {
                    $StreetName = mysqli_real_escape_string($con, $_POST['StreetName']);
                    $HouseNum = mysqli_real_escape_string($con, $_POST['HouseNum']);
                    $Name = mysqli_real_escape_string($con, $_POST['customername']);
                    $Phone = mysqli_real_escape_string($con, $_POST['phone']);
                    $Email = mysqli_real_escape_string($con, $_POST['email']);
                    $PaymentMethod = mysqli_real_escape_string($con, $_POST['paymentmethod']);
                    $PaymentID = mysqli_real_escape_string($con, $_POST['paymentid']);
                    $PaymentDate = mysqli_real_escape_string($con, $_POST['paymentdate']);
                    $VetStatus = mysqli_real_escape_string($con, $_POST['vetstatus']);
                    $Route = mysqli_real_escape_string($con, $_POST['route']);
                    $ScoutCredit1 = mysqli_real_escape_string($con, $_POST['scoutcredit1']);
                    $ScoutCredit2 = mysqli_real_escape_string($con, $_POST['scoutcredit2']);
                    $SubmittedBy = mysqli_real_escape_string($con, $_POST['submittedby']);
                    $NewCX = mysqli_real_escape_string($con, $_POST['newcx']);
                    

//                  No Partial Payments Accepted, if you make a payment you get a year of service. Set Expiration Date Accordingly.                    
                    $PaymentDateint = strtotime($PaymentDate);
                    $ExpirationDateint = strtotime('+1 years', $PaymentDateint);
                    $ExpirationDate = date('Y-m-d', $ExpirationDateint);
//                    echo "Expiration: " . $ExpirationDate . "<br />" . PHP_EOL; // returns: Thu, 28 Apr 2011 09:22:34 +0100
                    


//                    echo "Payment Date: " . $PaymentDate . "<br />";
                    
                    
//                  Determine the Subscription status based on Expiration Date. Set SubStatus and Action Accordingly.
                    $Today = date_create(date("Y-m-d"));
//                    echo "Today: " . date_format($Today, "Y-m-d") . "<br />";
                    
                    $exp = date_create(date('Y-m-d', $ExpirationDateint));
                    
                    $Diffint = date_diff($exp, $Today);
                    $Diff = $Diffint->format('%a');
                    
//                    echo "Diff: " . $Diff . "<br />";
                    
                    $expcomp = new DateTime($ExpirationDate);
                    $now = new DateTime();
                    
                    if ($expcomp < $now) {
//                        echo "Expired! <br />";
                        $SubStatus = "Expired";
                        $Action = "Give Flyer and Attempt Renewal";
                    }
                    else {
//                        echo "Not yet Expired <br />";
                    
                    
                        if ($Diff > 30) {
                            $SubStatus = "Active";
                            $Action = "Set Up Flag";
                        }
                        elseif ($Diff < 31) {
                            $SubStatus = "Expiring Soon";
                            $Action = "Set Up Flag and Give Flyer";
                        }
                    }
                    
                    if($NewCX == "True") {
                        $sql = "INSERT INTO `customers`(`CustomerName`, `HouseNum`, `StreetName`, `Phone`, `Email`, `PaymentMethod`, `PaymentID`, `PaymentDate`, `VetStatus`, `Route`, `Action`, `ExpirationDate`, `SubStatus`, `ScoutCredit1`, `ScoutCredit2`, `SubmittedBy`) VALUES ('". $Name ."','". $HouseNum ."','". $StreetName ."','". $Phone ."','". $Email ."','". $PaymentMethod ."','". $PaymentID ."','". $PaymentDate ."','". $VetStatus ."','". $Route ."','". $Action ."','". $ExpirationDate ."','". $SubStatus ."','". $ScoutCredit1 ."','". $ScoutCredit2 ."','". $SubmittedBy ."')";
//                        echo "INSERT Triggered";
                    }
                    elseif($NewCX == "False") {
                        $sql = "UPDATE `customers` SET `CustomerName`='". $Name ."',`Phone`='". $Phone ."',`Email`='". $Email ."',`PaymentMethod`='". $PaymentMethod ."',`PaymentID`='". $PaymentID ."',`PaymentDate`='". $PaymentDate ."',`VetStatus`='". $VetStatus ."',`Route`='". $Route ."',`Action`='". $Action ."',`ExpirationDate`='". $ExpirationDate ."',`SubStatus`='". $SubStatus ."',`ScoutCredit1`='". $ScoutCredit1 ."',`ScoutCredit2`='". $ScoutCredit2 ."',`SubmittedBy`='". $SubmittedBy ."' WHERE HouseNum = '". $HouseNum ."' and StreetName = '". $StreetName ."'";
//                        echo "UPDATE Triggered";
                        
                    }
                    else {
//                    Do Nothing
                    }
                    if ($con->query($sql) === TRUE) {
                        $_SESSION["Notification"] = "Record updated successfully";
                    } 
                    else {
                        $_SESSION["Notification"] = "Error updating record: " . $con->error;
                    } 
                }
    header('Location: index.php'); // Redirecting To Home Page
    ?>