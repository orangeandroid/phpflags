<?php include "conn.php"; 
session_start();
    if(!isset($_SESSION["Username"])) {
    // session isn't started
        header('Location: index.php'); // Redirecting To Home Page
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
                <th class='tg-031e'>Route</th>
                <th class='tg-031e'>Setup</th>
                <th class='tg-031e'>TakeDown</th>
              </tr>
                
                <?php $assignsql = "Select * from schedule WHERE DATEDIFF(`HolidayDate`,CURDATE()) > -1";
                        $result = $con->query($assignsql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){


//Echo Table
        echo"
                <tr>
                    <td class='tg-031e' rowspan='4'>". $row['HolidayName'] . "<br />" . $row['HolidayDate'] . "</td>
                <td class='tg-031e'>" . $row['Route1'] . "</td>
                <td class='tg-031e'>" . $row['SetUp1'] . "</td>
                <td class='tg-031e'>" . $row['TakeDown1'] . "</td>
              </tr>
              <tr>
                <td class='tg-031e'>" . $row['Route2'] . "</td>
                <td class='tg-031e'>" . $row['SetUp2'] . "</td>
                <td class='tg-031e'>" . $row['TakeDown2'] . "</td>
              </tr>
              <tr>
                <td class='tg-031e'>" . $row['Route3'] . "</td>
                <td class='tg-031e'>" . $row['SetUp3'] . "</td>
                <td class='tg-031e'>" . $row['TakeDown3'] . "</td>
              </tr>
              <tr>
                <td class='tg-031e'>" . $row['Route4'] . "</td>
                <td class='tg-031e'>" . $row['SetUp4'] . "</td>
                <td class='tg-031e'>" . $row['TakeDown4'] . "</td>
              </tr>";
    }
}

                ?>
                
            </table>
        </div>
    </div>
</div>





<script src="js/ui.js"></script>


</body>
</html>