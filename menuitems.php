 
                <li class="pure-menu-item"><a href="index.php" class="pure-menu-link">Home</a></li>
<?php
if(isset($_SESSION['Username'])){
                echo '<li class="pure-menu-item"><a href="newpayment.php" class="pure-menu-link">Customers</a></li>';
                echo '<li class="pure-menu-item"><a href="routes.php" class="pure-menu-link">Routes</a></li>';
                echo '<li class="pure-menu-item"><a href="assign.php" class="pure-menu-link">Assignments</a></li>';
                echo '<li class="pure-menu-item"><a href="sales.php" class="pure-menu-link">Sales Tasks</a></li>';
}

if (isset($_SESSION['role']) and $_SESSION['role'] == 'Admin') { 
    echo "<li class='pure-menu-item'><a href='register.php' class='pure-menu-link'>Users</a>";
    echo "<li class='pure-menu-item'><a href='approvedaddress.php' class='pure-menu-link'>Streets</a>";
}
?>
<?php
if(isset($_SESSION['Username'])){
echo '<li class="pure-menu-item"><a href="myaccount.php" class="pure-menu-link">My Account</a></li>';    
echo '<li class="pure-menu-item"><a href="logout.php" class="pure-menu-link">Logout</a></li>';
                    }
else {
    echo '<li class="pure-menu-item"><a href="#" class="pure-menu-link">Sign In</a></li>';
}
                