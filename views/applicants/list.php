<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<h2 class="render-title"><?php _e('Resumes', 'jobboard'); ?>
    <a id="show-filters" class="btn btn-mini"><?php _e('Show filters', 'jobboard'); ?></a>
    <a id="add-applicant" class="btn btn-blue float-right"><?php _e('Add applicant', 'jobboard'); ?></a>
</h2>
<div class="relative resumes">
    <div class="search-filter hide">
        <form method="get" action="<?php echo osc_admin_base_url(true); ?>" id="shortcut-filters" class="">
            <input type="hidden" name="page" value="plugins">
            <input type="hidden" name="action" value="renderplugin">
            <input type="hidden" name="file" value="jobboard/people.php">
            <div class="form-horizontal search-form" style="padding-top: 15px;">
                <div class="grid-system">
                    <div class="grid-row grid-50">
                        <div class="row-wrapper">
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('E-mail', 'jobboard') ; ?>
                                </div>
                                <div class="form-controls">
                                    <input type="text" id="sEmail" name="sEmail" value="<?php echo osc_esc_html(Params::getParam('sEmail')); ?>" class="input-text" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('Name', 'jobboard'); ?>
                                </div>
                                <div class="form-controls">
                                    <input type="text" id="sName" name="sName" value="<?php echo osc_esc_html(Params::getParam('sName')); ?>" class="input-text" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('Age', 'jobboard'); ?>
                                </div>
                                <div class="form-controls">
                                    <input placeholder="0" class="input-medium" type="text" name="minAge" value="<?php echo osc_esc_html(Params::getParam('minAge')); ?>" id="minAge"/> - <input placeholder="99" class="input-medium" type="text" name="maxAge" value="<?php echo osc_esc_html(Params::getParam('maxAge')); ?>" id="maxAge"/></label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('Sex', 'jobboard'); ?>
                                </div>
                                <div class="form-controls">
                                    <select name="sSex" class="">  <!--        sex selector            -->
                                        <option value="" <?php if( Params::getParam('sSex') == '' ) echo "selected" ?>><?php _e('Any sex', 'jobboard'); ?></option>
                                    <?php $aSex = _jobboard_get_sex_array();
                                    foreach($aSex as $key => $value) {?>
                                        <option value="<?php echo $key; ?>" <?php if( Params::getParam('sSex') == $key ) echo "selected" ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('Rating', 'jobboard'); ?>
                                </div>
                                <div class="form-controls">
                                    <div id="rating-filter" class="rater big-star">
                                        <?php for($k=1; $k<=5; $k++) {
                                            echo '<input name="rating" type="radio" class="filter-star" value="'.$k.'" title="'.$k.'" '.($k==Params::getParam('rating')?'checked="checked"':'').'/>';
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-row grid-50">
                        <div class="row-wrapper">
                            <div class="form-row">
                                <div class="form-label"></div>
                                <div class="form-controls">
                                    <label><input type="checkbox" id="viewUnread" name="viewUnread" value="1" <?php if(Params::getParam('viewUnread')=='1') { echo 'checked="checked"'; }; ?> /><?php _e("View unread", "jobboard"); ?></label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label"></div>
                                <div class="form-controls">
                                    <label><input type="checkbox" id="uncorrected_forms" name="uncorrected_forms" value="1" <?php if(Params::getParam('uncorrected_forms')=='1') { echo 'checked="checked"'; }; ?> /><?php _e("With not reviewed questions", "jobboard"); ?></label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('Jobs', 'jobboard'); ?>
                                </div>
                                <div class="form-controls">
                                    <select name="jobId" class="">  <!-- job selector            -->
                                        <option value=""><?php _e('All jobs', 'jobboard'); ?></option>
                                        <option value="-1" <?php if( Params::getParam('jobId') == '-1' ) echo "selected"; ?>>- <?php _e("Only spontaneous", "jobboard"); ?> -</option>

                                        <?php while( osc_has_items() ) { ?>
                                        <option value="<?php echo osc_item_id(); ?>" <?php if( Params::getParam('jobId') == osc_item_id() ) echo "selected"; ?>><?php echo osc_item_title(); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('Status', 'jobboard'); ?>
                                </div>
                                <div class="form-controls">
                                    <?php $statusId = Params::getParam('statusId'); ?>
                                    <select name="statusId" class="">  <!-- status selector         -->
                                        <option value="-1" <?php if( $statusId != '' && $statusId == (int)$key ) echo "selected"; ?>><?php _e('All status', 'jobboard'); ?></option>
                                        <?php $aStatus = jobboard_status();
                                        foreach( $aStatus as $key => $value ) { ?>
                                        <option value="<?php echo $key; ?>" <?php if( $statusId != '' && $statusId == (int)$key ) echo "selected"; ?>><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-label">
                                    <?php _e('Category', 'jobboard'); ?>
                                </div>
                                <div class="form-controls">
                                    <?php ManageItemsForm::category_select(null, null, null, true) ; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid-row">
                        <div class="row-wrapper">
                            <div class="form-row">

                            </div>
                            <div class="form-row">
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-row filters-submit">
                    <input type="submit" class="btn" value="<?php echo osc_esc_html( __('Search', 'jobboard') ) ; ?>">
                </div>
            </div>
        </form>
    </div>
    <div class="applicant-shortcuts">
        <?php
            $i = 0;
            foreach($navbar as $k => $v) {
                $class = array();
                if($v['active']) $class[] = 'btn-blue';
                if($i == 0) $class[] = 'first';
                if(($i == (count($navbar) - 1)) && $i !== 0) $class[] = 'last';
        ?>
        <a class="btn <?php echo implode(' ', $class); ?>" href="<?php echo $v['url'] ?>"><?php echo $v['text']; ?></a>
        <?php $i++; } ?>
        <form method="get" action="<?php echo osc_admin_base_url(true); ?>" class="inline">
            <?php foreach( Params::getParamsAsArray('get') as $key => $value ) { ?>
            <?php if( $key != 'iDisplayLength' ) { ?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo osc_esc_html($value); ?>" />
            <?php } } ?>
            <select name="iDisplayLength" class="select-box-extra float-right" onchange="this.form.submit();" >
                <option value="10"><?php printf(__('Show %d Applicants', 'jobboard'), 10); ?></option>
                <option value="25" <?php if( $search['limit']['length'] == 25 ) echo 'selected'; ?> ><?php printf(__('Show %d Applicants', 'jobboard'), 25); ?></option>
                <option value="50" <?php if( $search['limit']['length'] == 50 ) echo 'selected'; ?> ><?php printf(__('Show %d Applicants', 'jobboard'), 50); ?></option>
                <option value="100" <?php if( $search['limit']['length'] == 100 ) echo 'selected'; ?> ><?php printf(__('Show %d Applicants', 'jobboard'), 100); ?></option>
            </select>
        </form>
        <div class="clear"></div>
    </div>
    <form id="datatablesForm" action="<?php echo osc_admin_base_url(true); ?>" method="get">
        <input type="hidden" name="page" value="plugins">
        <input type="hidden" name="action" value="renderplugin">
        <input type="hidden" name="file" value="jobboard/people.php">
        <div class="table-contains-actions">
            <table class="table" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th <?php if($search['order']['col']=='a.s_name') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.s_name&sOrderDir=".($search['order']['col']=='a.s_name'?($search['order']['dir']=='ASC'?'DESC':'ASC'):'ASC');?>" >
                                <?php _e('Applicant', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='a.dt_birthday') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.dt_birthday&sOrderDir=".($search['order']['col']=='a.dt_birthday'?($search['order']['dir']=='ASC'?'DESC':'ASC'):'ASC');?>" >
                                <?php _e('Age', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='a.s_sex') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.s_sex&sOrderDir=".($search['order']['col']=='a.s_sex'?($search['order']['dir']=='ASC'?'DESC':'ASC'):'ASC');?>" >
                                <?php _e('Sex', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='a.s_email') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.s_email&sOrderDir=".($search['order']['col']=='a.s_email'?($search['order']['dir']=='ASC'?'DESC':'ASC'):'ASC');?>" >
                                <?php _e('Email', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='d.s_title') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=d.s_title&sOrderDir=".($search['order']['col']=='d.s_title'?($search['order']['dir']=='ASC'?'DESC':'ASC'):'ASC');?>" >
                                <?php _e('Job title', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='a.i_status') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.i_status&sOrderDir=".($search['order']['col']=='a.i_status'?($search['order']['dir']=='DESC'?'ASC':'DESC'):'DESC');?>" >
                                <?php _e('Status', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='a.d_score') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.d_score&sOrderDir=".($search['order']['col']=='a.d_score'?($search['order']['dir']=='DESC'?'ASC':'DESC'):'DESC');?>" >
                                <?php _e('Score questions', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='a.i_rating') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.i_rating&sOrderDir=".($search['order']['col']=='a.i_rating'?($search['order']['dir']=='DESC'?'ASC':'DESC'):'DESC');?>" >
                                <?php _e('Rating', 'jobboard') ; ?>
                            </a>
                        </th>
                        <th <?php if($search['order']['col']=='a.dt_date') { echo 'class="sorting_'.strtolower($search['order']['dir']).'"';}; ?>>
                            <a href="<?php echo $urlOrder."&sOrderCol=a.dt_date&sOrderDir=".($search['order']['col']=='a.dt_date'?($search['order']['dir']=='DESC'?'ASC':'DESC'):'DESC');?>" >
                                <?php _e('Received', 'jobboard') ; ?>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($people) > 0) { ?>
                <?php foreach($people as $p) { ?>
                    <?php
                        $note_tooltip = '';
                        for($i = 0; $i < count($p['notes']); $i++) {
                            $note_tooltip .= sprintf('<strong>%1$s</strong> - %2$s', date('d/m/Y H:i', strtotime($p['notes'][$i]['dt_date'])), $p['notes'][$i]['s_text']);
                            if( $i < (count($p['notes']) - 1) ) {
                                $note_tooltip .= '<br/>';
                            }
                        }
                        // has killer questions
                        $has_killerForm = $correctedForm  = false;
                        $score = '-';
                        $correctedForm = false;
                        if( @$p['listing']['fk_i_killer_form_id'] != '' && is_numeric(@$p['listing']['fk_i_killer_form_id']) ) {
                            $has_killerForm = true;
                            $score          = $p['d_score'];
                            $score          = (float)number_format($score, 1);
                            $correctedForm  = $p['b_corrected'];
                        }
                    ?>
                    <tr <?php if($p['b_read']==0){ echo 'style="background-color:#FFF0DF;"';}?>>
                        <td class="applicant"><a href="<?php echo osc_admin_render_plugin_url("jobboard/people_detail.php");?>&people=<?php echo $p['pk_i_id']; ?>" title="<?php echo @$p['s_name']; ?>" ><?php echo @$p['s_name']; ?></a>
                        <?php if($p['b_has_notes'] == 1 ) { ?><span class="note" data-tooltip="<?php echo $note_tooltip; ?>"></span><?php } ?>
                        <?php if($p['s_source'] == 'linkedinapply' ) { ?><span class="linkedin"></span><?php } ?>
                            <div class="actions">
                                <ul>
                                    <li><a href="javascript:delete_applicant(<?php echo $p['pk_i_id']; ?>);" ><?php _e("Delete", "jobboard"); ?></a></li>
                                </ul>
                            </div>
                        </td>
                        <td><?php $age = _jobboard_get_age(@$p['dt_birthday']); echo $age;?> <?php if(@$age!='-'){echo __('years', 'jobboard').' ('.date('m/d/Y',strtotime(@$p['dt_birthday'])).')'; } ?></td>
                        <td><?php echo jobboard_sex_to_string( @$p['s_sex'] ); ?></td>
                        <td><?php echo @$p['s_email']; ?></td>
                        <td><?php echo $p['fk_i_item_id']==''?__('Spontaneous application', 'jobboard'):@$p['s_title']; ?></td>
                        <td><?php echo $status[isset($p['i_status'])?$p['i_status']:0]; ?></td>
                        <?php if($has_killerForm) { ?>
                        <td><?php if($correctedForm){ echo '<b>'.$score.'/10</b>'; } else { _e('Needs correction', 'jobboard'); } ?> </td>
                        <?php } else { ?>
                        <td></td>
                        <?php } ?>
                        <td>
                            <div class="rater big-star">
                                <?php for($k=1;$k<=5;$k++) {
                                    echo '<input name="star'.$p['pk_i_id'].'" type="radio" class="list-star" value="'.$p['pk_i_id'].'_'.$k.'" title="'.$k.'" '.($k==$p['i_rating']?'checked="checked"':'').'/>';
                                } ?>
                            </div>
                        </td>
                        <td><?php echo _jobboard_time_elapsed_string(strtotime($p['dt_date']), true); ?></td>
                    </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                    <td colspan="9" class="text-center">
                        <p><?php _e('No data available in table', 'jobboard') ; ?></p>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <div id="table-row-actions"></div>
        </div>
    </form>
</div>
<div class="has-pagination">
    <ul class="showing-results">
        <li><span><?php echo osc_pagination_showing($search['pagination']['from'], $search['pagination']['to'], $search['pagination']['displayed'], $search['pagination']['total']); ?></span></li>
    </ul>
    <?php
        $aData = array(
            'iTotalDisplayRecords' => $search['pagination']['displayed'],
            'iTotalRecords'        => $search['pagination']['total'],
            'iDisplayLength'       => $search['pagination']['length'],
            'iPage'                => $search['pagination']['page']
        );
        osc_show_pagination_admin($aData);
    ?>
</div>
<form id="dialog-people-delete" method="post" action="<?php echo osc_admin_base_url(true); ?>" class="has-form-actions hide" title="<?php echo osc_esc_html(__('Delete applicant', 'jobboard')); ?>">
    <input type="hidden" name="page" value="plugins" />
    <input type="hidden" name="action" value="renderplugin" />
    <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>actions.php" />
    <input type="hidden" name="paction" value="delete_applicant" />
    <input type="hidden" id="delete_id" name="id" value="" />
    <div class="form-horizontal">
        <div class="form-row">
            <?php _e('Are you sure you want to delete this applicant?', 'jobboard'); ?>
        </div>
        <div class="form-actions">
            <div class="wrapper">
            <a class="btn" href="javascript:void(0);" onclick="$('#dialog-people-delete').dialog('close', 'jobboard');"><?php _e('Cancel', 'jobboard'); ?></a>
            <input id="people-delete-submit" type="submit" value="<?php echo osc_esc_html( __('Delete', 'jobboard') ); ?>" class="btn btn-red" />
            </div>
        </div>
    </div>
</form>
<div id="new_applicant_dialog" title="<?php _e('Add applicant', 'jobboard') ?>">
    <form enctype="multipart/form-data" method="post" action="" id="add_new_applicant_form" name="add_new_applicant_form">
        <input type="hidden" id="add_new_applicant" name="add_new_applicant" value="true">
        <div class="row">
            <label for="applicant-name"><?php _e('Name', 'jobboard'); ?></label>
            <input type="text" id="applicant-name"     name="applicant-name"     placeholder="<?php echo osc_esc_html(__('Name', 'jobboard')); ?>">
        </div>
        <div class="row">
            <label for="applicant-email"><?php _e('Email', 'jobboard'); ?></label>
            <input type="text" id="applicant-email"    name="applicant-email"    placeholder="<?php echo osc_esc_html(__('Email', 'jobboard')); ?>">
        </div>
        <div class="row">
            <label for="applicant-phone"><?php _e('Phone', 'jobboard'); ?></label>
            <input type="text" id="applicant-phone"    name="applicant-phone"    placeholder="<?php echo osc_esc_html(__('Phone', 'jobboard')); ?>">
        </div>
        <div class="row">
            <label for="applicant-birthday"><?php _e('Birthday', 'jobboard'); ?> (MM/DD/YYYYY)</label>
            <input type="text" id="applicant-birthday" name="applicant-birthday" placeholder="MM/DD/YYYY">
        </div>
        <div class="applicant-selector">
            <select id="applicant-sex" name="applicant-sex">
                <option value="" selected="selected"><?php echo __("Choose sex", 'jobboard'); ?></option>
                <?php foreach(_jobboard_get_sex_array() as $key => $value) {?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
            <div class="clear"></div>
        </div>
        <div class="applicant-selector">
            <select id="applicant-job" name="applicant-job">
                <option value="-1"><?php _e('Assign to a job?', 'jobboard'); ?></option>
                <option value="-1" <?php if( Params::getParam('jobId') == '-1' ) echo "selected"; ?>>- <?php _e("Only spontaneous", "jobboard"); ?> -</option>
                <?php osc_reset_items();
                while( osc_has_items() ) { ?>
                <option value="<?php echo osc_item_id(); ?>"><?php echo osc_item_title(); ?></option>
                <?php } ?>
            </select>
            <div class="clear"></div>
        </div>
        <div class="applicant-selector">
            <select id="applicant-status" name="applicant-status">
                <option value="" selected="selected"><?php _e("Select a status", "jobboard"); ?></option>
                <?php $st_array = jobboard_status();
                foreach($st_array as $k => $v) {
                    echo '<option value="'.$k.'">'.$v.'</option>';
                } ?>
            </select>
            <div class="clear"></div>
        </div>
        <div id="file">
            <label><?php _e("Attach CV"); ?></label>
            <div class="error-message"><?php _e('Please attach the applicant\'s CV', 'jobboard'); ?></div>
            <input type="file" name="applicant-attachment" id="applicant-attachment">
        </div>
        <?php /*
        <div id="rating">
            <label><?php _e("Select a rating"); ?></label>
            <div id="rating-filter" class="rater big-star">
            <?php for($k=1; $k<=5; $k++) {
                echo '<input name="applicant-rating" type="radio" class="filter-star" value="'.$k.'" title="'.$k.'" '.($k==Params::getParam('rating')?'checked="checked"':'').'/>';
            } ?>
            </div>
        </div>
        */ ?>
        <div id="applicant-buttons">
            <button type="submit" class="btn btn-blue float-right"><?php _e('Add', 'jobboard') ; ?></button>
            <button type="button" class="btn float-right" id="cancel-dialog" name="cancel-dialog"><?php _e('Cancel', 'jobboard') ; ?></button>
            <div class="clear"></div>
        </div>
    </form>
</div>
<?php if( ((int) osc_get_preference('new_feature_add_applicant', 'jobboard_plugin')) === 0 ) { ?>
<script type="text/javascript">
    $(document).ready(function(){
        hopscotch.startTour(applicant.tour);
    });
</script>
<style type="text/css">
    div.hopscotch-bubble .hopscotch-bubble-number{ font-size: 11px; text-transform: uppercase; }
</style>
<?php } ?>