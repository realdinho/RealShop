<?php

$url = '/admin'.Url::getCurrentUrl(array('action', 'id'));

require_once ('template/_header.php');
?>

<h1>Client :: Edited</h1>

<p>The client has been updated successfully.<br />
    <a href="<?php echo $url;?>">Go to the list of clients</a>
</p>
<?php require_once ('template/_footer.php');?>
