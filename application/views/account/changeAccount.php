<div class="userhome-upper">
    <div class="form_container">
        <form method="post" action="<?php echo base_url('index.php/install/installDetail') ?>" class="form-horizontal">
            <h3>Database details</h3>
            <?php if (isset($formerror)) { ?><span class="help-block"><?php echo $formerror ?></span><?php } ?>
                       
            <div class="form-group">
                <?php if (isset($formerror_username)) { ?><div class="form-group has-error"><?php } ?>
                    <label class="control-label col-xs-2">Username</label>
                    <div class="col-xs-10">
                        <input type="text" name="hostname"  class="form-control" placeholder="Host" value="localhost"/>
                        <?php if (isset($formerror_username)) { ?><span class="help-block"><?php echo $formerror_username ?></span><?php } ?>
                        <?php if (isset($formerror_username)) { ?>    </div><?php } ?>
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_password)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Host name</label>
                    <div class="col-xs-10">
                        <input type="text" name="hostname"  class="form-control" placeholder="Host" value="localhost"/>
                        <?php if (isset($formerror_hostname)) { ?><span class="help-block"><?php echo $formerror_hostname ?></span><?php } ?>
                        <?php if (isset($formerror_hostname)) { ?>    </div><?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>