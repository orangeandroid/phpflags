 <form class="pure-form pure-form-stacked" action="myaccount.php" method="POST">
                <fieldset>
                    <legend>Change Your Password</legend>
                    
                    <label for="oldpw">Current Password</label>
                    <input id="oldpw" type="password" placeholder="Primary Email" name="oldpw" required>
                    <label for="newpw1">New Password</label>
                    <input id="newpw1" type="password" placeholder="New Password" name="newpw1" required>
                    <label for="newpw2">New Password Again</label>
                    <input id="newpw2" type="password" placeholder="Repeat New Password" name="newpw2" required>
                    
                    <button type="submit" class="pure-button pure-button-primary" name="pwchange-submit" value = "Change Password">Change Password</button>
                </fieldset>
            </form>