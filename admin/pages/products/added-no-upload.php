<?php

$url = '/admin'.Url::getCurrentUrl(array('action', 'id'));

require_once ('template/_header.php');
?>

<h1>Product :: Added</h1>

<p>The New record has been successfully without the image.<br />
    <a href="<?php echo $url;?>">Go to the list of products</a>
</p>
<?php require_once ('template/_footer.php');?>
