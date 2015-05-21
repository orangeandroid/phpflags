if (empty($_POST['username'])) { 
         echo "";
    }
    else {
        $Username = mysqli_real_escape_string($con, $_POST['username']);
        $Password = mysqli_real_escape_string($con, $_POST['password']);
        $loginsql = "Select Name, Password from users where Email = '" . $Username . "' and Password = '" . $Password . "'";
        $loginresult = $con->query($loginsql);
                            if ($loginresult->num_rows == 1) {
                                    $loginrow = $loginresult->fetch_assoc();
                                    $_SESSION["displayname"] = $loginrow["Name"];
                                    $_SESSION["Axel"] = "Awesome";
                                }
                                
                            else {
                                echo "Looks like you've entered an incorrect password. ";
                                echo "You entered " . $Password;
                                    $loginrow = $loginresult->fetch_assoc();
                                echo " Your username was " . $Username;
                                }
                                
                            }