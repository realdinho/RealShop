<?php

$objOrder = new Order();

$search = Url::getParam('search');

if (!empty($search)) {
    $orders = $objOrder->getOrders($search);
    $empty = 'There are no results matching your searching criteria.';
} else {
    $orders = $objOrder->getOrders();
    $empty = 'There are currently no records.';
}

$objPaging = new Paging($orders, 5);
$rows = $objPaging->getRecords();


$objPaging->_url = '/admin' . $objPaging->_url;

require_once('template/_header.php');
?>

<h1>List of Orders</h1>

<form action="" method="get">
    <?php echo Url::getParams4Search(array('search'), Paging::$_key); ?>
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
        <tr>
            <th><label for="search">Order no.:</label></th>
            <td>
                <input type="text" name="search" value="<?php echo stripslashes($search); ?>" class="fld">
            </td>
            <td>
                <label for="btn_add" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn_add" class="btn" value="Search">
                </label>
            </td>
        </tr>
    </table>
</form>

<?php if (!empty($rows)) { ?>
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
        <tr>
            <th class="col_5">ID</th>
            <th>Date</th>
            <th class="col_15 ta_r">Total</th>
            <th class="col_15 ta_r">Status</th>
            <th class="col_15 ta_r">PP Status</th>
            <th class="col_15 ta_r">Remove</th>
            <th class="col_15 ta_r">View</th>
        </tr>

        <?php foreach ($rows as $order) { ?>

            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo Helper::setDate(1, $order['date']); ?></td>
                <td class="ta_r">&pound;<?php echo number_format($order['total'], 2); ?></td>
                <td class="ta_r">
                    <?php
                    $status = $objOrder->getSatus($order['status']);
                    echo $status['name'];
                    ?>
                </td>
                <td class="ta_r">
                    <?php
                    echo $order['payment_status'] != null ? $order['payment_status'] : 'Pending';
                    ?>
                </td>
                <td class="ta_r">
                    <?php if ($order['status'] == 1) { ?>
                        <a href="/admin/?page=orders&amp;action=remove&amp;id=<?php echo $order['id']; ?>">Remove</a>
                    <?php } else { ?>
                        <span class="inactive">Remove</span>
                    <?php } ?>
                </td>

                <td class="ta_r">
                    <a href="/admin/?page=orders&amp;action=edit&amp;id=<?php echo $order['id']; ?>">
                        View
                    </a>
                </td>
            </tr>

        <?php } ?>
    </table>

    <?php echo $objPaging->getPaging(); ?>

    <?php
} else {
    echo '<p>' . $empty . '</p>';
}
?>


<?php require_once('template/_footer.php'); ?>
