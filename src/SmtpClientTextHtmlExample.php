<?php
namespace Rodosaenz\Example\Smtp\Client;

require '../vendor/autoload.php';

use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part;
use Zend\Mime\Mime;

class SmtpClientTextHtmlExample {

    function main() {
        try {
            
            $smtpOptions = new SmtpOptions();
            $smtpOptions->setHost('smtp.gmail.com')
                    ->setConnectionClass('login')
                    ->setName('smtp.gmail.com')
                    ->setConnectionConfig(array(
                        'username' => '<YOUR-ACOUNT>',
                        'password' => '**********',
                        'ssl' => 'tls',
            ));

            $transport = new Smtp($smtpOptions);

            $message = new Message();
            $message->setFrom('from@gmail.com');
            $message->addTo('to@gmail.com');
            $message->setSubject('Testing PHP ZF2 Text Html Email');

            $mimeMessage = new MimeMessage(); //Multipart
            $mimeMessage->type = Mime::MULTIPART_ALTERNATIVE;
            
            $text = "Testing PHP ZF2 Text Html Email á";
            $textPart = new Part($text); //Bodypart
            $textPart->type = Mime::TYPE_TEXT;
            $mimeMessage->addPart($textPart);

            
            $html = "<h1>Testing PHP ZF2 Text Html Email</h1>";
            $htmlPart = new Part($html); //Bodypart
            $htmlPart->type = Mime::TYPE_HTML;
            $mimeMessage->addPart($htmlPart);

            $message->setBody($mimeMessage);
            $message->setEncoding("UTF-8");
            $message->getHeaders()->get('content-type')->setType(Mime::MULTIPART_ALTERNATIVE);

            $transport->send($message);

            print "Sent message successfully....;";
            
        } catch (Exception $e) {
            
            print "Sent message failed....;";
            print $e->getMessage();
        }
    }

}

$client = new SmtpClientTextHtmlExample();
$client->main();
