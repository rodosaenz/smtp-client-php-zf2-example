<?php
namespace Rodosaenz\Example\Smtp\Client;

require '../vendor/autoload.php';

use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Message;

class SmtpClientTextExample {

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
            $message->setSubject('Testing PHP ZF2 Text Email');
            $message->setBody('Testing PHP ZF2 Text Email');

            $transport->send($message);

            print "Sent message successfully....;";
            
        } catch (Exception $e) {
            print "Sent message successfully....;";
            print $e->getMessage();
        }
    }

}

$client = new SmtpClientTextExample();
$client->main();
