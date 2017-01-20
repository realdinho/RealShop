<?php

$objCatalogue = new Catalogue();

$search = Url::getParam('search');

if (!empty($search)) {
    $products = $objCatalogue->getAllProducts($search);
    $empty = 'There are no results matching your searching criteria.';
} else {
    $products = $objCatalogue->getAllProducts();
    $empty = 'There are currently no records.';
}

$objPaging = new Paging($products, 5);
$rows = $objPaging->getRecords();


$objPaging->_url = '/admin' . $objPaging->_url;

require_once('template/_header.php'); 
?>

<h1>List Products</h1>

<form action="" method="get">
    <?php echo Url::getParams4Search(array('search'), Paging::$_key);?>
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
        <tr>
            <th><label for="search">Product:</label></th>
            <td>
                <input type="text" name="search" value="<?php echo stripslashes($search);?>" class="fld">
            </td>
            <td>
                <label for="btn_add" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn_add" class="btn" value="Search">
                </label>
            </td>
        </tr>
    </table>
</form>

<div class="dev br_td">&#160;</div>

<p><a href="/admin/?page=products&amp;action=add">New product</a></p>

<?php if (!empty($rows)) { ?>
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
        <tr>
            <th class="col_5">ID</th>
            <th>Product</th>
            <th class="col_15 ta_r">Remove</th>
            <th class="col_15 ta_r">Edit</th>
        </tr>

        <?php foreach ($rows as $product) { ?>

            <tr>
                <td><?php echo $product['id'];?></td>
                <td><?php echo Helper::encodeHTML($product['name']);?></td>
                <td class="ta_r">
                    <a href="/admin/?page=products&amp;action=remove&amp;id=<?php echo $product['id'];?>">
                        Remove
                    </a>
                </td>
                <td class="ta_r">
                    <a href="/admin/?page=products&amp;action=edit&amp;id=<?php echo $product['id'];?>">
                        Edit
                    </a>
                </td>
            </tr>

        <?php } ?>
    </table>

    <?php echo $objPaging->getPaging();?>
    
    <?php
} else {
    echo '<p>' . $empty . '</p>';
}
?>


<?php require_once('template/_footer.php'); ?>
