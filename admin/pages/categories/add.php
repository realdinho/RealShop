<?php

$objForm = new Form();
$objValid = new Validation($objForm);

$objCatalogue = new Catalogue();
$categories = $objCatalogue->getCategories();

if ($objForm->isPost('name')) {

    $name = $objForm->getPost('name');
    $fp = fopen(ROOT_PATH . DS . "log" . DS . "error.log", 'a');
    $text = 'name: ' . $name . '\n\n  ';
    fwrite($fp, $text);
    fclose($fp);

    $objValid->_expected = array('name');
    $objValid->_required = array('name');

    if ($objCatalogue->duplicateCategory($name)) {
        $objValid->add2Errors('name_duplicate');
    }

    if ($objValid->isValid()) {
        if ($objCatalogue->addCategory($objValid->_post)) {
            Helper::redirect('/admin' . Url::getCurrentUrl(array('action', 'id')) . '&action=added');
        } else {
            Helper::redirect('/admin' . Url::getCurrentUrl(array('action', 'id')) . '&action=added-failed');
        }

    }
}

require_once('template/_header.php');
?>

    <h1>Category :: Add</h1>

    <form action="" method="post">
        <table cellspacing="0" cellpadding="0" border="0" class="tbl_insert">

            <tr>
                <th><label for="name">Name: *</label></th>
                <td>
                    <?php echo $objValid->validate('name'); ?>
                    <?php echo $objValid->validate('name_duplicate'); ?>
                    <input type="text" name="name" id="name" value="<?php echo $objForm->stickyText('name'); ?>"
                           class="fld">
                </td>
            </tr>

            <tr>
                <th>&nbsp;</th>
                <td>
                    <label for="btn" class="sbm sbm_blue fl_l">
                        <input type="submit" id="btn" value="Add   ">
                    </label>
                </td>
            </tr>
        </table>
    </form>
<?php require_once('template/_footer.php'); ?>