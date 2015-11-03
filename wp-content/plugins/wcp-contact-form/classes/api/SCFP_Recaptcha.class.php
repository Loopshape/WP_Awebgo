<?php
use Webcodin\WCPContactForm\Core\Agp_Curl;

class SCFP_Recaptcha extends Agp_Curl {
    
    public function __construct() {
        parent::__construct('https://www.google.com/recaptcha/api/siteverify');
    }
    
}