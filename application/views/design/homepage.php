<div class="userhome-upper">
    <div class="form_container">
        <h3>Pages</h3>
        <input type="button" value="Add new page"  class="btn btn-primary" />
        <table  class="table">
    <th>ID</th>
    <th>Cutomer Name</th>
    <th>edit</th>
    
<?php if (isset($page_detail)) {
    foreach ($page_detail as $row) { ?>
        <tr>
            <td><?php echo $row->page_ID ?></td>
            <td><?php echo $row->name ?></td>
            <td><a  class="btn btn-primary" href="<?php echo base_url("index.php/main/designpage?page_ID=".$row->page_ID) ?>">Edit</a></td>
</tr>
<?php }} ?>

</table>
    </div>
</div>