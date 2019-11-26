<?php
error_reporting(1);
ini_set("include_path", '/home1/devlajfg/php:' . ini_get("include_path") );

include('Mail.php');
include('Mail/mime.php');

include 'email.php';

include "../config.php";
include "../utilerias/funciones.php";


session_start();
date_default_timezone_set('America/Mexico_City');

$to = $_POST["email"];
$emailcc = $_POST["emailcc"];
$texto = $_POST["texto"];
$id_fac = $_POST["id_fac"];


$url_base = $URL_PRINCIPAL;
$url_img_pdf = $url_base."/assets/images/pdf.png";
$url_img_xml = $url_base."/assets/images/xml.png";
$url_img_logo = $url_base."/assets/images/logo/logo_principal.png";

$db->query('SELECT
  id_pagos,
  fecha,
  importe,
  UUID,
  urlXML,
  urlPDF,
  UUID_factura,
  cancelado
FROM
  fac_pagos
  WHERE id_pagos = '.$id_fac);
$row = $db->single();


$url_pdf = $row["urlPDF"];
$url_xml = $row["urlXML"];


$contentEmail = '
<html>
<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div>
		<table cellpadding="0" cellspacing="0" border="0" style="background:#f2f2f2">
			<tbody>
				<tr>
					<td style="width:30px"></td>
					<td style="width:640px;padding-top:30px">
						 <img src="'.$url_img_logo.'" width="25%" alt="">
					</td>
					<td style="width:30px"></td>
				</tr>
				<tr>
					<td style="width:30px"></td>
					<td style="width:640px;padding-top:10px">
						<table cellpadding="0" cellspacing="0" border="0" style="width:640px">
							<tbody>
								<tr>
									<td style="background:#fff;border-left:1px solid #ccc;border-top:1px solid #ccc;width:40px;padding-top:10px;padding-bottom:10px;border-radius:5px 0 0 0">
									</td>
									<td align="center" style="background:#fff;border-top:1px solid #ccc;padding-bottom:20px;padding-top:40px">
										<h1 style="color:#333;font-family:Arial,sans-serif;font-size:25px;font-weight:bold;padding:0;margin:0">Carmona impresores</h1>
									</td>
									<td style="background:#fff;border-right:1px solid #ccc;border-top:1px solid #ccc;width:40px;padding-top:10px;padding-bottom:10px;border-radius:0 5px 0 0">
										
									</td>
								</tr>
								<tr>
									<td style="background:#fff;border-left:1px solid #ccc;border-bottom:1px solid #ccc;width:40px;padding-bottom:30px;border-radius:0 0 0 5px">
										
									</td>
									<td style="background:#fff;border-bottom:1px solid #ccc;padding-bottom:30px" align="left">
										<p style="color:#333;font-family:Arial,sans-serif;font-size:14px;line-height:21px;padding:0;margin:0">'.$texto.'</p>
										<p style="color:#333;font-family:Arial,sans-serif;font-size:12px;line-height:18px;padding:0;margin-top:20px">

											<a href="'.$url_pdf.'" target="_blank" style=" padding:8px 110px;border-radius:5px;font-size:14px;font-weight:100;color:#fff;outline:none;text-shadow:none;text-decoration:none;font-family:Arial,sans-serif;font-size:14px;font-weight:bold">  
												<img src="'.$url_img_pdf.'" width="8%" >
											</a>


											<a href="'.$url_xml.'" target="_blank" style="  padding:8px 110px;border-radius:5px;font-size:14px;font-weight:100;color:#fff;outline:none;text-shadow:none;text-decoration:none;font-family:Arial,sans-serif;font-size:14px;font-weight:bold">
												<img src="'.$url_img_xml.'" width="8%"  >
											</a>

										</p>
									</td>
									<td style="background:#fff;border-right:1px solid #ccc;border-bottom:1px solid #ccc;width:40px;padding-bottom:30px;border-radius:0 0 5px 0">
										
									</td>
								</tr>
							 
								</tbody>
							</table>
						</td>
						<td style="width:30px">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>
';

try {
	  




    $from = "Carmona impresores <noreply@carmonaimpresores.com.mx>";
    $to = $to;
    $subject = 'Complemento de Pago de CARMONA IMPRESORES';
    $text = 'Complemento de Pago de CARMONA IMPRESORES';
    $html = $contentEmail;
    $crlf = "\r\n";

    $host = "tls://mail.status200.mx";
    $port = "465";
    $username = "noreply@status200.mx";
    $password = "NoResponder19_";

    $headers = array ('From' => $from,
      'To' => $to,
      'Cc' => $_POST["cc"],
      'Subject' => $subject,
      'Content-Type'  => 'text/html; charset=UTF-8'
    );
    
    $mime_params = array(
      'text_encoding' => '7bit',
      'text_charset'  => 'UTF-8',
      'html_charset'  => 'UTF-8',
      'head_charset'  => 'UTF-8'
    );
        // Creating the Mime message
    $mime = new Mail_mime($crlf);
    
    // Setting the body of the email
    $mime->setTXTBody($text);
    $mime->setHTMLBody($html);
    
    $body = $mime->get();
    $headers = $mime->headers($headers);
    
    
    $smtp = Mail::factory('smtp',
    array ('host' => $host,
    'port' => $port, 
    'auth' => true,
    'username' => $username,
    'password' => $password));
    
    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
      echo 0;
    } else {
        echo 1;
    }
    
	
	 
} catch (Exception $ex) {
    error_log("[" . date("Y-m-d H:i:s") . "] EXC >>" . $exc->getMessage() . " \r\n", 3, "Log.log");
   


}
 

?>