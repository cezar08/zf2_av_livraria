<?php

namespace Core\Service;

use Core\Service\Service;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime;

/**
 * Serviço para enviar e-mails
 * @category Core
 * @package Service
 * @author Cezar
 */
class Email extends Service {

    protected $message;
    protected $from;
    protected $to;
    protected $title;
    protected $text;
    protected $options;

    public function __construct() {

        $this->message = new Message();
        $this->options = new SmtpOptions(array(
            "name" => "gmail",
            "host" => "smtp.gmail.com",
            "port" => 587,
            "connection_class" => "plain",
            "connection_config" => array("username" => "livrariazf2@gmail.com",
                "password" => "livraria123", "ssl" => "tls")
        ));
    }

    /**
     * Função responsável por enviar e-mail
     */
    public function send($texto, $from, $to, $title) {

        $text = new MimePart($texto);
        $text->type = "text/plain";

        $html = new MimePart('Hello World');

        $html->type = 'text/html';        
 
        $this->message->setBody($texto);
        $this->message->setFrom('livrariazf2@gmail.com', $from);
        $this->message->addTo($to['email'], $to['name']);
        $this->message->setSubject($title);

        $transport = new SmtpTransport();
        $transport->setOptions($this->options);
        $transport->send($this->message);
    }

}

?>

