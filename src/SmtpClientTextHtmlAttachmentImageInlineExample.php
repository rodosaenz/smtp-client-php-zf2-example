<?php
namespace Rodosaenz\Example\Smtp\Client;

require '../vendor/autoload.php';

use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part;
use Zend\Mime\Mime;

class SmtpClientTextHtmlAttachmentImageInlineExample {

    function main() {
        try {

            $smtpOptions = new SmtpOptions();

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
            $message->setSubject('Testing PHP ZF2 Html, Attachment, Image Inline');

            $mimeMessage = new MimeMessage(); //Multipart

            $text = "Testing PHP ZF2 Text Html Email";
            $textPart = new Part($text); //Bodypart
            $textPart->type = Mime::TYPE_TEXT;
            //$mimeMessage->addPart($textPart);
            /* Comentamos lo anterior ya que para usar el texto hay que 
              decir que el multipart es 'alternative' pero en realidad es
              'related' ya que está la imagen embebida. */


            $html = "<h1>Testing PHP ZF2 Text Html Email</h1>";
            $html .= "<img src=\"cid:image_id_random\">";
            $htmlPart = new Part($html); //Bodypart
            $htmlPart->type = Mime::TYPE_HTML;
            $mimeMessage->addPart($htmlPart);


            $attachment = new Part(file_get_contents("aws-overview-2015-12.pdf"));
            $attachment->filename = "aws-overview-2015-12.pdf";
            $attachment->type = Mime::TYPE_OCTETSTREAM;
            $attachment->encoding = Mime::ENCODING_BASE64;
            $attachment->disposition = Mime::DISPOSITION_ATTACHMENT;
            $mimeMessage->addPart($attachment);


            $image = new Part(file_get_contents("logo.png"));
            $image->filename = "logo.png";
            $image->type = "image/png";
            $image->encoding = Mime::ENCODING_BASE64;
            $image->disposition = Mime::DISPOSITION_INLINE;
            $image->id = "image_id_random";
            $mimeMessage->addPart($image);


            $message->setBody($mimeMessage);
            $message->setEncoding("UTF-8");
            $message->getHeaders()->get('content-type')->setType(Mime::MULTIPART_RELATED);

            $transport->send($message);

            print "Sent message successfully....;";
        } catch (Exception $e) {

            print "Sent message failed....;";
            print $e->getMessage();
        }
    }

}

$client = new SmtpClientTextHtmlAttachmentImageInlineExample();
$client->main();

/**
 * Problemas con el outlook para ver la imagen? ver:
 * https://support.microsoft.com/en-us/kb/2779191
 * http://kb.politemail.com/?p=481
 * 
 */
