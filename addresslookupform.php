 <form class="pure-form pure-form-stacked" action="cxsearch.php" method="GET">
                <fieldset>
                    <legend>Record a New Payment</legend>
                    
                    <label for="houseNum">House Number</label>
                    <input id="houseNum" type="number" placeholder="e.g. 436" name="houseNum" required>
                    
                    <label for="streetName">Street Name</label>
                    <select id="streetName" name="streetName" required>
                        <option value="">Choose One</option>
                        <?php 
                            $sql = "select distinct StreetName from approvedaddresses";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["StreetName"]. "\">" . $row["StreetName"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    
                    <button type="submit" class="pure-button pure-button-primary">Look Up Address</button>
                </fieldset>
            </form>