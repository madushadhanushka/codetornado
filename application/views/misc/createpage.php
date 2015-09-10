<div class="userhome-upper">
    <div class="form_container">
        <form method="post" action="<?php echo base_url('index.php/page/createpage') ?>" class="form-horizontal">
            <h3>Add New Page</h3>
            
            <span class="help-block"><?php echo validation_errors() ?></span>
                     
            <div class="form-group">
                <?php if (isset($formerror_name)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Page name</label>
                    <div class="col-xs-10">
                        <input type="text" name="pagename"  class="form-control" placeholder="Page name"/>
                        <?php if (isset($formerror_name)) { ?><span class="help-block"><?php echo $formerror_name ?></span><?php } ?>
                        <?php if (isset($formerror_name)) { ?>    </div><?php } ?>
                </div>
            </div>
            <div class="form-group">
                <?php if (isset($formerror_description)) { ?><div class="form-group has-error"><?php } ?>
                    <label for="inputEmail" class="control-label col-xs-2">Description</label>
                    <div class="col-xs-10">
                        <input type="text" name="description"  class="form-control" placeholder="Description"/>
                        <?php if (isset($formerror_description)) { ?><span class="help-block"><?php echo $formerror_description ?></span><?php } ?>
                        <?php if (isset($formerror_description)) { ?>    </div><?php } ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-10">
                    <button type="submit" class="btn btn-primary" id="create_page">Create Page</button>
                </div>
            </div>
        </form>
    </div>
</div>