<div class="userhome-upper">
    <div class="form_container">
        <form method="post" action="<?php echo base_url('index.php/install/installDetail') ?>" class="form-horizontal">
            <h3>Database details</h3>
            <?php if (isset($formerror)) { ?><span class="help-block"><?php echo $formerror ?></span><?php } ?>
                        <?php if (isset($formerror)) { ?>    </div><?php } ?>
            <div class="form-group">
                <?php if (isset($formerror_hostname)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Host name</label>
                    <div class="col-xs-10">
                        <input type="text" name="hostname"  class="form-control" placeholder="Host" value="localhost"/>
                        <?php if (isset($formerror_hostname)) { ?><span class="help-block"><?php echo $formerror_hostname ?></span><?php } ?>
                        <?php if (isset($formerror_hostname)) { ?>    </div><?php } ?>
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_mysqlusername)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">MySql Username</label>
                    <div class="col-xs-10">
                        <input type="text" name="mysqlusername"  class="form-control" placeholder="Username" value="root"/>
                        <?php if (isset($formerror_mysqlusername)) { ?><span class="help-block"><?php echo $formerror_mysqlusername ?></span><?php } ?>
                        <?php if (isset($formerror_mysqlusername)) { ?>    </div><?php } ?> 
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_mysqlpassword)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">MySql Password</label>
                    <div class="col-xs-10">
                        <input type="password" name="mysqlpassword"  class="form-control" placeholder="" value=""/>
                        <?php if (isset($formerror_mysqlpassword)) { ?><span class="help-block"><?php echo $formerror_mysqlpassword ?></span><?php } ?>
                        <?php if (isset($formerror_mysqlpassword)) { ?>    </div><?php } ?>
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_mysqldb)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Database name</label>
                    <div class="col-xs-10">
                        <input type="text" name="mysqldb"  class="form-control" placeholder="Database name" value="codetornado" />
                        <?php if (isset($formerror_mysqldb)) { ?><span class="help-block"><?php echo $formerror_mysqldb ?></span><?php } ?>
                        <?php if (isset($formerror_mysqldb)) { ?>    </div><?php } ?>
                </div>
            </div>

            <h3>User account details</h3>

            <div class="form-group">
                <?php if (isset($formerror_accountname)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Name</label>
                    <div class="col-xs-10">
                        <input type="text" name="accountname"  class="form-control" placeholder="Name" />
                        <?php if (isset($formerror_accountname)) { ?><span class="help-block"><?php echo $formerror_accountname ?></span><?php } ?>
                        <?php if (isset($formerror_accountname)) { ?>    </div><?php } ?> 
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_username)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Username</label>
                    <div class="col-xs-10">
                        <input type="text" name="username"  class="form-control" placeholder="Username" />
                        <?php if (isset($formerror_username)) { ?><span class="help-block"><?php echo $formerror_username ?></span><?php } ?>
                        <?php if (isset($formerror_username)) { ?>    </div><?php } ?> 
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_password)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Password</label>
                    <div class="col-xs-10">
                        <input type="password" name="password"  class="form-control" placeholder="Password" />
                        <?php if (isset($formerror_password)) { ?><span class="help-block"><?php echo $formerror_password ?></span><?php } ?>
                        <?php if (isset($formerror_password)) { ?>    </div><?php } ?>
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_cpassword)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Confirm Password</label>
                    <div class="col-xs-10">
                        <input type="password" name="cpassword"  class="form-control" placeholder="Conform Password" />
                        <?php if (isset($formerror_cpassword)) { ?><span class="help-block"><?php echo $formerror_cpassword ?></span><?php } ?>
                        <?php if (isset($formerror_cpassword)) { ?>    </div><?php } ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary">Install</button>
                </div>
            </div>
        </form>
    </div>
</div>
