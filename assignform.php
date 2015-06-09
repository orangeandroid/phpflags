<h2>Add/Edit an Assignment</h2>
    <form class='pure-form' action = 'assign.php' method="post">
        <fieldset>
            <legend>Add Assignment</legend>
            
            <label for="holidayName">Holiday Name</label>
            <input id="holidayName" type="text" placeholder="Holiday" name="holidayName" required>
            
            <label for="holidayDate">Holiday Date</label>
            <input id="holidayDate" type='date' name="holidayDate" required>
            
            <br /> <br />
                
            <label for="scoutName">Scout</label>
            <select id="scoutName" name="scoutName" required>
                <option value="">Choose One</option>
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
                <option value="Set Up">Set Up</option>
                <option value="Take Down">Take Down</option>
            </select>
            
            
                    <label for="Route">Route</label>
                    <select id="Route" name="route" required>
                       <option value="">Choose One</option>
                        <?php
if ($NewCX == "False") {
    echo "<option selected='selected' value= '" . $CXRoute . "'>" . $CXRoute . "</option>";
}
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
            
            <button type="submit" class="pure-button pure-button-primary">Add Assignment</button>
        </fieldset>
    </form>
    
