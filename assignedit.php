<?php include "conn.php"; 
session_start();
    if($_SESSION['role'] != 'Admin') {
    // session isn't started
        header('Location: index.php'); // Redirecting To Home Page
    }

if (isset($_GET['ID'])) {
    $ID = mysqli_real_escape_string($con, $_GET['ID']);
    
    
    
    $sql = "select * from `schedule` where ID = '" . $ID ."'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    
    $HolidayName = $row['HolidayName'];
    $HolidayDate = $row['HolidayDate'];
    $Name = $row['Name'];
    $Task = $row['Task'];
    $Route = $row['Route'];
    $Notified = $row['Notified'];
    
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
            
           <h2>Add/Edit an Assignment</h2>
    <form class='pure-form' action = 'assign.php' method="post">
        <fieldset>
            <legend>Add Assignment</legend>
            
            <label for="holidayName">Holiday Name</label>
            <input id="holidayName" type="text" placeholder="Holiday" name="holidayName" value='<?php echo $HolidayName; ?>' required>
            
            <label for="holidayDate">Holiday Date</label>
            <input id="holidayDate" type='date' name="holidayDate" value='<?php echo $HolidayDate; ?>' required>
            
            <br /> <br />
                
            <label for="scoutName">Scout</label>
            <select id="scoutName" name="scoutName" required>
                <option value="<?php echo $Name; ?>"><?php echo $Name; ?></option>
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
                    
            <label for="task">Task</label>
            <select id="task" name="task" required>
                <?php  echo "<option selected='selected' value= '" . $Task . "'>" . $Task . "</option>"; ?>
                <option value="Set Up">Set Up</option>
                <option value="Take Down">Take Down</option>
            </select>
            
            
                    <label for="Route">Route</label>
                    <select id="Route" name="route" required>
                       <option value="<?php echo $Route; ?>"><?php echo $Route; ?></option>
                        <?php

echo "<option selected='selected' value= '" . $Route . "'>" . $Route . "</option>";

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
                        <label for="notified">Notification</label>
            <select id="notified" name="notified" required>
              <?php  echo "<option selected='selected' value= '" . $Notified . "'>" . $Notified . "</option>"; ?>
                
                <option value="300">New</option>
                <option value="30">30 Days</option>
                <option value="14">14 Days</option>
                <option value="7">7 Days</option>
                <option value="2">2 Days</option>
            </select>
            <input type='hidden' name='update' value='True'>
            <input type='hidden' name='ID' value='<?php echo $ID; ?>'>
            <button type="submit" class="pure-button pure-button-primary">Submit Change</button>
        </fieldset>
    </form>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>