<?php include "conn.php"; 
include "sendmail.php";

$values = array(
);

// Notify Customers of Status Changes - Expired
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
            $expdrecipients = array(
                $expdrow['Email'] => $expdrow['CustomerName']
            );
            $Subject = 'Your Flag Service Has Ended - Renew Now';
            $Body = "Dear " . $expdrow['CustomerName'] . ", <br /> <p>It's been a great year, but your Flag Service for ". $expdrow['HouseNum'] . " " . $expdrow['StreetName'] ." has expired. <a href='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZRE7QE6F3FHZC'>Click Here to Renew Now</a>. You can also just reply to this e-mail and we'll get back to you.</p> <p> If the web isn't your thing you can give the scoutmaster of Troop 833 a call @ 817.381.6321. </p> <p>We appreciate your continued support.</p> <p>If you think this is an error and your subscription is NOT expired, PLEASE let us know so we can update our records and make it right before the next holiday.</p>Thanks,<br />Troop 833";
            $AltBody = 'Your Flag Service has ended. To Renew, please visit http://troop833.com/flags';

            $expiredresponse = FlagMail($expdrecipients, $Subject, $Body, $AltBody);

            if ($expiredresponse == 'Success') {
                $ExpiredSuccessCount++;
            }
            else {
                $ExpiredFailCount++;
            }
        }
    }
}

$values["Expired Emails Sent: "] = $ExpiredSuccessCount;
$values["Expired Emails Failed: "] = $ExpiredFailCount;
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
            $expgrecipients = array(
                $expgrow['Email'] => $expgrow['CustomerName']
            );
            $Subject = 'Your Flag Service Is Expiring Soon - Renew Now';
            $Body = "Your Flag Service for ". $expgrow['HouseNum'] . " " . $expgrow['StreetName'] ." ends " . $expgrow['ExpirationDate'] . ". You can <a href='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZRE7QE6F3FHZC'>Click Here to Renew Now</a>. You can also just reply to this e-mail and we'll get back to you.</p> <p> If the web isn't your thing you can give the scoutmaster of Troop 833 a call @ 817.381.6321. </p> <p>We appreciate your continued support.</p><p>If you think this is an error and your subscription is NOT expired, PLEASE let us know so we can update our records and make it right before the next holiday.</p>Thanks, <br /> Troop 833";
            $AltBody = 'Your Flag Service ends ' . $expgrow['ExpirationDate'] . '. To Renew, please visit http://troop833.com/flags or reply to this e-mail.';


            $expiringresponse = FlagMail($expgrecipients, $Subject, $Body, $AltBody);

            if ($expiringresponse == 'Success') {
                $ExpiringSuccessCount++;
            }
            else {
                $ExpiringFailCount++;
            }
        }
    }
}

$values["Expiring Soon Emails Sent: "] = $ExpiringSuccessCount;
$values["Expiring Soon Emails Failed: "] = $ExpiringFailCount;

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
            $activerecipients = array(
                $activerow['Email'] => $activerow['CustomerName']
            );
        $Subject = 'Your Flag Service Is Now Active - Thanks For Your Support';
        $Body = "<p>Thank you for your generous support of our Troop. This e-mail is to confirm that your subscription is now active and you will receive service until " . $activerow['ExpirationDate'] . ". </p><p>We are a bunch of volunteers and 12-18 yr-old boys so things don't always run perfectly. If you ever have questions or comments about your flag service (or if we just messed up) please shoot an e-mail to flags@troop833.com or call the Scoutmaster of Troop833, Axel, on his cell at 817.381.6321.</p>Thanks<br />Troop 833";
        $AltBody = "Thank you for your generous support of our Troop. This e-mail is to confirm that your subscription is now active and you will receive service until " . $activerow['ExpirationDate'] . ". Thanks, Troop 833";

        $activeresponse = FlagMail($activerecipients, $Subject, $Body, $AltBody);

        if ($activeresponse == 'Success') {
            $ActiveSuccessCount++;
        }
        else {
            $ActiveFailCount++;
        }
    }
    }
}
$values["Active Emails Sent: "] = $ActiveSuccessCount;
$values["Active Emails Failed: "] = $ActiveFailCount;
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

$values["Expired Result: "] = $ExpirationResult;
$values["Expiring Result: "] = $ExpiringResult;
$values["Active Result: "] = $ActiveResult;

echo $ExpirationResult . "<br / >";
echo $ExpiringResult . "<br / >";
echo $ActiveResult . "<br / >";


// Check for upcoming Holidays


//Notify Scouts 30 days out
$n30SuccessCount = 0;
$n30FailCount = 0;
$n30sql = "select schedule.*, users.Email, users.AlternateEmail from schedule INNER JOIN users ON schedule.Name=users.Name WHERE DATEDIFF(schedule.HolidayDate,CURDATE()) between 14 and 30 and schedule.Notified = 300";

$n30result = $con->query($n30sql);

if ($n30result->num_rows > 0) {
 while($n30row = $n30result->fetch_assoc()) {
//     echo $n30row['HolidayName'] . " Is coming up on " . $n30row['HolidayDate'] . ". " . $n30row['Name'] . " is assigned to " . $n30row['Task'] . " the " . $n30row['Route'] . " Route. <br />";
 
     $recipients = array(
   $n30row['Email'] => $n30row['Name'],
   $n30row['AlternateEmail'] => $n30row['Name']
);

     $RecipEmail = $n30row['Email'];
     $RecipName = $n30row['Name'];
     $Subject = $n30row['Name'] . " Has a Flag " . $n30row['Task'] . " Assignment";
     $Body = "Dear " . $n30row['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to " . $n30row['Task'] . " flags on " . $n30row['HolidayName'] . " (" . $n30row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find someone to swap with if you're not. </p> <p>You will be getting another reminder in a couple weeks and then one final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n30row['Task'] . " flags on " . $n30row['HolidayDate'] . ".";

     $n30response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n30response == 'Success') {
         $n30SuccessCount++;
         //    update the database so we don't send the notification again
         $n30updatesql = "update schedule set Notified = 30 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 14 and 30 and Notified = 300 and ID='". $n30row['ID'] . "'";
         $n30updateresult = $con->query($n30updatesql);
     }
     else {
         $n30FailCount++;
     }
     }
 
 
//    update the database so we don't send the notification again
//$n30updatesql = "update schedule set Notified = 30 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 14 and 30 and Notified = 300";
//$n30updateresult = $con->query($n30updatesql);

    $values["n30 Email Success: "] = $n30SuccessCount;
    $values["n30 Email Failures: "] = $n30FailCount;
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
     $Subject = $n14row['Name'] . " Has a Flag " . $n14row['Task'] . " Assignment";
     $Body = "Dear " . $n14row['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to " . $n14row['Task'] . " flags on " . $n14row['HolidayName'] . " (" . $n14row['HolidayDate'] . ").</p> <p>Please make sure you're available on that day, and find someone to swap with if you're not. </p> <p>You will be getting another reminder in one week and then one final e-mail the day before with a link to your route. For each customer on the route you will see an action. Sometimes that action involves delivering some flyers. If you'd like to print the flyers ahead of time you can <a href='http://flags.troop833.com/files/Flag-Flyer-4x1.pdf'>Download The Latest Flyer.</a></p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n14row['Task'] . " flags on " . $n14row['HolidayDate'] . ".";

     $n14response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n14response == 'Success') {
         $n14SuccessCount++;
         //    update the database so we don't send the notification again
         $n14updatesql = "update schedule set Notified = 14 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 7 and 14 and Notified = 30 and ID='". $n14row['ID'] . "'";
         $n14updateresult = $con->query($n14updatesql);
     }
     else {
         $n14FailCount++;
     }
     }
 
 


echo "Holidays Notified=30 <br />";
    $values["n14 Email Success: "] = $n14SuccessCount;
    $values["n14 Email Failures: "] = $n14FailCount;
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
     $Subject = $n7row['Name'] . " Has a Flag " . $n7row['Task'] . " Assignment";
     $Body = "Dear " . $n7row['Name'] . ", <br /> <p>This is a friendly reminder that you've been assigned to " . $n7row['Task'] . " flags on " . $n7row['HolidayName'] . " (" . $n7row['HolidayDate'] . ").</p> <p>Please just make sure you're available on that day, and find someone to swap with if you're not. </p> <p>You will be getting a final e-mail the day before with your route attached.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n7row['Task'] . " flags on " . $n7row['HolidayDate'] . ".";

     $n7response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n7response == 'Success') {
         $n7SuccessCount++;
         //    update the database so we don't send the notification again
         $n7updatesql = "update schedule set Notified = 7 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 3 and 7 and Notified = 14 and ID='". $n7row['ID'] . "'";
         $n7updateresult = $con->query($n7updatesql);
     }
     else {
         $n7FailCount++;
     }
     }
 
 

echo "Holidays Notified=30 <br />";
    $values["n7 Email Success: "] = $n7SuccessCount;
    $values["n7 Email Failures: "] = $n7FailCount;
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
     $Subject = $n1row['Name'] . " Your Flag " . $n1row['Task'] . " Assignment Has Arrived!";
     $Body = "Dear " . $n1row['Name'] . ", <br /> <p>You've been assigned to " . $n1row['Task'] . " flags on " . $n1row['HolidayName'] . " (" . $n1row['HolidayDate'] . "). You have been assigned the " . $n1row['Route'] . " Route.</p> <p>Please go <a href='http://flags.troop833.com/routereportsearch.php?route=" . $n1row['Route'] . "&name=" . $n1row['Name'] . "'>Download Your Route Now</a>.</p> Thanks,<br />Troop 833";
     $AltBody = "This is a friendly reminder that you've been assigned to " . $n1row['Task'] . " flags on " . $n1row['HolidayDate'] . ".";

     $n1response = FlagMail($recipients, $Subject, $Body, $AltBody);

     if ($n1response == 'Success') {
         $n1SuccessCount++;
         //    update the database so we don't send the notification again
         $n1updatesql = "update schedule set Notified = 1 WHERE DATEDIFF(`HolidayDate`,CURDATE()) between 0 and 2 and Notified = 7 and ID='". $n1row['ID'] . "'";
         $n1updateresult = $con->query($n1updatesql);
     }
     else {
         $n1FailCount++;
     }
     }
 
 

echo "Holidays Notified=30 <br />";
    $values["n1 Email Success: "] = $n1SuccessCount;
    $values["n1 Email Failures: "] = $n1FailCount;
    echo "n1 Email Success: " . $n1SuccessCount . "<br />";
    echo "n1 Email Failures: " . $n1FailCount . "<br />";
}


//Send a Cron Job Report

$reportrecipients = array(
   'axelhawker@gmail.com' => 'Axel Hawker',
);

$Subject = "Daily phpflag Cron Job Report";

$Body = "This is my report: <br />";

foreach($values as $field => $value)
{
   $Body = $Body . $field . $value . "<br />";
}

$AltBody = $Body;

$reportresponse = FlagMail($reportrecipients, $Subject, $Body, $AltBody);

echo "report email: " . $reportresponse;


?>