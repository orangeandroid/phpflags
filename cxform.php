<form class="pure-form pure-form-stacked" action="cxupdate.php" method="POST">
                <fieldset>
                    <legend>Add/Edit Information</legend>
                    
                    <label for="name">Customer Name</label>
                    <input id="name" type="text" placeholder="John Smith" name="customername" 
                           <?php 
    if (empty($CXName)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXName . "\"";
    }
                           ?> required>
                    
                    <label for="phone">Phone Number</label>
                    <input id="phone" type="tel" placeholder="555-555-1234" name="phone" 
                           <?php 
    if (empty($CXPhone)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXPhone . "\"";
    }
                           ?>>
                    
                    <label for="email">E-mail</label>
                    <input id="email" type="email" placeholder="yourname@example.com" name="email" 
                           <?php 
    if (empty($CXEmail)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXEmail . "\"";
    }
                           ?>>                    
                    
                    <label for="paymentmethod">Payment Method</label>
                    <select id="paymentmethod" name="paymentmethod">
                       <option value="">Choose One</option>
                        
                        <?php
//Show current option as selected
if ($NewCX == "False") {
    echo "<option selected='selected' value= '" . $CXPaymentMethod . "'>" . $CXPaymentMethod . "</option>";
}
//return valid routes from DB
                            $sql = "select PaymentMethod from options where PaymentMethod<>''";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["PaymentMethod"]. "\">" . $row["PaymentMethod"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
                    </select>
                    
                    <label for="paymentid">Payment ID</label>
                    <input id="paymentid" type="text" placeholder="Check Number or Transaction ID" name="paymentid" 
                           <?php 
    if (empty($CXPaymentID)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXPaymentID . "\"";
    }
                           ?>>     

                    <label for="paymentdate">Payment Date</label>
                    <input id="paymentdate" type="date" placeholder="01/04/2015" name="paymentdate" 
                           <?php 
    if (empty($CXPaymentDate)) { 
         echo "";
    }
    else {
        echo "value=\"" . $CXPaymentDate . "\"";
    }
                           ?> required> 
                    
                    <label for="vetstatus">Veteran(s) in Home?</label>
                    <select id="vetstatus" name="vetstatus" required>
                       <option value="">Choose One</option>
                        <?php
                        if ($NewCX == "False") {
    echo "<option selected='selected' value= '" . $CXVetStatus . "'>" . $CXVetStatus . "</option>";
}
                         
                            $sql = "select VetStatus from options where VetStatus != ''";
                            $result = $con->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value= \"" . $row["VetStatus"]. "\">" . $row["VetStatus"]. "</option>";
                                }
                            } 
    
                            else {
                                echo "";
                            }
                        ?>
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
                    
                    <label for="scoutcredit1">Scout Credit 1</label>
                    <select id="scoutcredit1" name="scoutcredit1">
                       <option value="">Choose One</option>
                        <?php
if ($NewCX == "False") {
    echo "<option selected='selected' value= '" . $CXScoutCredit1 . "'>" . $CXScoutCredit1 . "</option>";
}
                            $sql = "select Name from users";
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
                    
                    <label for="scoutcredit2">Scout Credit 2</label>
                    <select id="scoutcredit2" name="scoutcredit2">
                       <option value="">Choose One</option>
                        <?php
if ($NewCX == "False") {
    echo "<option selected='selected' value= '" . $CXScoutCredit2 . "'>" . $CXScoutCredit2 . "</option>";
}
                            $sql = "select Name from users";
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
                    
                    <label for="submittedby">Submitted By</label>
                    <select id="submittedby" name="submittedby">
                       <option value="">Choose One</option>
                        <?php 
if ($NewCX == "False") {
    echo "<option selected='selected' value= '" . $CXSubmittedBy . "'>" . $CXSubmittedBy . "</option>";
}
                            $sql = "select Name from users";
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
                    <input type="hidden" value="<?php echo $HouseNum; ?>" name="HouseNum">
                    <input type="hidden" value="<?php echo $StreetName; ?>" name="StreetName">
                    <input type="hidden" value="<?php echo $NewCX; ?>" name="newcx">
                    <button type="submit" class="pure-button pure-button-primary">Submit</button>
                </fieldset>
            </form>