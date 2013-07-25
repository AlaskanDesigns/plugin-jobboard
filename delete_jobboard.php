<?php
    if(!osc_is_admin_user_logged_in()) {
        die;
    }


    function send_mail_feedback($feedback) {
        $params            = array();
        $params['to']      = ENV == 'staging' ? 'jobboard.notifications+staging@osclass.com' : 'jobboard.notifications@osclass.com';
        $params['subject'] = 'Jobboard deleted';
        $params['body']    = "<p><h3 style='text-decoration: underline;font-weight:bold;'>Feedback</h3></p><p>$feedback</p>";
        osc_sendMail($params);
    }


    $action = Params::getParam('action_jobboard');

    if($action && $action === 'delete_jobboard')
    {
        $feedback = (Params::getParam("feedback_jobboard") != '') ? Params::getParam("feedback_jobboard") : false;
        if($feedback) {
           send_mail_feedback($feedback);
        }

        $aDomain = explode("//", osc_base_url());
        $aDomain = explode(".", $aDomain[1]);
        $domain  = $aDomain[0];


        $env = ENV == 'staging' ? 'staging' : '';
        var_dump("sh current/scripts/create/oc.sh $env del  " . $domain . " " . osc_base_url());
        //exec("sh current/scripts/create/oc.sh $env del $domain " . osc_base_url(), $output, $ret);
    }

    if($action && $action === 'download_cvs')
    {
        // Load zip library
        $zip = new ZipArchive();
        $zip_name = osc_sanitizeString(osc_page_title()) . "_" .__("applicants", "jobboard") . ".zip";
        // Opening zip file to load files

        if ($zip->open($zip_name, ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$zip_name>\n");
        }

        $aApplicants = ModelJB::newInstance()->getAllApplicants();
        $path = osc_get_preference('upload_path', 'jobboard_plugin');

        foreach($aApplicants as $aApplicant) {
            $aPdf = ModelJB::newInstance()->getCVFromApplicant($aApplicant["pk_i_id"]);
            $aPdf = current($aPdf);

            // Adding files into zip
            $zip->addFile($path.$aPdf["s_name"], osc_sanitizeString($aApplicant["s_name"]) . ".pdf");
        }

        $zip->close();

        if(file_exists($zip_name)){
            // push to download the zip
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="'.$zip_name.'"');
            header("Content-Length: " . filesize($zip_name));
            @ob_clean();
            flush();
            readfile($zip_name);
            unlink($zip_name);
        }
    }
?>
<div class="jobboard-delete_jobboard">

    <input type="hidden" id="dashboard-page" value="<?php echo osc_admin_render_plugin_url("jobboard/dashboard.php"); ?>">
    <div class="text-jobboard">
        <h2><?php _e("Quedate por estos motivos", "jobboard"); ?></h2>
        <ul>
            <li><?php _e("motivo 1", "jobboard"); ?></li>
            <li><?php _e("motivo 2", "jobboard"); ?></li>
            <li><?php _e("motivo 3", "jobboard"); ?></li>
            <li><?php _e("motivo 4", "jobboard"); ?></li>
            <li><?php _e("motivo 5", "jobboard"); ?></li>
        </ul>
    </div>
    <div id="delete-jobboard-step-1" >
        <div class="box">
            <div class="widget-box-title">
                <h2 class="has-tabs"><?php _e("¿Seguro que quieres eliminar tu jobboard?" , "jobboard"); ?></h2>
            </div>
            <div class="widget-box-content">
                    <button type="button" class="btn btn-red" id="delete-button-step-1" name="delete-button-step-1"><?php _e("Continuar", "jobboard"); ?></button>
                    <button type="button" class="btn btnClose  cancel-delete-jobboard"><?php _e("Cancelar", "jobboard"); ?></button>
            </div>
        </div>
    </div>
    <div id="delete-jobboard-step-2">
        <div class="box">
            <div class="widget-box-title">
                <h2 class="has-tabs"><?php _e("¿Quieres descargar todos los CVs antes de eliminar tu jobboard?" , "jobboard"); ?></h2>
            </div>
            <div class="widget-box-content">
                <form action="#" method="post">
                    <input type="hidden" id="action_jobboard" name="action_jobboard" value="download_cvs">
                    <button type="submit" class="btn btn-blue" id="download-cvs" name="download-cvs" ><?php _e("Descargar CVS", "jobboard"); ?></button>
                    <button type="button" class="btn btn-red" id="delete-button-step-2" name="delete-button-step-2" ><?php _e("Continuar", "jobboard"); ?></button>
                    <button type="button" class="btn btnClose  cancel-delete-jobboard"><?php _e("Cancelar", "jobboard"); ?></button>
                </form>
            </div>
        </div>
    </div>
    <div id="delete-jobboard-step-3">
        <div class="box">
            <div class="widget-box-title">
                <h2 class="has-tabs"><?php _e("¿Algo que decir?" , "jobboard"); ?></h2>
            </div>
            <div class="widget-box-content">
                <!-- *** este tiene que ser submit / COMPROBAR DE PONER EL ID & NAME SEGUN LANGUAGE *** -->
                <form action="#" method="post">
                    <input type="hidden" id="action_jobboard" name="action_jobboard" value="delete_jobboard">
                    <textarea id="feedback_jobboard" name="feedback_jobboard" rows="10" style="display:block;"></textarea>
                    <button type="submit" class="btn btn-red" id="delete-button-step-3" name="delete-button-step-3" ><?php _e("Eliminar Jobboard!", "jobboard"); ?></button>
                    <button type="button" class="btn btnClose cancel-delete-jobboard"><?php _e("Cancelar", "jobboard"); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.box {
margin: 0 auto;
width: 50%;
text-align: center;
}
.jobboard-delete_jobboard {
   /* width: 100%*/
}
textarea {
    display: block;
    width: 70%;
    margin: 0 auto;
    margin-bottom: 20px;
}
</style>

