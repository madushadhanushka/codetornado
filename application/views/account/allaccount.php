
<script>
function deleteUser(user_ID){
     var r = confirm("Are sure you want to delete this user");
        if (r == true) {
            window.location = "<?php echo base_url("index.php/account/deleteUser?user_ID=") ?>" + user_ID;
        } else {

        }
}    
</script>
<div class="userhome-upper">
    <div class="form_container">
        <?php echo $username; ?>
        <h3>Accounts</h3>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" href="<?php echo base_url("index.php/account/viewCreateAccount"); ?>">Add New User</a>

        </div>
                <table  class="table">
                <th>ID</th>
                <th>name</th>
                <th>Edit</th>

                <?php
                if (isset($account_detail)) {            // preview all web pages created by the user
                    foreach ($account_detail as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->user_ID ?></td>
                            <td><?php echo $row->username ?></td>
                            <td><a  class="btn btn-primary" target="_blank" href="<?php echo base_url("index.php/main/designpage?page_ID=" . $row->user_ID) ?>">Edit</a> <?php if($row->user_ID!=$user_ID){ ?><a  class="btn btn-primary" onclick="deleteUser(<?php echo $row->user_ID; ?>)">Delete</a><?php } ?></td>

                        </tr>
    <?php }
}
?>
                <tr><td></td><td></td><td></td></tr>  
        
        </table>
    </div>
</div>