 <form class="pure-form pure-form-stacked" action="myaccount.php" method="POST">
                <fieldset>
                    <legend>Change Your E-mail</legend>
                    
                    <label for="primary">Primary Email Address</label>
                    <input id="primary" type="email" placeholder="Primary Email" name="primaryemail" <?php echo 'value="' . $primaryemail . '"' ?> required>
                    <label for="secondary">Primary Email Address</label>
                                        <input id="secondary" type="email" placeholder="Secondary Email" name="secondaryemail" <?php echo 'value="' . $secondaryemail . '"' ?> required>
                    
                    <button type="submit" class="pure-button pure-button-primary" name="infochange-submit" value = "Change Info">Change Email</button>
                </fieldset>
            </form>