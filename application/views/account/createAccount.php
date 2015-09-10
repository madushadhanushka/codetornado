<div class="userhome-upper">
    <div class="form_container">
        <form method="post" action="<?php echo base_url('index.php/account/addUser') ?>" class="form-horizontal">
            <h3>Database details</h3>
            <?php if (isset($formerror)) { ?><span class="help-block"><?php echo $formerror ?></span><?php } ?>
        <?php if (isset($formerror)) { ?>    </div><?php } ?>
    <div class="form-group">
        <?php if (isset($formerror_username)) { ?><div class="form-group has-error"><?php } ?>
            <label for="inputEmail" class="control-label col-xs-2">Username</label>
            <div class="col-xs-10">
                <input type="text" name="username"  class="form-control" placeholder="Username"/>
                <?php if (isset($formerror_username)) { ?><span class="help-block"><?php echo $formerror_username ?></span><?php } ?>
                <?php if (isset($formerror_username)) { ?>    </div><?php } ?>
        </div>
    </div>
    <div class="form-group">
        <?php if (isset($formerror_password)) { ?><div class="form-group has-error"><?php } ?>
            <label for="inputEmail" class="control-label col-xs-2">Password</label>
            <div class="col-xs-10">
                <input type="text" name="password"  class="form-control" placeholder="Password"/>
                <?php if (isset($formerror_password)) { ?><span class="help-block"><?php echo $formerror_password ?></span><?php } ?>
                <?php if (isset($formerror_password)) { ?>    </div><?php } ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary">Create Account</button>
        </div>
    </div>
</form>
</div>
</div>
