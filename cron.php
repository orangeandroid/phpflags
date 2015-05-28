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
$n30sql = "select schedule.*, users.Email, users.AlternateEmail from schedule INNER JOIN users ON schedule.Name=users.Name WHERE DATEDIFF(schedule.HolidayDate,CURDATE()) between 14 and 30 and schedule.Notified = 300";

$n30result = $con->query($n30sql);

if ($n30result->num_rows > 0) {
 while($n30row = $n30result->fetch_assoc()) {
     echo $n30row['HolidayName'] . " Is coming up on " . $n30row['HolidayDate'] . ". " . $n30row['Name'] . " is assigned to " . $n30row['Task'] . " the " . $n30row['Route'] . " Route. <br />";
 
     $recipients = array(
   $n30row['Email'] => $n30row['Name'],
   $n30row['AlternateEmail'] => $n30row['Name']
);

     $RecipEmail = $n30row['Email'];
     $RecipName = $n30row['Name'];
     $Subject = $n30row['Name'] . " Has a Flag" . $n30row['Task'] . " Assignment";
     $Body = "Dear " . $n30row['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to " . $n30row['Task'] . " flags on " . $n30row['HolidayName'] . " (" . $n30row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find someone to swap with if you're not. </p> <p>You will be getting another reminder in a couple weeks and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n30row['Task'] . " flags on " . $n30row['HolidayDate'] . ".";

     $n30response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n30response == 'Success') {
         $n30SuccessCount++;
     }
     else {
         $n30FailCount++;
     }
     }
 
 
//    update the database so we don't send the notification again
$n30updatesql = "update schedule set Notified = 30 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 14 and 30 and Notified = 300";
$n30updateresult = $con->query($n30updatesql);
echo "Holidays Notified=30 <br />";
    echo "n30 Email Success: " . $n30SuccessCount . "<br />";
    echo "n30 Email Failures: " . $n30FailCount . "<br />";
}



//Notify Scouts 14 days out
$n14SuccessCount = 0;
$n14FailCount = 0;
$n14sql = "select schedule.*, users.Email, users.AlternateEmail from schedule INNER JOIN users ON schedule.Name=users.Name WHERE DATEDIFF(schedule.HolidayDate,CURDATE()) between 7 and 14 and schedule.Notified = 30";

$n14result = $con->query($n14sql);

if ($n14result->num_rows > 0) {
 while($n14row = $n14result->fetch_assoc()) {
     echo $n14row['HolidayName'] . " Is coming up on " . $n14row['HolidayDate'] . ". " . $n14row['Name'] . " is assigned to " . $n14row['Task'] . " the " . $n14row['Route'] . " Route. <br />";
 
     $recipients = array(
   $n14row['Email'] => $n14row['Name'],
   $n14row['AlternateEmail'] => $n14row['Name']
);

     $RecipEmail = $n14row['Email'];
     $RecipName = $n14row['Name'];
     $Subject = $n14row['Name'] . " Has a Flag" . $n14row['Task'] . " Assignment";
     $Body = "Dear " . $n14row['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to " . $n14row['Task'] . " flags on " . $n14row['HolidayName'] . " (" . $n14row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find someone to swap with if you're not. </p> <p>You will be getting another reminder in one week and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n14row['Task'] . " flags on " . $n14row['HolidayDate'] . ".";

     $n14response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n14response == 'Success') {
         $n14SuccessCount++;
     }
     else {
         $n14FailCount++;
     }
     }
 
 
//    update the database so we don't send the notification again
$n14updatesql = "update schedule set Notified = 14 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 7 and 14 and Notified = 30";
$n14updateresult = $con->query($n14updatesql);
echo "Holidays Notified=30 <br />";
    echo "n14 Email Success: " . $n14SuccessCount . "<br />";
    echo "n14 Email Failures: " . $n14FailCount . "<br />";
}


//Notify Scouts 7 days out
$n7SuccessCount = 0;
$n7FailCount = 0;
$n7sql = "select schedule.*, users.Email, users.AlternateEmail from schedule INNER JOIN users ON schedule.Name=users.Name WHERE DATEDIFF(schedule.HolidayDate,CURDATE()) between 3 and 7 and schedule.Notified = 14";

$n7result = $con->query($n7sql);

if ($n7result->num_rows > 0) {
 while($n7row = $n7result->fetch_assoc()) {
     echo $n7row['HolidayName'] . " Is coming up on " . $n7row['HolidayDate'] . ". " . $n7row['Name'] . " is assigned to " . $n7row['Task'] . " the " . $n7row['Route'] . " Route. <br />";
 
     $recipients = array(
   $n7row['Email'] => $n7row['Name'],
   $n7row['AlternateEmail'] => $n7row['Name']
);

     $RecipEmail = $n7row['Email'];
     $RecipName = $n7row['Name'];
     $Subject = $n7row['Name'] . " Has a Flag" . $n7row['Task'] . " Assignment";
     $Body = "Dear " . $n7row['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to " . $n7row['Task'] . " flags on " . $n7row['HolidayName'] . " (" . $n7row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find someone to swap with if you're not. </p> <p>You will be getting a final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n7row['Task'] . " flags on " . $n7row['HolidayDate'] . ".";

     $n7response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n7response == 'Success') {
         $n7SuccessCount++;
     }
     else {
         $n7FailCount++;
     }
     }
 
 
//    update the database so we don't send the notification again
$n7updatesql = "update schedule set Notified = 7 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 3 and 7 and Notified = 14";
$n7updateresult = $con->query($n7updatesql);
echo "Holidays Notified=30 <br />";
    echo "n7 Email Success: " . $n7SuccessCount . "<br />";
    echo "n7 Email Failures: " . $n7FailCount . "<br />";
}


//Notify Scouts 7 days out
$n1SuccessCount = 0;
$n1FailCount = 0;
$n1sql = "select schedule.*, users.Email, users.AlternateEmail from schedule INNER JOIN users ON schedule.Name=users.Name WHERE DATEDIFF(schedule.HolidayDate,CURDATE()) between 0 and 2 and schedule.Notified = 7";

$n1result = $con->query($n1sql);

if ($n1result->num_rows > 0) {
 while($n1row = $n1result->fetch_assoc()) {
     echo $n1row['HolidayName'] . " Is coming up on " . $n1row['HolidayDate'] . ". " . $n1row['Name'] . " is assigned to " . $n1row['Task'] . " the " . $n1row['Route'] . " Route. <br />";
 
     $recipients = array(
   $n1row['Email'] => $n1row['Name'],
   $n1row['AlternateEmail'] => $n1row['Name']
);

     $RecipEmail = $n1row['Email'];
     $RecipName = $n1row['Name'];
     $Subject = $n1row['Name'] . " Has a Flag" . $n1row['Task'] . " Assignment";
     $Body = "Dear " . $n1row['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to " . $n1row['Task'] . " flags on " . $n1row['HolidayName'] . " (" . $n1row['HolidayDate'] . ").</p> <p>Please go <a href=''>Download Your Route Now</a>.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n1row['Task'] . " flags on " . $n1row['HolidayDate'] . ".";

     $n1response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n1response == 'Success') {
         $n1SuccessCount++;
     }
     else {
         $n1FailCount++;
     }
     }
 
 
//    update the database so we don't send the notification again
$n1updatesql = "update schedule set Notified = 1 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 0 and 2 and Notified = 7";
$n1updateresult = $con->query($n1updatesql);
echo "Holidays Notified=30 <br />";
    echo "n1 Email Success: " . $n1SuccessCount . "<br />";
    echo "n1 Email Failures: " . $n1FailCount . "<br />";
}

?>