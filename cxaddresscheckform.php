<form class="pure-form pure-form-stacked" action="cxsignup.php" method="GET">
                <fieldset>
                    <legend>Sign up for our Troop's Flag Service</legend>
                    
                    <label for="houseNum">House Number</label>
                    <input id="houseNum" type="number" placeholder="e.g. 436" name="houseNum" required>
                    
                    <label for="streetName">Street Name</label>
                    <select id="streetName" name="streetName" required>
                        <option value="">Choose One</option>
                        <?php
//                            $cxsql = "select distinct StreetName from customers";
//                            $cxresult = $con->query($cxsql);
                            $sql = "select distinct StreetName from alladdresses order by StreetName ASC";
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
                    <input type="hidden" name="step" value='1'>
                    <button type="submit" class="pure-button pure-button-primary">Next Step</button>
                </fieldset>
            </form>