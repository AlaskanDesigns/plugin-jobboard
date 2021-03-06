<?php
    // jobboard - .com only
    // get subdomain - linkedin related - osclass.com/apply/
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $parsedUrl = parse_url($url);
    $host = explode('.', $parsedUrl['host']);
    $a2 = array_pop($host);
    $a1 = array_pop($host);
    $subdomain = $a1.".".$a2;

    if($subdomain == 'osclass.com') {
?>
<script>
    $(document).ready(function() {
        window.INFrame = $('#apply_with_linkedin_frame');
    });
</script>
<style>
    #apply-with-linkedin-wrapper {
        display: inline;
        <?php if( osc_get_osclass_location() != 'contact' ) { ?>
        float: right;
        position: relative;
        left: -180px;
        <?php } ?>
        width: 245px;
        margin-top: 15px;
        padding-top: 8px;
    }
</style>
<?php if( osc_get_osclass_location() == 'contact' ) { ?>
<div id="apply-with-linkedin-wrapper" class="field-wrapper" style="text-align: center;">
<?php } else { ?>
<div id="apply-with-linkedin-wrapper" class="field-wrapper">
<?php } ?>
    <iframe id="apply_with_linkedin_frame" name="apply_with_linkedin_frame"
        <?php if( osc_get_osclass_location() != 'contact' ) { ?>
            style="display:none; width: 191px; height:45px; z-index:1;"
            height="45" width="191" scrolling="no"
        <?php } else { ?>
            style="display:none; width: 245px; height:45px; z-index:1; padding-left:60px;"
            height="45" width="191" scrolling="no"
        <?php } ?>
            ALLOWTRANSPARENCY="true"
            frameborder="0"
            src="http://www.osclass.com/apply/iframe.php?site=<?php echo urlencode(osc_esc_html(osc_base_url())); ?>&jobId=<?php echo osc_item_id();?>&title=<?php echo base64_encode(osc_esc_html(osc_item_title()));?>&cname=<?php echo base64_encode(osc_esc_html(osc_page_title())); ?>&theme=<?php echo osc_get_preference('headerBG','corporateboard');?>&sip=<?php echo base64_encode(get_ip());?>"></iframe>

    <style type="text/css">* html #li_ui_li_gen_res_loading_placeholder a#li_ui_li_gen_res_loading_placeholder-link{height:1% !important;}#li_ui_li_gen_res_loading_placeholder{position:relative !important;overflow:visible !important;display:block !important;}#li_ui_li_gen_res_loading_placeholder a#li_ui_li_gen_res_loading_placeholder-link{border:0 !important;height:undefinedpx !important;text-decoration:none !important;padding:0 !important;margin:0 !important;display:inline-block !important;}#li_ui_li_gen_res_loading_placeholder a#li_ui_li_gen_res_loading_placeholder-link:link, #li_ui_li_gen_res_loading_placeholder a#li_ui_li_gen_res_loading_placeholder-link:visited, #li_ui_li_gen_res_loading_placeholder a#li_ui_li_gen_res_loading_placeholder-link:hover, #li_ui_li_gen_res_loading_placeholder a#li_ui_li_gen_res_loading_placeholder-link:active{border:0 !important;text-decoration:none !important;}#li_ui_li_gen_res_loading_placeholder a#li_ui_li_gen_res_loading_placeholder-link:after{content:"." !important;display:block !important;clear:both !important;visibility:hidden !important;line-height:0 !important;height:0 !important;}#li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-logo{background:url(http://static02.linkedin.com/scds/common/u/img/sprite/sprite_connect_v13.png) 0px -346px no-repeat !important;cursor:pointer !important;border:0 !important;text-indent:-9999em !important;overflow:hidden !important;padding:0 !important;margin:0 !important;position:absolute !important;right:0px !important;top:0px !important;display:block !important;width:35px !important;height:33px !important;float:right !important;}#li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-logo{background-position:-35px -346px !important;}#li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-logo, #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-logo{background-position:-70px -346px !important;}.IN-shadowed #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-logo{}#li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title{color:#fff !important;cursor:pointer !important;display:block !important;white-space:nowrap !important;float:left !important;margin-left:1px !important;vertical-align:top !important;overflow:hidden !important;text-align:center !important;height:31px !important;padding:0 39px 0 10px !important;border:1px solid #000 !important;border-top-color:#2771aa !important;border-right-color:#2771aa !important;border-bottom-color:#2771aa !important;border-left-color:#2771aa !important;text-shadow:none !important;line-height:33px !important;border-radius:3px !important;-webkit-border-radius:3px !important;border-top-right-radius:3px !important;border-bottom-right-radius:3px !important;-webkit-border-top-right-radius:3px !important;-webkit-border-bottom-right-radius:3px !important;background-color:#007cbb !important;background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#65add2), color-stop(30%,#0f90d2), color-stop(67%,#006daa), color-stop(100%,#07547d)) !important; background-image: -webkit-linear-gradient(top, #65add2 0%, #0f90d2 30%, #006daa 67%, #07547d 100%) !important;}#li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-title{border:1px solid #000 !important;border-top-color:#2771aa !important;border-right-color:#2771aa !important;border-bottom-color:#2771aa !important;border-left-color:#2771aa !important;background-color:#0083c6 !important;background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#5caad2), color-stop(30%,#0084ce), color-stop(67%,#006daa), color-stop(100%,#07527b)) !important; background-image: -webkit-linear-gradient(top, #5caad2 0%, #0084ce 30%, #006daa 67%, #07527b 100%) !important;-webkit-box-shadow:0px 2px 2px #b7b7b7 !important;box-shadow:0px 2px 2px #b7b7b7 !important;}#li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title, #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title{color:#fff !important;border:1px solid #000 !important;border-top-color:#2771aa !important;border-right-color:#2771aa !important;border-bottom-color:#2771aa !important;border-left-color:#2771aa !important;background-color:#007cbb !important;background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#07527b), color-stop(30%,#006daa), color-stop(67%,#0084ce), color-stop(100%,#5caad2)) !important; background-image: -webkit-linear-gradient(top, #07527b 0%, #006daa 30%, #0084ce 67%, #5caad2 100%) !important;}.IN-shadowed #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title{}.IN-shadowed #li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-title{}.IN-shadowed #li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title, .IN-shadowed #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title{}#li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title-text{color:#fff !important;font-size:15px !important;font-family:'Helvetica Neue', Arial, Helvetica, sans-serif !important;font-weight:normal !important;font-style:normal !important;display:inline-block !important;vertical-align:top !important;height:31px !important;line-height:31px !important;}#li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title-text *{color:#fff !important;font-size:15px !important;font-family:'Helvetica Neue', Arial, Helvetica, sans-serif !important;font-weight:normal !important;font-style:normal !important;display:inline !important;}#li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title-text strong{font-weight:bold !important;}#li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title-text em{font-style:italic !important;}#li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-title-text, #li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-title-text *{color:#fff !important;}#li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title-text, #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title-text, #li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title-text *, #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title-text *{color:#fff !important;}#li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title #li_ui_li_gen_res_loading_placeholder-mark{display:inline-block !important;width:0px !important;overflow:hidden !important;}.success #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title #li_ui_li_gen_res_loading_placeholder-mark{width:17px !important;height:13px !important;background:url(http://static02.linkedin.com/scds/common/u/img/sprite/sprite_connect_v13.png) -250px -160px no-repeat !important;margin:9px 5px 0px 0px !important;display:inline-block !important;}.IN-shadowed .success #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title #li_ui_li_gen_res_loading_placeholder-mark{}.success #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title{color:#000 !important;border-top-color:#cdcdcd !important;border-right-color:#cdcdcd !important;border-bottom-color:#acacac !important;border-left-color:#cdcdcd !important;background-color:#ECECEC !important;background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(33%,#f9f9f9), color-stop(67%,#e3e3e3), color-stop(100%,#cbcbcb)) !important; background-image: -webkit-linear-gradient(top, #ffffff 0%, #f9f9f9 33%, #e3e3e3 67%, #cbcbcb 100%) !important;}.success #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title-text, .success #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title-text *{color:#000 !important;}.IN-shadowed .success #li_ui_li_gen_res_loading_placeholder #li_ui_li_gen_res_loading_placeholder-title{}.success #li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-title{color:#000 !important;border-top-color:#cdcdcd !important;border-right-color:#cdcdcd !important;border-bottom-color:#acacac !important;border-left-color:#cdcdcd !important;background-color:#EDEDED !important;background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#fdfdfd), color-stop(33%,#f2f2f2), color-stop(67%,#e3e3e3), color-stop(100%,#cbcbcb)) !important; background-image: -webkit-linear-gradient(top, #fdfdfd 0%, #f2f2f2 33%, #e3e3e3 67%, #cbcbcb 100%) !important;}.success #li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-title-text, .success #li_ui_li_gen_res_loading_placeholder.hovered #li_ui_li_gen_res_loading_placeholder-title-text *{color:#000 !important;}.success #li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title, .success #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title{color:#000 !important;border-top-color:#cdcdcd !important;border-right-color:#cdcdcd !important;border-bottom-color:#cdcdcd !important;border-left-color:#cdcdcd !important;background-color:#DEDEDE !important;background-image:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#cbcbcb), color-stop(33%,#e3e3e3), color-stop(67%,#f2f2f2), color-stop(100%,#fdfdfd)) !important; background-image: -webkit-linear-gradient(top, #cbcbcb 0%, #e3e3e3 33%, #f2f2f2 67%, #fdfdfd 100%) !important;}.success #li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title-text, .success #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title-text, .success #li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title-text *, .success #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title-text *{color:#000 !important;}.IN-shadowed .success #li_ui_li_gen_res_loading_placeholder.clicked #li_ui_li_gen_res_loading_placeholder-title, .IN-shadowed .success #li_ui_li_gen_res_loading_placeholder.down #li_ui_li_gen_res_loading_placeholder-title{}.IN-shadowed { -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)" !important;filter: alpha(opacity=20) !important;-moz-opacity: 0.2 !important;opacity: 0.2 !important;}#li_ui_shadowbox_li_gen_1314377205454_2 { position: fixed !important;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)" !important;filter: alpha(opacity=0) !important;-moz-opacity: 0 !important;opacity: 0 !important;background-color: #000000 !important;z-index: 9990 !important;top: 0 !important;left: 0 !important;}</style>
    <?php if( osc_get_osclass_location() == 'contact' ) { ?>
    <span id="res_apply_linked_in_place_holder" style="padding-left:60px; opacity:0.6; filter:alpha(opacity=6); width: 191px; height:35px; position: relative;  line-height: 35px; vertical-align: baseline; display: inline-block; " class="IN-widget-loading">
    <?php } else { ?>
    <span id="res_apply_linked_in_place_holder" style="opacity:0.6; filter:alpha(opacity=6); width: 191px; height:35px; position: relative;  line-height: 35px; vertical-align: baseline; display: inline-block; " class="IN-widget-loading">
    <?php } ?>
        <span style="padding-top: 0px !important; padding-right: 0px !important; padding-bottom: 0px !important; padding-left: 0px !important; margin-top: 0px !important; margin-right: 0px !important; margin-bottom: 0px !important; margin-left: 0px !important; text-indent: 0px !important; display: inline-block !important; vertical-align: baseline !important; font-size: 1px !important; ">
            <span id="li_ui_li_gen_res_loading_placeholder" style="">
                <a id="li_ui_li_gen_res_loading_placeholder-link" href="javascript:void(0);">
                    <span id="li_ui_li_gen_res_loading_placeholder-logo">in</span>
                    <span id="li_ui_li_gen_res_loading_placeholder-title" style="width: 137px; ">
                        <span id="li_ui_li_gen_res_loading_placeholder-mark"></span>
                        <span id="li_ui_li_gen_res_loading_placeholder-title-text">Connecting <strong>LinkedIn</strong></span>
                    </span>
                </a>
            </span>
        </span>
    </span>
</div>

<?php } else {
// TODO  https://developer.linkedin.com/plugins/apply

//<script src="//platform.linkedin.com/in.js" type="text/javascript">
//  api_key:
//</script>
//<script type="IN/Apply" data-companyid="" data-jobtitle="" data-email=""></script>
}

?>