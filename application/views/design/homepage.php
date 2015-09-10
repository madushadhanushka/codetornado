<script>
    function deletePage(page_ID) {
        var r = confirm("Are sure you want to delete this page");
        if (r == true) {
            window.location = "<?php echo base_url("index.php/page/deletePage?page_ID=") ?>" + page_ID;
        } else {

        }
    }
    function deleteModule(module_name){
            var r = confirm("Are sure you want to delete this module");
        if (r == true) {
            window.location = "<?php echo base_url("index.php/page/deleteModule?module_name=") ?>" + module_name;
        } else {

        }
    }
</script>
<div class="userhome-upper">
    <div class="form_container">
        <?php echo $username; ?>
        <h3>Pages</h3>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" id="add_new_page" href="<?php echo base_url("index.php/page/viewCreatePage"); ?>">Add New Page</a>
            <a class="btn btn-default" id="add_new_module" href="<?php echo base_url("index.php/page/viewCreateModule"); ?>">Create New Module</a>

        </div>
        <table  class="table">
            <form action="<?php echo base_url("index.php/main/homePage"); ?>" method="post">
                <th>ID</th>
                <th>Title</th>
                <th>Edit</th>
                <th>Index page</th>

                <?php
                if (isset($page_detail)) {            // preview all web pages created by the user
                    foreach ($page_detail as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->page_ID ?></td>
                            <td><?php echo $row->name ?></td>
                            <td><a  class="btn btn-primary" target="_blank" href="<?php echo base_url("index.php/main/designpage?page_ID=" . $row->page_ID) ?>">Edit</a> <a  class="btn btn-primary" onclick="deletePage(<?php echo $row->page_ID; ?>)">Delete</a></td>

                            <td><input type="radio" name="index_page" value="<?php echo $row->page_ID ?>" <?php
                                if ($index_page == $row->page_ID) {
                                    echo 'checked';
                                }
                                ?>/></td>
                        </tr>
    <?php }
}
?>
                <tr><td></td><td></td><td></td><td><input type="submit" value="Update"/></td></tr>  
            </form>    
        </table>
        <hr>

        <h3>Modules</h3>
        <table  class="table">
            <th>Name</th>
            <th>Description</th>
            <th>Edit</th>
<?php
if (isset($module_detail)) {            // preview all available modules
    foreach ($module_detail as $row) {
        ?>
                    <tr>
                        <td><?php echo $row->name ?></td>
                        <td><?php echo $row->description ?></td>
                        <td><a  class="btn btn-primary" target="_blank" href="<?php echo base_url("index.php/main/designModule?module_ID=" . $row->name) ?>">Edit</a> <a  class="btn btn-primary" onclick="deleteModule('<?php echo $row->name; ?>')">Delete</a></td>

                    </tr>
    <?php }
}
?>
        </table>
    </div>
</div>