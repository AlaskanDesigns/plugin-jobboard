<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

    // only admin access
    if( !osc_is_admin_user_logged_in() ) osc_die('Admin access only');

    class JobboardPeople
    {
        public function __construct(){}

        public function main()
        {
            if( $_SERVER['REQUEST_METHOD'] === 'POST' && Params::getParam("add_new_applicant") ) {
                $this->add_applicant();
            }

            $search = array();
            $search['conditions'] = $this->get_search_conditions();
            $search['order']      = $this->get_search_order();
            $search['limit']      = $this->get_search_limit();

            // get applicants info
            $people = ModelJB::newInstance()->search($search['limit']['offset'], $search['limit']['length'], $search['conditions'], $search['order']['col'], $search['order']['dir']);
            list($displayed, $total) = ModelJB::newInstance()->searchCount($search['conditions'], $search['order']['col'], $search['order']['dir']);

            // pagination
            $search['pagination'] = $this->get_search_pagination(count($people), $displayed, $total);
            // different status
            $status = jobboard_status();

            // get notes and listing info
            foreach($people as &$p) {
                $p['notes']   = ModelJB::newInstance()->getNotesFromApplicant($p['pk_i_id']);
                $p['listing'] = ModelJB::newInstance()->getJobsAttrByItemId($p['fk_i_item_id']);
            }

            $urlOrder = osc_admin_base_url(true).'?'.$_SERVER['QUERY_STRING'];
            $urlOrder = preg_replace('/&iPage=(\d+)?/', '', $urlOrder) ;
            $urlOrder = preg_replace('/&sOrderCol=([^&]*)/', '', $urlOrder) ;
            $urlOrder = preg_replace('/&sOrderDir=([^&]*)/', '', $urlOrder) ;

            $mSearch = new Search();
            $mSearch->limit(0, 100);
            $aItems = $mSearch->doSearch();
            View::newInstance()->_exportVariableToView('items', $aItems);

            // navbar
            $navbar = $this->navbar();

            // load
            require_once(JOBBOARD_VIEWS . 'applicants/list.php');
        }

        /**
         *
         * @return array
         */
        private function get_search_conditions()
        {
            $conditions = array();
            if(Params::getParam('jobId')!='') {
                if(Params::getParam('jobId') > 0) {
                    $conditions['item'] = Params::getParam('jobId');
                } else if(Params::getParam('jobId') == -1) {
                     $conditions['spontaneous'] = 1;
                }
            }
            // default active status
            if(Params::getParam('statusId')=='') {
                Params::setParam('statusId', 0);
            }
            if(Params::getParam('statusId')>=0) {
                $conditions['status'] = Params::getParam('statusId');
            }
            if(Params::getParam('viewUnread')=='1') {
                $conditions['unread'] = 1;
                unset( $conditions['status'] );
            }
            if(Params::getParam('uncorrected_forms')!='') {
                $conditions['uncorrected_forms'] = Params::getParam('uncorrected_forms');
            }
            if(Params::getParam('sEmail')!='') {
                $conditions['email'] = Params::getParam('sEmail');
            }
            if(Params::getParam('sName')!='') {
                $conditions['name'] = Params::getParam('sName');
            }
            if(Params::getParam('sSex')!='') {
                $conditions['sex'] = Params::getParam('sSex');
            }
            if(Params::getParam('catId')!='') {
                $conditions['category'] = Params::getParam('catId');
            }
            // age
            if(Params::getParam('minAge')!='') {
                $conditions['minAge'] = Params::getParam('minAge');
            }
            if(Params::getParam('maxAge')!='') {
                $conditions['maxAge'] = Params::getParam('maxAge');
            }
            if(Params::getParam('rating')!='') {
                $conditions['rating'] = Params::getParam('rating');
            }

            return $conditions;
        }

        private function get_search_order()
        {
            $order = array(
                'col' => 'a.dt_date',
                'dir' => 'DESC'
            );

            // Get order from Params
            if( Params::getParam('sOrderCol') !== '' ) {
                $order['col'] = Params::getParam('sOrderCol');
            }
            // Get direction from Params
            if( Params::getParam('sOrderDir') !== '' ) {
                $order['dir'] = Params::getParam('sOrderDir');
            }

            return $order;
        }

        private function get_search_limit()
        {
            // default values
            $limit = array(
                'offset' => 0,
                'length' => 10
            );

            // get display length from params
            $iDisplayLength = Params::getParam('iDisplayLength');
            if( is_numeric($iDisplayLength) ) {
                $limit['length'] = $iDisplayLength;
            }

            // get page from params to calc offset
            $iPage = 1;
            if( is_numeric(Params::getParam('iPage')) && Params::getParam('iPage') > 1 ) {
                $iPage = Params::getParam('iPage');
            }

            $limit['offset'] = ($iPage - 1) * $limit['length'];

            return $limit;
        }

        private function get_search_pagination($showing, $displayed, $total)
        {
            $pagination = array(
                'page'      => 1,
                'length'    => 10,
                'displayed' => $displayed,
                'total'     => $total
            );

            // get display length from params
            $iDisplayLength = Params::getParam('iDisplayLength');
            if( is_numeric($iDisplayLength) ) {
                $pagination['length'] = $iDisplayLength;
            }

            // get page from params to calc offset
            $iPage = Params::getParam('iPage');
            if( is_numeric($iPage) && $iPage > 1 ) {
                $pagination['page'] = $iPage;
            }

            // calc from and to
            $pagination['from'] = (($pagination['page'] - 1) * $pagination['length']) + 1;
            $pagination['to']   = $pagination['page'] * $pagination['length'];
            if( $pagination['to'] > $pagination['displayed'] ) {
                $pagination['to'] = $pagination['displayed'];
            }

            return $pagination;
        }

        private function navbar() {
            $shortcuts = array();
            $shortcuts['unread'] = array();
            $totalApplicantsShortcut = ModelJB::newInstance()->countApplicantsUnread();
            $shortcuts['unread']['total'] = $totalApplicantsShortcut;
            $shortcuts['unread']['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&viewUnread=1';
            $shortcuts['unread']['active'] = false;
            if( Params::getParam('viewUnread') ) {
                $shortcuts['unread']['active'] = true;
            }
            $shortcuts['unread']['text'] = sprintf(__('Unread (%1$s)', 'jobboard'), $totalApplicantsShortcut);
            $shortcuts['active'] = array();
            $totalApplicantsShortcut = ModelJB::newInstance()->countApplicantsByStatus('0');
            $shortcuts['active']['total'] = $totalApplicantsShortcut;
            $shortcuts['active']['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&statusId=0';
            $shortcuts['active']['active'] = false;
            if( Params::getParam('statusId') == '0' && !Params::getParam('viewUnread') ) {
                $shortcuts['active']['active'] = true;
            }
            $shortcuts['active']['text'] = sprintf(__('Active (%1$s)', 'jobboard'), $totalApplicantsShortcut);
            $shortcuts['interview'] = array();
            $totalApplicantsShortcut = ModelJB::newInstance()->countApplicantsByStatus('1');
            $shortcuts['interview']['total'] = $totalApplicantsShortcut;
            $shortcuts['interview']['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&statusId=1';
            $shortcuts['interview']['active'] = false;
            if( Params::getParam('statusId') == '1' ) {
                $shortcuts['interview']['active'] = true;
            }
            $shortcuts['interview']['text'] = sprintf(__('Interview (%1$s)', 'jobboard'), $totalApplicantsShortcut);
            $shortcuts['rejected'] = array();
            $totalApplicantsShortcut = ModelJB::newInstance()->countApplicantsByStatus('2');
            $shortcuts['rejected']['total'] = $totalApplicantsShortcut;
            $shortcuts['rejected']['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&statusId=2';
            $shortcuts['rejected']['active'] = false;
            if( Params::getParam('statusId') == '2' ) {
                $shortcuts['rejected']['active'] = true;
            }
            $shortcuts['rejected']['text'] = sprintf(__('Rejected (%1$s)', 'jobboard'), $totalApplicantsShortcut);
            $shortcuts['hired'] = array();
            $totalApplicantsShortcut = ModelJB::newInstance()->countApplicantsByStatus('3');
            $shortcuts['hired']['total'] = $totalApplicantsShortcut;
            $shortcuts['hired']['url'] = osc_admin_render_plugin_url('jobboard/people.php') . '&statusId=3';
            $shortcuts['hired']['active'] = false;
            if( Params::getParam('statusId') == '3' ) {
                $shortcuts['hired']['active'] = true;
            }
            $shortcuts['hired']['text'] = sprintf(__('Hired (%1$s)', 'jobboard'), $totalApplicantsShortcut);

            return $shortcuts;
        }

        private function add_applicant()
        {
            $applName   = Params::getParam("applicant-name");
            $applEmail  = Params::getParam("applicant-email");
            $applPhone  = Params::getParam("applicant-phone");
            $applBday   = date("Y-m-d", strtotime(Params::getParam("applicant-birthday")));

            $applSex    = Params::getParam("applicant-sex");
            $applJob    = Params::getParam("applicant-job");
            $applStatus = Params::getParam("applicant-status");
            $applFile   = Params::getFiles("applicant-attachment");
            $applRating = Params::getParam("applicant-rating");

            //insert applicant
            ModelJB::newInstance()->insertApplicant($applJob, $applName, $applEmail, '', $applPhone, $applBday, $applSex);

            //get Applicant id
            $aApplicant = current(ModelJB::newInstance()->getLastApplicant());

            //set rating
            ModelJB::newInstance()->setRating($aApplicant["pk_i_id"], $applRating);

            //update status
            if($applStatus != '') {
                ModelJB::newInstance()->changeStatus($aApplicant["pk_i_id"], $applStatus);
            }

            //insert file in DB
            ModelJB::newInstance()->insertFile($aApplicant["pk_i_id"], $applFile["name"]);

            //insert file in disk
            $jobboardContact = new JobboardContact();
            $jobboardContact->uploadCV($applFile, $aApplicant["pk_i_id"]);
        }
    }

    $jp = new JobboardPeople();
    $jp->main();

    // EOF