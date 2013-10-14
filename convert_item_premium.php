<?php
$item_id = Params::getParam("item_id");

$premium_item_url = "index.php";
if($item_id) {
    $premium_item_url .= "?item_id=" . $item_id;
}
?>

<h1>CONVERT ITEM TO PREMIUM</h1>
<p><?php _e("parrafada para convertir el anuncio en premium", "premium_ads"); ?></p>

<form id="form-convert-pa" action="<?php echo osc_admin_render_plugin_url("premium_ads/index.php"); ?>" name="form-comver-pa" method="post">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="premium_ads/view/settings.php" />
    <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
    <input type="submit" class="btn btn-blue" value="<?php echo 'Convert item'; ?>" />
</form>