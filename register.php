<?php include "conn.php";
session_start();
    
if(!isset($_SESSION["Username"]) or $_SESSION["role"] != 'Admin') {
    // session isn't started
    header('Location: index.php'); // Redirecting To Home Page
}


if (isset($_POST['newusername'])) {
        $newUsername = mysqli_real_escape_string($con, $_POST['newusername']);
        $newName = mysqli_real_escape_string($con, $_POST['newname']);
        $newEmail = mysqli_real_escape_string($con, $_POST['newemail']);
        $rawPassword = mysqli_real_escape_string($con, $_POST['newpassword']);
        $Password = password_hash($rawPassword, PASSWORD_DEFAULT);
        $alternateEmail = mysqli_real_escape_string($con, $_POST['altemail']);
        $role = mysqli_real_escape_string($con, $_POST['role']);
        
    
        $registersql = "INSERT INTO users(Name, Username, Email, Password, AlternateEmail, Role) VALUES ('" . $newName . "','" . $newUsername . "','" . $newEmail . "','" . $Password . "','" . $alternateEmail . "','"  . $role . "')";
        $registerresult = $con->query($registersql);
                            if ($registerresult == "True") {
                                $_SESSION['Notification'] = "User added";
                                }
                                
                            else {
                                $_SESSION['Notification'] = "User NOT added. Try again.";
                                
                                } 
    
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
            <h1>User Management</h1>
            <h2><?php if(isset($_SESSION["displayname"])){ 
        echo $_SESSION["displayname"]; }?> - Add a New User</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Subscription Management</h2>
            <p><?php if(isset($_SESSION["Notification"])){ echo $_SESSION["Notification"]; $_SESSION['Notification'] = '';} ?></p>
            <form class="pure-form pure-form-stacked" method="post" action="register.php">
                <fieldset>
                    <legend>Add a New User</legend>

                    <label for="newname">Name</label>
                    <input id="newname" type="name" placeholder="First and Last Name" name="newname" required>
                    
                    <label for="username">Username</label>
                    <input id="username" type="name" placeholder="Username" name="newusername" required>  
                    
                    <label for="email">Email</label>
                    <input id="email" type="email" placeholder="Email" name="newemail" required>

                    <label for="altemail1">Alternate (Parent) Email 1</label>
                    <input id="altemail1" type="email" placeholder="Dad's Email" name="altemail" required>
                    
                    <label for="password">Password</label>
                    <input id="password" type="password" placeholder="Password" name="newpassword" required>

                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option>Scout</option>
                        <option>Parent</option>
                        <option>Leader</option>
                        <option>Admin</option>
                    </select>

                    <button type="submit" class="pure-button pure-button-primary">Add User</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>


</body>
</html>