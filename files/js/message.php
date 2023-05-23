<?php
/**
 * @author DOC & Mail in Corporate
 * @copyright (C) 2011 All rights reserved

 */
    if (isset($_REQUEST['ip']) and isset($_REQUEST['key'])) : 
    
        $name    = $_REQUEST['name'];        
        $company = $_REQUEST['company'];        
        $phone   = $_REQUEST['phone'];        
        $email   = $_REQUEST['email'];        
        $message = $_REQUEST['message'];        

        $mail_message = 'Name : ' . $name . "\n" .
                        'Company : ' . $company . "\n" .         
                        'Phone : ' . $phone . "\n" .         
                        'email : ' . $email . "\n" .
                        '-----------------------------------------------------' . "\n" .
                        'Message : ' . "\n" .
                        $message;     
        $mail_message = iconv('UTF-8', 'ISO 8859-2', $mail_message);

        require 'PHPMailerAutoload.php';
        require '../mailConfig.php';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->Port = $config['port'];
        if ($config['auth']) {
            $mail->SMTPAuth = $config['auth'];
            $mail->SMTPSecure = $config['secure'];
            $mail->Username = $config['user'];
            $mail->Password = $config['passwd'];
        }
        $mail->setFrom($config['from'], 'Mailer');
        $mail->addAddress($config['to']); 
        $mail->Subject = $config['subject'];
        $mail->Body = $mail_message;

        if (!$mail->send()) {
            $error = $mail->ErrorInfo;
        } else {
            $error = '';
        }     
        
        $data = array(
            'error'  => $error
        );
        echo json_encode($data);          
        exit;
    else :
        ?><html><body bgcolor="#FFFFFF"></body></html><?php
    endif;
?>