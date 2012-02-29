<?php

class Mail {
    private $to;			// Destinataire
    private $from;          // Expéditeur
    private $subject;		// Objet
    private $content;		// Contenu
    private $headers;		// Headers

    function __construct() { }

    function send() {
		if(isset($this->to) && isset($this->subject) && isset($this->to)) {
			$this->from = (!isset($this->from)) ? 'test@test.com' : $this->from;

			$this->headers  = 'MIME-Version: 1.0' . "\r\n";
			$this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$this->headers .= 'To: <'.$this->to.'>' . "\r\n";
			$this->headers .= 'From: <'.$this->from.'@example.com>' . "\r\n";
			
			mail($this->to, $this->subject, $this->content, $this->headers);
		}
    }

    function __toString() {
        return $this->content;
    }

    function setTo($to) {
        $this->to = $to;
    }
	function setContent($content) {
        $this->content = utf8_encode(nl2br($content));
    }
    function setSubject($subject) {
        $this->subject = $subject;
    }
    function setFrom($from) {
        $this->from = $from;
    }
}


?>