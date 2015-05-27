<?php include "conn.php"; 
include "sendmail.php";

// Notify Customers of Status Changes - Expired
$ExpiredSuccessCount = 0;
$ExpiredFailCount = 0;

$Expiredemailsql = "select * from customers WHERE DATEDIFF(`ExpirationDate`,CURDATE()) < 0 and SubStatus != 'Expired'";

$Expiredemailresult = $con->query($Expiredemailsql);

if ($Expiredemailresult->num_rows > 0) {
    while($expdrow = $Expiredemailresult->fetch_assoc()) {
        $RecipEmail = $expdrow['Email'];
        $RecipName = $expdrow['CustomerName'];
        $Subject = 'Your Flag Service Has Ended - Renew Now';
        $Body = "Dear " . $expdrow['CustomerName'] . ", <br /> <p>Your Flag Service has ended. Please visit <a href='http://troop833.com/flags'> Our Website </a> To Renew. We appreciate your conintued support.</p> Thanks,<br />Troop 833";
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

echo "Expired Emails Sent: " . $ExpiredSuccessCount . "<br />";
echo "Expired Emails Failed: " . $ExpiredFailCount . "<br />";

// Notify Customers of Status Changes - Expiring
$ExpiringSuccessCount = 0;
$ExpiringFailCount = 0;

$Expiringemailsql = "select * from customers WHERE DATEDIFF(`ExpirationDate`,CURDATE()) between 0 and 30 and SubStatus != 'Expiring Soon'";

$Expiringemailresult = $con->query($Expiringemailsql);

if ($Expiringemailresult->num_rows > 0) {
    while($expgrow = $Expiringemailresult->fetch_assoc()) {
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


echo "Expiring Soon Emails Sent: " . $ExpiringSuccessCount . "<br />";
echo "Expiring Soon Emails Failed: " . $ExpiringFailCount . "<br />";

// Notify Customers of Status Changes - Active
$ActiveSuccessCount = 0;
$ActiveFailCount = 0;
$Activeemailsql = "SELECT * from customers WHERE DATEDIFF(`ExpirationDate`,CURDATE()) >= 30 and SubStatus != 'Active'";

$Activeemailresult = $con->query($Activeemailsql);

if ($Activeemailresult->num_rows > 0) {
    while($activerow = $Activeemailresult->fetch_assoc()) {
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
echo $ActiveResult . "<br / >";

?>