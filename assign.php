<?php include "conn.php"; 
session_start();
    if(!isset($_SESSION["Username"])) {
    // session isn't started
        header('Location: index.php'); // Redirecting To Home Page
    }

if (isset($_POST['holidayName']) and !isset($_POST['update'])) {
    $HolidayName = mysqli_real_escape_string($con, $_POST['holidayName']);
    $HolidayDate = mysqli_real_escape_string($con, $_POST['holidayDate']);
    $Name = mysqli_real_escape_string($con, $_POST['scoutName']);
    $Task = mysqli_real_escape_string($con, $_POST['task']);
    $Route = mysqli_real_escape_string($con, $_POST['route']);
    
    
    $sql = "INSERT INTO `schedule`(`HolidayName`, `HolidayDate`, `Name`, `Task`, `Route`, `Notified`) VALUES ('".$HolidayName."','".$HolidayDate."','".$Name."','".$Task."','".$Route."','300')";
    $result = $con->query($sql);
}

else if(isset($_POST['holidayName']) and $_POST['update'] == 'True') {
    $HolidayName = mysqli_real_escape_string($con, $_POST['holidayName']);
    $HolidayDate = mysqli_real_escape_string($con, $_POST['holidayDate']);
    $Name = mysqli_real_escape_string($con, $_POST['scoutName']);
    $Task = mysqli_real_escape_string($con, $_POST['task']);
    $Route = mysqli_real_escape_string($con, $_POST['route']);
    $Notified = mysqli_real_escape_string($con, $_POST['notified']);
    $ID = mysqli_real_escape_string($con, $_POST['ID']);
    
    
    $sql = "UPDATE `schedule` SET `HolidayName`='" . $HolidayName . "',`HolidayDate`='" . $HolidayDate . "',`Name`='" . $Name . "',`Task`='" . $Task . "',`Route`='" . $Route . "',`Notified`='" . $Notified . "' WHERE ID = '" . $ID . "'";
    $result = $con->query($sql);    
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
            <h1>Flag Assignment Manager</h1>
            <h2>View and manage Flag Assignments</h2>
        </div>

        <div class="content">
            <table class='tg'>
              <tr>
                <th class='tg-031e'>Holiday</th>
                <th class='tg-031e'>Scout Assigned</th>
                <th class='tg-031e'>Task</th>
                <th class='tg-031e'>Route</th>
              </tr>
                
                <?php $assignsql = "Select * from schedule WHERE DATEDIFF(`HolidayDate`,CURDATE()) > -5 ORDER By HolidayDate, Task ASC";
                        $result = $con->query($assignsql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){


//Echo Table
        echo"
                <tr>
                <td class='tg-031e'>". $row['HolidayName'] . "<br />" . $row['HolidayDate'] . "</td>
                <td class='tg-031e'>" . $row['Name'] . "</td>
                <td class='tg-031e'>" . $row['Task'] . "</td>
                <td class='tg-031e'>" . $row['Route'] . "</td>";
        if ($_SESSION['role'] == 'Admin') {
                    echo "<td class='tg-031e'><a href='assignedit.php?ID=" . $row['ID'] . "' class='pure-button pure-button-primary'>Edit Assignment</a></td>";
                }
        echo "</tr>";
    }
}

                ?>
                
            </table>
            <?php if ($_SESSION['role'] == 'Admin') {
                    include('assignform.php');
                } ?>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>