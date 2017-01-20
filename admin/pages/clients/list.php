<?php

$objUser = new User();

$objOrder = new Order();


$search = Url::getParam('search');

if (!empty($search)) {
    $users = $objUser->getUsers($search);
    $empty = 'There are no results matching your searching criteria.';
} else {
    
    $users = $objUser->getUsers();
    $empty = 'There are currently no records.';
}

$objPaging = new Paging($users, 5);
$rows = $objPaging->getRecords();


$objPaging->_url = '/admin' . $objPaging->_url;

require_once('template/_header.php');
?>

<h1>List of Clients</h1>

<form action="" method="get">
    <?php echo Url::getParams4Search(array('search'), Paging::$_key); ?>
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
        <tr>
            <th><label for="search">Name.:</label></th>
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
            <th>Name</th>
            <th class="col_15 ta_r">Remove</th>
            <th class="col_15 ta_r">View</th>
        </tr>

        <?php foreach ($rows as $user) { ?>

            <tr>
                <td><?php echo Helper::encodeHTML($user['first_name'].' '.$user['last_name']); ?></td>
                <td class="ta_r">
                    <?php

                    $orders = $objOrder->getClientOrders($user['id']);

                    if (empty($orders)) { ?>
                        <a href="/admin/?page=clients&amp;action=remove&amp;id=<?php echo $user['id']; ?>">Remove</a>
                    <?php } else { ?>
                        <span class="inactive">Remove</span>
                    <?php } ?>
                </td>

                <td class="ta_r">
                    <a href="/admin/?page=clients&amp;action=edit&amp;id=<?php echo $user['id']; ?>">
                        Edit
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
