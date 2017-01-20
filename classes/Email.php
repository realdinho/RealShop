<?php

require_once ('PHPMailer_v5.1/PHPMailer.php');

//require ('PHPMailer_v5.2/PHPMailerAutoload.php');

class Email {

    private $objMailer;

    public function __construct() {

        $this->objMailer = new PHPMailer();
        $this->objMailer->IsSMTP();
        $this->objMailer->Host = "smtp.gmail.com";
        $this->objMailer->SMTPAuth = true;
        $this->objMailer->SMTPKeepAlive = true;
        $this->objMailer->Username = 'felerminoali@gmail.com';                 // SMTP username
        $this->objMailer->Password = 'gFRDSDSRER';
        $this->objMailer->SMTPSecure = 'ssl';
        $this->objMailer->Port = 465;


        $this->objMailer->SetFrom('felerminoali@gmail.com', 'Felermino Ali');
        $this->objMailer->addReplyTo('felerminoali@gmail.com', 'Felermino Ali');
    }

    public function process($case = null, $array = null) {
        if (!empty($case)) {

            switch ($case) {
                case 1:
                    // add url to the array
//                    $link = '<a href="' . SITE_URL .':8282'. APP_NAME . '/?page=activate&code=';
                    $link = '<a href="'. SITE_URL. '/?page=activate&code=';
                    $link .= $array['hash'];
                    $link .='">';
//                    $link .= SITE_URL .':8282'. APP_NAME . '/?page=activate&code=';
                    $link .= SITE_URL.'/?page=activate&code=';
                    $link .= $array['hash'];
                    $link .= '</a>';
                    $array['link'] = $link;

                    $this->objMailer->Subject = "Activate your account";

                    $this->objMailer->msgHTML($this->fetchEmail($case, $array));
                    $this->objMailer->addAddress(
                            $array['email'], $array['first_name'] . ' ' . $array['last_name']
                    );

                    break;
            }
            // send email
            $this->objMailer->isHTML(true);   
            if ($this->objMailer->send()) {
                $this->objMailer->clearAddresses();
                return true;
            }
            return false;
        }
    }

    public function fetchEmail($case = null, $array = null) {
        if (!empty($case)) {

            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    ${$key} = $value;
                }
            }

            ob_start();
            require_once (EMAILS_PATH . DS . $case . ".php");
            $out = ob_get_clean();
            return $this->wrapEmail($out);
        }
    }

    public function wrapEmail($content = null) {
        if (!empty($content)) {
            return '<div style="font-family:Arial,Verdana,Sans-serif;font-size:12px;color:#333;line-height:21px;">' . $content . '</div>';
        }
    }
}
