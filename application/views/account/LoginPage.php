<div class="userhome-upper" style="width: 500px; margin-top:200px">
    <div class="form_container"  style="width: 400px">
        <form method="post" action="<?php echo base_url('index.php/account/loginUser') ?>" class="form-horizontal">
            <div class="form-group">

                <label class="control-label col-xs-2">Username</label>
                <div class="col-xs-10">
                    <input type="text" name="username"  class="form-control" placeholder="Username"/>

                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-xs-2">Password</label>
                <div class="col-xs-10">
                    <input type="password" name="password"  class="form-control" placeholder="Password"/>

                </div>
            </div>
            <div class="form-group" style="margin-left: 300px">
                <div class="col-xs-offset-2 col-xs-10">
                    <input type="submit" value="Login"  class="btn btn-primary" />
                </div>
            </div> 
        </form>
    </div>
</div>