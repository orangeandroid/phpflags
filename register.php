<?php session_start();
    include "conn.php";
                if(!isset($_SESSION["Username"])) {
                    // session isn't started
                    header('Location: index.php'); // Redirecting To Home Page
                }


if (!isset($_SESSION['newusername'])) {
                                
}

else {
        $newName = mysqli_real_escape_string($con, $_POST['newname']);
        $newEmail = mysqli_real_escape_string($con, $_POST['newusername']);
        $rawPassword = mysqli_real_escape_string($con, $_POST['newpassword']);
        $Password = password_hash($rawPassword, PASSWORD_DEFAULT);
        $alternateEmail = mysqli_real_escape_string($con, $_POST['altemail']);
        $role = mysqli_real_escape_string($con, $_POST['role']);
        
    
        $registersql = "INSERT INTO users(Name, Email, Password, AlternateEmail, Role) VALUES ('" . $newName . "','" . $newEmail . "','" . $Password . "','" . $alternateEmail . "','"  . $role . "')";
        $registerresult = $con->query($registersql);
                            if ($registerresult == "True") {
                                    echo "User added";
                                }
                                
                            else {
                                echo "User NOT added. Try again.";
                                echo $registersql;
                                } 
    
}

?>

        <form class="pure-form pure-form-stacked" method="post" action="register.php">
    <fieldset>
        <legend>Add a New User</legend>
           
        <label for="newname">Email</label>
        <input id="newname" type="name" placeholder="First and Last Name" name="newname" required>

        <label for="email">Email</label>
        <input id="email" type="email" placeholder="Email" name="newusername" required>
           
        <label for="altemail">Alternat (Parent) Email</label>
        <input id="altemail" type="email" placeholder="Parent's Email" name="altemail" required>

        <label for="password">Password</label>
        <input id="password" type="password" placeholder="Password" name="newpassword" required>
           
        <label for="role">State</label>
        <select id="role" name="role" required>
            <option>Scout</option>
            <option>Parent</option>
            <option>Leader</option>
            <option>Admin</option>
        </select>

        <button type="submit" class="pure-button pure-button-primary">Add User</button>
    </fieldset>
</form>