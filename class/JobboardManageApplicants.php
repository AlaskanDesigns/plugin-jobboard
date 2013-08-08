<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
 * Modify Manage Applicants at oc-admin
 */
class JobboardManageApplicants
{
    /*
     * Add filtrers for applicant status
     */
    static function applicants_shortcuts($aStatuses = array()) {

        if(empty($aStatuses)) {
            return null;
        }

        $shortcuts = array();
        $shortcuts['unread'] = array();
        $totalApplicantsShortcut = ModelJB::newInstance()->countApplicantsUnread();
        $shortcuts['unread']['total'] = $totalApplicantsShortcut;
        $shortcuts['unread']['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&viewUnread=1';
        $shortcuts['unread']['active'] = false;
        if( Params::getParam('viewUnread') ) {  $shortcuts['unread']['active'] = true; }
        $shortcuts['unread']['text'] = sprintf(__('Unread (%1$s)', 'jobboard'), $totalApplicantsShortcut);

        /* FOR EACH STATUS */
        foreach($aStatuses as $aStatus) {
            $statusName = strtolower($aStatus["name"]);
            $shortcuts[$statusName] = array();
            $shortcuts[$statusName]['statusId'] = $aStatus["id"];
            $totalApplicantsShortcut = ModelJB::newInstance()->countApplicantsByStatus($aStatus["id"]);
            $shortcuts[$statusName]['total'] = $totalApplicantsShortcut;
            $shortcuts[$statusName]['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&statusId=' . $aStatus["id"];
            $shortcuts[$statusName]['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&statusId=' . $aStatus["id"];
            $shortcuts[$statusName]['active'] = false;
            if( Params::getParam('statusId') == '0' && !Params::getParam('viewUnread') ) {
                $shortcuts[$statusName]['active'] = true;
            }
            $shortcuts[$statusName]['text'] = sprintf(__('%1$s (%2$s)', 'jobboard'),$aStatus["name"],  $totalApplicantsShortcut);
        }

        return $shortcuts;
    }
    
    static function get_num_applicants_by_status($statusId){
        $num_applicants = ModelJB::newInstance()->countApplicantsByStatus($statusId);

        return $num_applicants;
    }

}
