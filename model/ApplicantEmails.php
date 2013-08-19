<?php

    class ApplicantEmails extends DAO
    {
        /**
         * It references to self object: ApplicantEmails.
         * It is used as a singleton
         *
         * @access private
         * @var ApplicantEmails
         */
        private static $instance ;

        /**
         * It creates a new ApplicantEmails object class ir if it has been created
         * before, it return the previous object
         *
         * @access public
         * @return ApplicantEmails
         */
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

        function __construct()
        {
            parent::__construct();
            $this->setTableName('t_item_job_email');
            $this->setPrimaryKey('pk_i_id');
            $array_fields = array(
                'pk_i_id',
                'fk_i_applicant_id',
                'dt_date',
                's_mail'
            );
            $this->setFields($array_fields);
        }

        /**
         * Insert the email sent to the candidate in DB
         *
         * @param int $applicantID
         * @param string $subject
         * @param string $body
         */
        public function insertEmail($applicantID, $subject, $body)
        {
            $aSet = array(
                'fk_i_applicant_id' => $applicantID,
                'dt_date'           => date("Y-m-d H:i:s"),
                's_mail'            => json_encode(array(
                        'subject' => $subject,
                        'body'    => $body
                    ))
            );

            return $this->dao->insert($this->getTableName(), $aSet);
        }

        /**
         * Get emails sent to an applicant
         *
         * @param type $applicantID
         */
        public function getEmailsPerApplicant($applicantID)
        {
            $this->dao->select();
            $this->dao->from($this->getTableName());
            $this->dao->where('fk_i_applicant_id', $applicantID);
            $this->dao->orderBy('pk_i_id', 'desc');
            $result = $this->dao->get();
            if( !$result ) {
                return array() ;
            }

            return $result->result();
        }
        
        /**
         * Remove saved emails sended to applicant with applicantID
         *
         * @param type $applicantID
         */
        function deleteEmails($applicantID)
        {
            return $this->dao->delete($this->getTableName(), array('fk_i_applicant_id' => $applicantID));
        }
    }


    function applicant_emailsent_insert($applicantID, $subject, $body) {
        return ApplicantEmails::newInstance()->insertEmail($applicantID, $subject, $body);
    }

    function applicant_emailsent_get($applicantID) {
        return ApplicantEmails::newInstance()->getEmailsPerApplicant($applicantID);
    }

    // End of file: ./jobboard/model/ApplicantEmails.php