<?php if ( !defined('ABS_PATH') ) exit('ABS_PATH is not loaded. Direct access is not allowed.');

    class Stream
    {
        protected $log;

        public function __construct()
        {
            $this->log = ModelLogJB::newInstance();
            $this->init();
        }

        public function init()
        {
            osc_add_hook('login_admin',     array(&$this, 'log_login'));
            osc_add_hook('posted_item',     array(&$this, 'log_new_job'));
            osc_add_hook('item_edit_post',  array(&$this, 'log_edit_job'));
            osc_add_hook('before_delete_item', array(&$this, 'log_delete_job'));
            osc_add_hook('after_delete_item', array(&$this, 'log_confirm_delete_job'));
            osc_add_hook('edit_page'        , array(&$this, 'log_page_edited'));
        }

        public function uninstall()
        {
            // remove registers inserted at t_log
            $this->log->uninstall();
        }

        public function log_change_logo()
        {
            $data = sprintf(__('The %1$s has just modified a logo.', 'jobboard'), osc_logged_admin_name());
            $this->log->logJobboard('changeLogo', '', $data);
        }

        public function log_update_appearance()
        {
            $data = sprintf(__('The %1$s has modified a design of the job board.', 'jobboard'), osc_logged_admin_name());
            $this->log->logJobboard('updateappearance', '', $data);
        }

        public function log_page_edited($page_id)
        {
            $page = Page::newInstance()->findByPrimaryKey($page_id);
            if(!empty ($page)) {
                $s_name = $page['s_internal_name'];
                switch ($s_name) {
                    case 'legal':
                        $this->log->logJobboard('editpage', '', __('The legal page has been edited.', 'jobboard'));
                    break;
                    case 'corporate':
                        $this->log->logJobboard('editpage', '', __('The corporate page has been edited.', 'jobboard'));
                    break;
                    default:
                    break;
                }
            }
        }

        function log_login()
        {
            $data = sprintf(__('%1$s signed in.', 'jobboard'), osc_logged_admin_name());
            $this->log->logJobboard('login', '', $data);
        }

        function log_new_job($item)
        {
            $catID  = $item['fk_i_category_id'];
            $jobID  = $item['pk_i_id'];
            $job    = Item::newInstance()->findByPrimaryKey($jobID);

            $data = sprintf(__('%1$s created a new job offer: "%2$s"', 'jobboard'), osc_logged_admin_name(), $job['s_title']);
            $this->log->logJobboard('newjob', $jobID, $data);
        }

        function log_edit_job($catID, $jobID) {
            $job = Item::newInstance()->findByPrimaryKey($jobID);

            $data = sprintf(__('%1$s made changes to the job offer: "%2$s"', 'jobboard'), osc_logged_admin_name(), $job['s_title']);
            $this->log->logJobboard('editjob', $jobID, $data);
        }

        function log_delete_job($jobID)
        {
            $job = Item::newInstance()->findByPrimaryKey($jobID);

            $data = sprintf(__('%1$s has deleted the job offer: "%2$s"', 'jobboard'), osc_logged_admin_name(), $job['s_title']);
            $this->log->insertLog('jobboard_pending', 'deletejob', $jobID, $data, osc_logged_admin_username(), osc_logged_admin_id());
        }

        function log_confirm_delete_job($jobID)
        {
            ModelLogJB::newInstance()->confirmDelete('jobboard_pending', 'deletejob', $jobID, 'jobboard');
        }

        function log_new_applicant($applicantID, $jobID)
        {
            $job       = Item::newInstance()->findByPrimaryKey($jobID);
            $applicant = ModelJB::newInstance()->getApplicant($applicantID);

            $data = sprintf(__('%1$s has applied to the job offer: "%2$s"', 'jobboard'), $applicant['s_name'], $job['s_title']);
            $this->log->logJobboard('newapplicant', $applicantID, $data);
        }

        function log_rate_applicant($applicantID, $rate)
        {
            $applicant = ModelJB::newInstance()->getApplicant($applicantID);

            $title = __('Spontaneous application', 'jobboard');
            if( !is_null($applicant['fk_i_item_id']) && is_numeric($applicant['fk_i_item_id']) ) {
                $job   = Item::newInstance()->findByPrimaryKey($applicant['fk_i_item_id']);
                $title = $job['s_title'];
            }

            $data = sprintf(__('%1$s has rated to <b>%2$s</b> an applicant: %3$s (%4$s)', 'jobboard'), osc_logged_admin_name(), $rate, $applicant['s_name'], $title);
            $this->log->logJobboard('rateapplicant', $applicantID, $data);
        }

        function log_new_note($applicantID)
        {
            $applicant = ModelJB::newInstance()->getApplicant($applicantID);

            $title = __('Spontaneous application', 'jobboard');
            if( !is_null($applicant['fk_i_item_id']) && is_numeric($applicant['fk_i_item_id']) ) {
                $job   = Item::newInstance()->findByPrimaryKey($applicant['fk_i_item_id']);
                $title = $job['s_title'];
            }

            $data = sprintf(__('%1$s has added a note to the applicant %2$s (%3$s)', 'jobboard'), osc_logged_admin_name(), $applicant['s_name'], $title);
            $this->log->logJobboard('newnote', $applicantID, $data);
        }

        function log_edit_note($applicantID, $noteID)
        {
            $applicant = ModelJB::newInstance()->getApplicant($applicantID);

            $title = __('Spontaneous application', 'jobboard');
            if( !is_null($applicant['fk_i_item_id']) && is_numeric($applicant['fk_i_item_id']) ) {
                $job   = Item::newInstance()->findByPrimaryKey($applicant['fk_i_item_id']);
                $title = $job['s_title'];
            }

            $data = sprintf(__('%1$s has edited a note of the applicant %2$s (%3$s)', 'jobboard'), osc_logged_admin_name(), $applicant['s_name'], $title);
            $this->log->logJobboard('editnote', $applicantID, $data);
        }

        function log_remove_note($applicantID, $noteID)
        {
            $applicant = ModelJB::newInstance()->getApplicant($applicantID);

            $title = __('Spontaneous application', 'jobboard');
            if( !is_null($applicant['fk_i_item_id']) && is_numeric($applicant['fk_i_item_id']) ) {
                $job   = Item::newInstance()->findByPrimaryKey($applicant['fk_i_item_id']);
                $title = $job['s_title'];
            }

            $data = sprintf(__('%1$s has deleted a note of the applicant %2$s (%3$s)', 'jobboard'), osc_logged_admin_name(), $applicant['s_name'], $title);
            $this->log->logJobboard('deletenote', $applicantID, $data);
        }

        function log_change_status_application($applicantID, $status)
        {
            $aStatus   = jobboard_status();
            $applicant = ModelJB::newInstance()->getApplicant($applicantID);

            $title = __('Spontaneous application', 'jobboard');
            if( !is_null($applicant['fk_i_item_id']) && is_numeric($applicant['fk_i_item_id']) ) {
                $job   = Item::newInstance()->findByPrimaryKey($applicant['fk_i_item_id']);
                $title = $job['s_title'];
            }

            $data = sprintf(__('%1$s has changed "%2$s" applicant status to %3$s (%4$s)', 'jobboard'), osc_logged_admin_name(), $applicant['s_name'], $aStatus[$status], $title);
            $this->log->logJobboard('changestatus', $applicantID, $data);
        }
    }

    $stream = new Stream();

    // End of file: ./jobboard/class/Stream.class.php