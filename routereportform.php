 <form class="pure-form pure-form-stacked" action="routereportsearch.php" method="GET">
                <fieldset>
                    <legend>View a Route</legend>
                    
                    <label for="Route">Route</label>
                    <select id="Route" name="route">
                       <option value="">Choose One</option>
                        <?php 
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
                    
                    <button type="submit" class="pure-button pure-button-primary">View Route</button>
                </fieldset>
            </form>