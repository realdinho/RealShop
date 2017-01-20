<?php


$id = Url::getParam('id');

if (!empty($id)) {

    $objOrder = new Order();
    $order = $objOrder->getOrder($id);

    if (!empty($order)) {

        $objForm = new Form();
        $objValid = new Validation($objForm);

        $objUser = new User();
        $user = $objUser->getUser($order['client']);

        $objCountry = new Country();
        $objCatalogue = new Catalogue();
        $items = $objOrder->getOrderItems($id);

        $status = $objOrder->getStatuses();

        if ($objForm->isPost('status')) {

            $objValid->_expected = array('status', 'notes');
            $objValid->_required = array('status');

            $vars = $objForm->getPostArray($objValid->_expected);


            if ($objValid->isValid()) {
                if (!empty($objOrder->updateOrder($id, $vars))) {
                    Helper::redirect('/admin' . Url::getCurrentUrl(array('action', 'id')) . '&action=edited');
                } else {
                    Helper::redirect('/admin' . Url::getCurrentUrl(array('action', 'id')) . '&action=edited-failed');
                }
            }
        }

        require_once('template/_header.php');
        ?>

        <h1>Orders :: View</h1>

        <form action="" method="post">
            <table cellspacing="0" cellpadding="0" border="0" class="tbl_insert">

                <tr>
                    <th>Date:</th>
                    <td colspan="4">
                        <?php echo Helper::setDate(2, $order['date']); ?>
                    </td>
                </tr>
                <tr>
                    <th>Order no.:</th>
                    <td colspan="4">
                        <?php echo $order['id']; ?>
                    </td>
                </tr>

                <?php if (!empty($items)) { ?>

                    <tr>
                        <th rowspan="<?php echo count($items); ?>">
                            Items
                        </th>
                        <td class="col_5">ID</td>
                        <td>Item</td>
                        <td class="col_5 ta_r">Qty</td>
                        <td class="col_5 ta_r">Amount</td>
                    </tr>
                    <?php foreach ($items as $item) {
                        $product = $objCatalogue->getProduct($item['product']);
                        ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo Helper::encodeHTML($product['name']); ?></td>
                            <td class="ta_r"><?php echo $item['qty']; ?></td>
                            <td class="ta_r">&pound;<?php echo number_format($item[$item] * $item['qty'], 2); ?></td>
                        </tr>
                    <?php } ?>

                <?php } ?>

                <tr>
                    <th>Sub-total:</th>
                    <td colspan="4" class="ta_r">
                        &pound;<?php echo number_format($order['subtotal'], 2); ?>
                    </td>
                </tr>

                <tr>
                    <th>VAT (<?php echo $order['vat_rate']; ?>%):</th>
                    <td colspan="4" class="ta_r">
                        &pound;<?php echo number_format($order['vat'], 2); ?>
                    </td>
                </tr>

                <tr>
                    <th>Total:</th>
                    <td colspan="4" class="ta_r">
                        <strong>&pound;<?php echo number_format($order['total'], 2); ?></strong>
                    </td>
                </tr>

                <tr>
                    <th>Client:</th>
                    <td colspan="4">
                        <?php
                        echo Helper::encodeHTML($user['first_name']) . ' ' . Helper::encodeHTML($user['last_name']) . '<br />';
                        echo Helper::encodeHTML($user['address_1']) . '<br />';
                        echo Helper::encodeHTML($user['address_2']) . '<br />';
                        echo Helper::encodeHTML($user['town']) . '<br />';
                        echo Helper::encodeHTML($user['county']) . '<br />';
                        echo Helper::encodeHTML($user['post_code']) . '<br />';
                        $country = $objCountry->getCountry($user['country']);
                        echo Helper::encodeHTML($country['name']) . '<br />';
                        echo '<a href="mailto:';
                        echo $user['email'] . '">';
                        echo $user['email'];
                        echo '</a>'
                        ?>
                    </td>
                </tr>

                <tr>
                    <th>PP status:</th>
                    <td colspan="4">
                        <?php
                        echo !empty($order['payment_status']) ? Helper::encodeHTML($order['payment_status']) : "Pending";
                        ?>
                    </td>
                </tr>

                <tr>
                    <th><label for="status">Order status:</label></th>
                    <td colspan="4">
                        <?php $objValid->validate('status'); ?>
                        <?php if (!empty($status)) { ?>
                            <select name="status" id="status" class="sel">
                                <?php foreach ($status as $stat) { ?>
                                    <option
                                        value="<?php echo $stat['id']; ?>" <?php echo $objForm->stickySelect('status', $stat['id'], $order['status']) ?>>
                                        <?php echo Helper::encodeHTML($stat['name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <th><label for="notes"></label></th>
                    <td colspan="4">
                        <textarea name="notes" id="notes" cols="" rows="" class="tar">
                            <?php echo $objForm->stickyText('notes', $order['notes']); ?>
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <th>&nbsp;</th>
                    <td colspan="4">
                        <div class="sbm sbm_blue fl_r">
                            <a href="<?php echo '/admin' . Url::getCurrentUrl(array('action')) . '&action=invoice'; ?>"
                               class="btn" target="_blank">Invoice</a>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>&nbsp;</th>
                    <td colspan="4">
                        <div class="sbm sbm_blue fl_l mr_r4">
                            <a href="<?php echo '/admin' . Url::getCurrentUrl(array('action', 'id')); ?>" class="btn">Go
                                Back</a>
                        </div>

                        <label for="btn_update" class="sbm sbm_blue fl_l">
                            <input type="submit" id="btn_update" class="btn" value="Update">
                        </label>
                    </td>
                </tr>


            </table>
        </form>
        <?php require_once('template/_footer.php');
    }
} ?>