<?php

$objCatalogue = new Catalogue();
$categories = $objCatalogue->getCategories();


$objPaging = new Paging($categories, 5);
$rows = $objPaging->getRecords();


$objPaging->_url = '/admin' . $objPaging->_url;

require_once('template/_header.php'); 
?>

<h1>List Categories</h1>

<p><a href="/admin/?page=categories&amp;action=add">New Category</a></p>

<?php if (!empty($rows)) { ?>
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
        <tr>
            <th class="col_5">ID</th>
            <th>Category</th>
            <th class="col_15 ta_r">Remove</th>
            <th class="col_15 ta_r">Edit</th>
        </tr>

        <?php foreach ($rows as $cat) { ?>

            <tr>
                <td><?php echo $cat['id'];?></td>
                <td><?php echo Helper::encodeHTML($cat['name']);?></td>
                <td class="ta_r">
                    <a href="/admin/?page=categories&amp;action=remove&amp;id=<?php echo $cat['id'];?>">
                        Remove
                    </a>
                </td>
                <td class="ta_r">
                    <a href="/admin/?page=categories&amp;action=edit&amp;id=<?php echo $cat['id'];?>">
                        Edit
                    </a>
                </td>
            </tr>

        <?php } ?>
    </table>

    <?php echo $objPaging->getPaging();?>
    
    <?php
} else {
    echo '<p>There are currently no categories. </p>';
}
?>


<?php require_once('template/_footer.php'); ?>
