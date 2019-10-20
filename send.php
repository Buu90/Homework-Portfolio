<?php
 
 
 
function get_client_ip() {
 $ipaddress = '';
 if (!empty($_SERVER['HTTP_CLIENT_IP']))
  $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
 else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
 else if(!empty($_SERVER['HTTP_X_FORWARDED']))
  $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
 else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
  $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
 else if(!empty($_SERVER['HTTP_FORWARDED']))
  $ipaddress = $_SERVER['HTTP_FORWARDED'];
 else if(!empty($_SERVER['REMOTE_ADDR']))
  $ipaddress = $_SERVER['REMOTE_ADDR'];
 else
  $ipaddress = 'UNKNOWN';
 return $ipaddress;
}

function get_current_date(){
 return strftime('%d.%m.%Y %H:%M:%S', time());
}

function get_html_headers($from_name, $from_email){
 $header = "MIME-Version: 1.0\r\n";
 $header.= "Content-type: text/html; charset=UTF-8\r\n";
 $header.= sprintf("From: %s <%s>\r\n", $from_name, $from_email);
 return $header;
}

function get_html_message($subject, $form_data, $key_labels=array()){
 $client_ip = get_client_ip();
 $current_date = get_current_date();
 $message = '<!DOCTYPE html">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 <title>'.$subject.'</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
 </head>
 <body style="margin:0; padding: 0;">
 <table align="center" cellpadding="0" cellspacing="0" width="500" style="border-collapse: collapse; margin: 0 auto; font-family: "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif; border: 1px solid #333;">
 <tr>
 <th style="border: 1px solid #333; background-color: #333; text-align: center; padding: 10px;" colspan="2"><h1 style="color: #fff; font-size: 18px; margin: 0; padding: 0;">'.$subject.'</h1></th>
 </tr>';

 foreach($form_data as $key => $value){
  

   $message .= '<tr>';
   $message .= '<td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">'.$key.'</td>';
   $message .= '<td style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">'.$value.'</td>
  </tr>';
    
 }
 $message .= '<tr><td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">Дата отправления</td>';
 $message .= '<td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">'.$current_date.'</td></tr>';

 $message .= '<tr><td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">IP отправителя</td>';
 $message .= '<td width="200" style="border: 1px solid #333; font-size: 14px; line-height: 18px; padding: 5px;">'.$client_ip.'</td></tr>';
 $message .= '</table></body></html>'; 
 return $message;
}


 
    // Если скрытое поле заполнено
 if ($_POST['invisible']!=''){
   die('Skazhem botam - net!');
 }
 else{
    $from_name = 'Заявка с сайта, Жоров А.В. "';
  $from_email = 'zhorau.ru';
  $to_email = 'zhorau90@gmail.com';
  $subject = "Жоров Артём";
  $key_labels = array('tel'=>'Телефон', 'email'=>'Email', 'name'=>'Имя');
  
  $headers = get_html_headers($from_name, $from_email);
  $html_message = get_html_message($subject, $_POST, $key_labels);
  
  $mail = mail ($to_email, $subject, $html_message, $headers);
  if($mail){
   header('Location: /thanks.html');
  }
     else {
         print("Location: /thanks.html");
     }
 }
   





?>
