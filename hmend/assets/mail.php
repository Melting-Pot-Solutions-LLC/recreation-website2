<?php
if (isset ($_POST['contactFF'])) {
    // Get the form fields and remove whitespace.
    $name = $_POST['nameFF'];
    $phone = $_POST["phone"];
    $from = $_POST['contactFF'];
    $square = $_POST["square"];
    $price = $_POST["price"];
    $messageText = $_POST['messageFF'];
    $serviceOption = $_POST['service'];
    
    
  $to = "chris@sceneryupgrade.com"; 
  $subject = "New contact from Scenery Upgrade Website ".$_SERVER['HTTP_REFERER'];
    
    $message = "Name: $name\n\n";
    $message .= "Phone: $phone\n\n";
    $message .= "Email: $from\n\n";
    $message .= "Square: $square\n\n";
    $message .= "Price: $price\n\n";
    $message .= "ServiceOption: $serviceOption\n\n";
    $message .= "Message:\n$messageText\n";
    
  $boundary = md5(date('r', time()));
  $filesize = '';
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "From: " . $from . "\r\n";
  $headers .= "Reply-To: " . $from . "\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"

--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit

$message";
  for($i=0;$i<count($_FILES['fileFF']['name']);$i++) {
     if(is_uploaded_file($_FILES['fileFF']['tmp_name'][$i])) {
         $attachment = chunk_split(base64_encode(file_get_contents($_FILES['fileFF']['tmp_name'][$i])));
         $filename = $_FILES['fileFF']['name'][$i];
         $filetype = $_FILES['fileFF']['type'][$i];
         $filesize += $_FILES['fileFF']['size'][$i];
         $message.="

--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"

$attachment";
     }
   }
   $message.="
--$boundary--";

  if ($filesize < 10000000) { 
    mail($to, $subject, $message, $headers);
    echo $_POST['nameFF'].', thank You! Your message has been sent.';
  } else {
    echo 'The size of all files exceeds 10 MB.';
  }
}
?>