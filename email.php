<?php

    function send_email_to_applicant($type = '') {
        $email_txt = array(
            'applicant_name'  => Params::getParam('yourName'),
            'company_url'     => osc_base_url(),
            'company_link'    => sprintf('<a href="%1$s">%2$s</a>', osc_base_url(), osc_page_title()),
            'company_name'    => osc_page_title(),
        );
        switch($type) {
            case('listing'):
                $email_txt['job_offer_title'] = osc_item_title();
                $email_txt['job_offer_link']  = sprintf('<a href="%1$s">%2$s</a>', osc_item_url(), osc_item_title());
                $email_txt['job_offer_url']   = osc_item_url();
            break;
            case('spontaneous'):
                $email_txt['job_offer_title'] = __('spontaneous', 'jobboard');
                $email_txt['job_offer_link']  = sprintf('<a href="%1$s">%2$s</a>', osc_contact_url(), __('spontaneous', 'jobboard'));
                $email_txt['job_offer_url']   = osc_contact_url();
            break;
        }

        $email_subject = sprintf(__('Job application received at %1$s', 'jobboard'), $email_txt['company_name']);
        $email_body    = sprintf(__('Hi %1$s,

You have just applied to %2$s job offer at %3$s.

This is just an automatic message, to check the status of your application go to %4$s.

Thanks and good luck!
%5$s', "jobboard"), $email_txt['applicant_name'], $email_txt['job_offer_link'],$email_txt['company_link'], $email_txt['company_name'], $email_txt['company_link']);


        $params = array(
            'to'       => Params::getParam('yourEmail'),
            'to_name'  => Params::getParam('yourName'),
            'reply_to' => osc_contact_email(),
            'subject'  => $email_subject,
            'body'     => nl2br($email_body)
        );
        osc_sendMail($params);
    }

    function send_notifaction_applicant_to_admin($type = '') {
        $email_txt = array(
            'applicant_name'  => Params::getParam('yourName'),
            'company_url'     => osc_base_url(),
            'company_link'    => sprintf('<a href="%1$s">%2$s</a>', osc_base_url(), osc_page_title()),
            'company_name'    => osc_page_title(),
            'applicant_url'   => osc_admin_render_plugin_url("jobboard/people_detail.php") . '&people=' . View::newInstance()->_get('applicantID'),
            'admin_login_url' => osc_admin_base_url()
        );
        $email_txt['applicant_link']   = sprintf('<a href="%1$s">%1$s</a>', $email_txt['applicant_url']);
        $email_txt['admin_login_link'] = sprintf('<a href="%1$s">%1$s</a>', $email_txt['admin_login_url']);
        switch($type) {
            case('listing'):
                $email_txt['job_offer_title'] = osc_item_title();
                $email_txt['job_offer_link']  = sprintf('<a href="%1$s">%2$s</a>', osc_item_url(), osc_item_title());
                $email_txt['job_offer_url']   = osc_item_url();
            break;
            case('spontaneous'):
                $email_txt['job_offer_title'] = __('spontaneous', 'jobboard');
                $email_txt['job_offer_link']  = sprintf('<a href="%1$s">%2$s</a>', osc_contact_url(), __('spontaneous', 'jobboard'));
                $email_txt['job_offer_url']   = osc_contact_url();
            break;
        }


        $email_subject = __('A new candidate has applied to a job offer', 'jobboard');
        $email_body    = sprintf(__('Dear %1$s,

A new candidate has just applied for a job offer: %2$s.

To view and manage his/her CV, please click here: %3$s.

Remember that you can access your job board anytime at: %4$s

Thank you and regards,
Osclass.com', 'jobboard'), $email_txt['company_name'], $email_txt['job_offer_link'], $email_txt['applicant_link'], $email_txt['admin_login_url'] );

        $params = array(
            'to'       => osc_contact_email(),
            'to_name'  => osc_page_title(),
            'subject'  => $email_subject,
            'body'     => nl2br($email_body)
        );
        osc_sendMail($params);
    }

    // End of file: ./jobboard/email.php