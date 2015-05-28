<?php include "conn.php"; 
include "sendmail.php";
include "email/templates.php";

/*// Notify Customers of Status Changes - Expired
$ExpiredSuccessCount = 0;
$ExpiredFailCount = 0;

$Expiredemailsql = "select * from customers WHERE DATEDIFF(`ExpirationDate`,CURDATE()) < 0 and SubStatus != 'Expired'";

$Expiredemailresult = $con->query($Expiredemailsql);

if ($Expiredemailresult->num_rows > 0) {
    while($expdrow = $Expiredemailresult->fetch_assoc()) {
        if ($expdrow['Email'] == '') {
            $ExpiredFailCount++;
        }
        else {
            $RecipEmail = $expdrow['Email'];
            $RecipName = $expdrow['CustomerName'];
            $Subject = 'Your Flag Service Has Ended - Renew Now';
            $Body = "Dear " . $expdrow['CustomerName'] . ", <br /> <p>Your Flag Service has expired. Please visit <a href='http://troop833.com/flags'> Our Website </a> To Renew. We appreciate your continued support.</p> Thanks,<br />Troop 833";
            $AltBody = 'Your Flag Service has ended. To Renew, please visit http://troop833.com/flags';

            $expiredresponse = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

            if ($expiredresponse == 'Success') {
                $ExpiredSuccessCount++;
            }
            else {
                $ExpiredFailCount++;
            }
        }
    }
}

echo "Expired Emails Sent: " . $ExpiredSuccessCount . "<br />";
echo "Expired Emails Failed: " . $ExpiredFailCount . "<br />";

// Notify Customers of Status Changes - Expiring
$ExpiringSuccessCount = 0;
$ExpiringFailCount = 0;

$Expiringemailsql = "select * from customers WHERE DATEDIFF(`ExpirationDate`,CURDATE()) between 0 and 30 and SubStatus != 'Expiring Soon'";

$Expiringemailresult = $con->query($Expiringemailsql);

if ($Expiringemailresult->num_rows > 0) {
    while($expgrow = $Expiringemailresult->fetch_assoc()) {
        if ($expgrow['Email'] == '') {
            $ExpiringFailCount++;
        }
        else {
            $RecipEmail = $expgrow['Email'];
            $RecipName = $expgrow['CustomerName'];
            $Subject = 'Your Flag Service Is Expiring Soon - Renew Now';
            $Body = 'Your Flag Service ends ' . $expgrow['ExpirationDate'] . '. To Renew, please visit http://troop833.com/flags or reply to this e-mail.';
            $AltBody = 'Your Flag Service ends ' . $expgrow['ExpirationDate'] . '. To Renew, please visit http://troop833.com/flags or reply to this e-mail.';


            $expiringresponse = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

            if ($expiringresponse == 'Success') {
                $ExpiringSuccessCount++;
            }
            else {
                $ExpiringFailCount++;
            }
        }
    }
}


echo "Expiring Soon Emails Sent: " . $ExpiringSuccessCount . "<br />";
echo "Expiring Soon Emails Failed: " . $ExpiringFailCount . "<br />";

// Notify Customers of Status Changes - Active
$ActiveSuccessCount = 0;
$ActiveFailCount = 0;
$Activeemailsql = "SELECT * from customers WHERE DATEDIFF(`ExpirationDate`,CURDATE()) >= 30 and SubStatus != 'Active'";

$Activeemailresult = $con->query($Activeemailsql);

if ($Activeemailresult->num_rows > 0) {
    while($activerow = $Activeemailresult->fetch_assoc()) {
        if ($activerow['Email'] == '') {
            $ActiveFailCount++;
        }
        else {
        $RecipEmail = $activerow['Email'];
        $RecipName = $activerow['CustomerName'];
        $Subject = 'Your Flag Service Is Now Active - Thanks For Your Support';
        $Body = "<p>Thank you for your generous support of our Troop. This e-mail is to confirm that your subscription is now active and you will receive service until " . $activerow['ExpirationDate'] . ". </p>Thanks<br />Troop 833";
        $AltBody = "Thank you for your generous support of our Troop. This e-mail is to confirm that your subscription is now active and you will receive service until " . $activerow['ExpirationDate'] . ". Thanks, Troop 833";

        $activeresponse = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

        if ($activeresponse == 'Success') {
            $ActiveSuccessCount++;
        }
        else {
            $ActiveFailCount++;
        }
    }
    }
}
echo "Active Emails Sent: " . $ActiveSuccessCount . "<br />";
echo "Active Emails Failed: " . $ActiveFailCount . "<br />";

//SQL Queries for Status Management.
$expiredsql = "UPDATE `customers` SET `Action`='Give Flyer and Attempt Renewal',`SubStatus`='Expired' WHERE DATEDIFF(`ExpirationDate`,CURDATE()) < 0 and SubStatus != 'Expired'";

$expiringsql = "UPDATE `customers` SET `Action`='Flag and Flyer',`SubStatus`='Expiring Soon' WHERE DATEDIFF(`ExpirationDate`,CURDATE()) between 0 and 30 and SubStatus != 'Expiring Soon'";

$activesql = "UPDATE `customers` SET `Action`='Set Up Flag',`SubStatus`='Active' WHERE DATEDIFF(`ExpirationDate`,CURDATE()) >= 30 and SubStatus != 'Active'";


//Executing the SQL Queries
if ($con->query($expiredsql) === TRUE) {
    $ExpirationResult = "Expired Records Updated";
} 
else {
    $ExpirationResult = "Error updating Expired records: " . $con->error;
}

if ($con->query($expiringsql) === TRUE) {
    $ExpiringResult = "Expiring Records Updated";
} 
else {
    $ExpiringResult = "Error updating Expiring records: " . $con->error;
}

if ($con->query($activesql) === TRUE) {
    $ActiveResult = "Active Records Updated";
} 
else {
    $ActiveResult = "Error updating Active records: " . $con->error;
}

//Echo the Results

echo $ExpirationResult . "<br / >";
echo $ExpiringResult . "<br / >";
echo $ActiveResult . "<br / >";*/


// Check for upcoming Holidays


//Notify Scouts 30 days out
$n30SuccessCount = 0;
$n30FailCount = 0;
$n30sql = "Select * from schedule WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 14 and 30 and Notified = 300";

$n30result = $con->query($n30sql);

if ($n30result->num_rows > 0) {
 while($n30row = $n30result->fetch_assoc()) {
     echo $n30row['HolidayName'] . " Is coming up on " . $n30row['HolidayDate'] . ".";
        
     //n30 Setup
     $scoutsql = "select * from users where Name in ('" . $n30row['SetUp1'] . "', '" . $n30row['SetUp2'] . "', '" . $n30row['SetUp3'] . "', '" . $n30row['SetUp4'] . "') and Role='Scout'";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Setup Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to set up flags on " . $n30row['HolidayName'] . " (" . $n30row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find a substitute if you're not. </p> <p>You will be getting another reminder in a couple weeks and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to set up flags on " . $n30row['HolidayDate'] . ".";

     $n30response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n30response == 'Success') {
         $n30SuccessCount++;
     }
     else {
         $n30FailCount++;
     }
     }
     
     //n30 TakeDown
          $scoutsql = "select * from users where Name in ('" . $n30row['TakeDown1'] . "', '" . $n30row['TakeDown2'] . "', '" . $n30row['TakeDown3'] . "', '" . $n30row['TakeDown4'] . "')";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Take Down Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to take down flags on " . $n30row['HolidayName'] . " (" . $n30row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and swap with someone if you're not. </p> <p>You will be getting another reminder in a couple weeks and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to take down flags on " . $n30row['HolidayDate'] . ".";

     $n30response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n30response == 'Success') {
         $n30SuccessCount++;
     }
     else {
         $n30FailCount++;
     }
     }
 
 }
    //update the database so we don't send the notification again
//$n30updatesql = "update schedule set Notified = 30 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 14 and 30 and Notified = 300";
//$n30updateresult = $con->query($n30updatesql);
//echo "Holidays Notified=30 <br />";
    echo "n30 Email Success: " . $n30SuccessCount . "<br />";
    echo "n30 Email Failures: " . $n30FailCount . "<br />";
}



//Notify Scouts 14 days out
$n14sql = "Select * from schedule WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 7 and 14 and Notified = 30";

$n14result = $con->query($n14sql);

if ($n14result->num_rows > 0) {
 while($n14row = $n14result->fetch_assoc()) {
     echo $n14row['HolidayName'] . " Is coming up on " .$n14row['HolidayDate'];
 }
    //update holiday to show notified
    $n14updatesql = "update schedule set Notified = 14 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 7 and 14 and Notified = 30";
    $n14updateresult = $con->query($n14updatesql);
    echo "Holidays Notified=14";
    
     //n14 Setup
     $scoutsql = "select * from users where Name in ('" . $n14row['SetUp1'] . "', '" . $n14row['SetUp2'] . "', '" . $n14row['SetUp3'] . "', '" . $n14row['SetUp4'] . "') and Role='Scout'";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Setup Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to set up flags on " . $n14row['HolidayName'] . " (" . $n14row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find a substitute if you're not. </p> <p>You will be getting another reminder in one week and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to set up flags on " . $n14row['HolidayDate'] . ".";

     $n14response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n14response == 'Success') {
         $n14SuccessCount++;
     }
     else {
         $n14FailCount++;
     }
     }
     
     //n14 TakeDown
          $scoutsql = "select * from users where Name in ('" . $n14row['TakeDown1'] . "', '" . $n14row['TakeDown2'] . "', '" . $n14row['TakeDown3'] . "', '" . $n14row['TakeDown4'] . "')";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Take Down Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to take down flags on " . $n14row['HolidayName'] . " (" . $n14row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and swap with someone if you're not. </p> <p>You will be getting another reminder in one week and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to take down flags on " . $n14row['HolidayDate'] . ".";

     $n14response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n14response == 'Success') {
         $n14SuccessCount++;
     }
     else {
         $n14FailCount++;
     }
     }
}


//Notify Scouts 7 days out - Include a map of the area, but no addresses. -Include Flyer attachments and estimate of flyer actions
$n7sql = "Select * from schedule WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 1 and 7 and Notified = 14";

$n7result = $con->query($n7sql);

if ($n7result->num_rows > 0) {
 while($n7row = $n7result->fetch_assoc()) {
     echo $n7row['HolidayName'] . " Is coming up on " .$n7row['HolidayDate'];
      //n7 Setup
     $scoutsql = "select * from users where Name in ('" . $n7row['SetUp1'] . "', '" . $n7row['SetUp2'] . "', '" . $n7row['SetUp3'] . "', '" . $n7row['SetUp4'] . "') and Role='Scout'";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Setup Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to set up flags on " . $n7row['HolidayName'] . " (" . $n7row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find a substitute if you're not. </p> <p>You will be getting a final e-mail the day before your assignment with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to set up flags on " . $n7row['HolidayDate'] . ".";

     $n7response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n7response == 'Success') {
         $n7SuccessCount++;
     }
     else {
         $n7FailCount++;
     }
     }
     
     //n7 TakeDown
          $scoutsql = "select * from users where Name in ('" . $n7row['TakeDown1'] . "', '" . $n7row['TakeDown2'] . "', '" . $n7row['TakeDown3'] . "', '" . $n7row['TakeDown4'] . "')";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Take Down Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to take down flags on " . $n7row['HolidayName'] . " (" . $n7row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and swap with someone if you're not. </p> <p>You will be getting a final e-mail the day before your assignment with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to take down flags on " . $n7row['HolidayDate'] . ".";

     $n7response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n7response == 'Success') {
         $n7SuccessCount++;
     }
     else {
         $n7FailCount++;
     }
     }
 }
    
    //update holiday to show notified
    $n7updatesql = "update schedule set Notified = 7 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 1 and 7 and Notified = 14";
    $n7updateresult = $con->query($n7updatesql);
    echo "Holidays Notified=7";
}

//Send Routes - or links to routes, or both -  the Day before
$n1sql = "Select * from schedule WHERE DATEDIFF(`HolidayDate`,CURDATE()) = 1 and Notified = 7";

$n1result = $con->query($n1sql);

if ($n1result->num_rows > 0) {
 while($n1row = $n1result->fetch_assoc()) {
     echo $n1row['HolidayName'] . " Is coming up on " .$n1row['HolidayDate'];
     //n1 Setup
     $scoutsql = "select * from users where Name in ('" . $n1row['SetUp1'] . "', '" . $n1row['SetUp2'] . "', '" . $n1row['SetUp3'] . "', '" . $n1row['SetUp4'] . "') and Role='Scout'";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Setup Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to set up flags on " . $n1row['HolidayName'] . " (" . $n1row['HolidayDate'] . ").</p> <p>Please go download your route: <a href='http://flags.troop833.com/routes.php?route=" .  . "'></a></p> <p>You will be getting another reminder in a couple weeks and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to set up flags on " . $n1row['HolidayDate'] . ".";

     $n1response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n1response == 'Success') {
         $n1SuccessCount++;
     }
     else {
         $n1FailCount++;
     }
     }
     
     //n1 TakeDown
          $scoutsql = "select * from users where Name in ('" . $n1row['TakeDown1'] . "', '" . $n1row['TakeDown2'] . "', '" . $n1row['TakeDown3'] . "', '" . $n1row['TakeDown4'] . "')";
     $scoutresult = $con->query($scoutsql);
     
     while($scoutrow = $scoutresult->fetch_assoc()) {
     
     $RecipEmail = $scoutrow['Email'];
     $RecipName = $scoutrow['Name'];
     $Subject = 'You Have a Flag Take Down Assignment';
     $Body = "Dear " . $scoutrow['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to take down flags on " . $n1row['HolidayName'] . " (" . $n1row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and swap with someone if you're not. </p> <p>You will be getting another reminder in a couple weeks and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to take down flags on " . $n1row['HolidayDate'] . ".";

     $n1response = FlagMail($RecipEmail, $RecipName, $Subject, $Body, $AltBody);

     if ($n1response == 'Success') {
         $n1SuccessCount++;
     }
     else {
         $n1FailCount++;
     }
     }
 }
    //update holiday to show notified
    $n1updatesql = "update schedule set Notified = 2 WHERE DATEDIFF(`HolidayDate`,CURDATE()) = 2 and Notified = 7";
    $n1updateresult = $con->query($n1updatesql);
    echo "Holidays Notified=1";
}


?>