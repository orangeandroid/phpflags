                <li class="pure-menu-item"><a href="index.php" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item"><a href="newpayment.php" class="pure-menu-link">Customers</a></li>
                <li class="pure-menu-item"><a href="routes.php" class="pure-menu-link">Routes</a></li>
                <li class="pure-menu-item"><a href="assign.php" class="pure-menu-link">Assignments</a></li>
                <li class="pure-menu-item"><a href="sales.php" class="pure-menu-link">Sales Tasks</a></li>
<?php 

if (isset($_SESSION['role']) and $_SESSION['role'] == 'Admin') { 
    echo "<li class='pure-menu-item'><a href='register.php' class='pure-menu-link'>Users</a>";
}
?>
                <li class="pure-menu-item"><a href="logout.php" class="pure-menu-link">Logout</a>
                    
                </li>