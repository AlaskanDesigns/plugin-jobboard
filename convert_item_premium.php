<?php
$item_id = Params::getParam("item_id");

$premium_item_url = "premium_ads/view/settings.php";
if($item_id) {
    $premium_item_url .= "?item_id=" . $item_id;
}
?>

<h1>CONVERT ITEM PREMIUM</h1>
<p><?php _e("parrafada para convertir el anuncio en premium", "premium_ads"); ?></p>

<a class="btn btn-blue" href="<?php echo osc_admin_render_plugin_url($premium_item_url); ?>"><?php echo 'Convert item'; ?></a>