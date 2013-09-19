<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

    // only admin access
    if( !osc_is_admin_user_logged_in() ) osc_die('Admin access only');

    class JobboardPeopleDetail
    {
        public function __construct()
        {
        }

        public function main()
        {
            $has_submited_more_vacancies = false;
            $applicantId = Params::getParam("people");

            $mjb    = ModelJB::newInstance();
            $people = $mjb->getApplicant($applicantId);

            $file   = $mjb->getCVFromApplicant($applicantId);
            ModelJB::newInstance()->changeSecret($file['pk_i_id']);
            $file   = $mjb->getCVFromApplicant($applicantId);

            $aTags = json_decode($people["s_tags"], true);


            $notes  = $mjb->getNotesFromApplicant($applicantId);
            $aNotes = array();
            if(count($notes)>0) {
                foreach($notes as $note) {
                    $note["admin_username"] = ModelJB::newInstance()-> getAdminUsername($note["fk_i_admin_id"]);
                    $aNotes[] = $note;
                }
            }

            $adminManager = Admin::newInstance();
            $aAdmin       = $adminManager->findByPrimaryKey(osc_logged_admin_id());

            $aMails = array();
            $aMails = applicant_emailsent_get($applicantId);

            $job = Item::newInstance()->findByPrimaryKey($people['fk_i_item_id']);

            if($people['b_read']==0) {
                ModelJB::newInstance()->changeRead($applicantId);
            }
            // show: This user has applied to more jobs
            $aApplicants = $mjb->search(0,2,array('email' => $people['s_email']));
            if(count($aApplicants)>1) {
                $has_submited_more_vacancies = true;
            }

            // -------------------------------------------------------------------------
            // get killer questions ...
            $correctedForm  = $people['b_corrected'];
            $jobInfo        = $mjb->getJobsAttrByItemId($people['fk_i_item_id']);
            $killer_form_id = @$jobInfo['fk_i_killer_form_id'];
            $aQuestions     = array();

            $acomulateScore = 0;
            $maxPunctuation = 0;
            $aKillerForm    = ModelKQ::newInstance()->getKillerForm($killer_form_id);
            if(is_array($aKillerForm) && !empty($aKillerForm)) {
                // get killer form information ...
                $aQuestions = ModelKQ::newInstance()->getKillerQuestions($killer_form_id);
                $aAnswers   = ModelKQ::newInstance()->getResultsByApplicant($applicantId);

                foreach($aAnswers as $key => $_aux) {
                    if(is_numeric( @$_aux['s_punctuation'] )){
                        $acomulateScore += @$_aux['s_punctuation'];
                    }
                }
                $maxPunctuation = count($aAnswers)*10;
            }
            $score = (float)number_format($people['d_score'],1);

            // load
            require_once(JOBBOARD_VIEWS . 'applicants/detail.php');
        }
    }

    $jpd = new JobboardPeopleDetail();
    $jpd->main();

    // EOF