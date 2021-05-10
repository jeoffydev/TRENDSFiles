<?
// Inspired by tutorials: http://www.phpfreaks.com/tutorials/130/6.php
// http://www.vbulletin.com/forum/archive/index.php/t-113143.html
// http://hudzilla.org

// Create the mysql backup file
// edit this section
if(empty($_GET['tr'])) {
	die();
} else {
	if($_GET['tr'] !=="sips") {
		die();
	}
}

ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  echo error_reporting(E_ALL);

$dbhost = "localhost"; // usually localhost
$dbuser = "trends_backupper";
$dbpass = "tPcHQ3GbOiNklkKc2PDq";
$dbname = "trends_collection";
$sendsubject = "Daily Mysql Backup - ".date("Y-m-d");
$bodyofemail = "Here is the daily backup.";
// don't need to edit below this section

$backupfile = $dbname.date("Y-m-d").'.sql';
$backupzip = $backupfile.'.gz';
system("mysqldump -h $dbhost -u $dbuser -p$dbpass $dbname banners categoriesCurrent colourSearch customerData customSite productChangeTypes productsApparel productsChanges productsCurrent productsPricing userData userFavs  > $backupfile");
system("gzip -c $backupfile > $backupzip");

// Mail the file


require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.sitehost.co.nz';
$mail->SMTPAuth = false;
//$mail->Username = 'backup@trendscollection.co.nz';
//$mail->Password = 'yq6097922';
$mail->Port = 25;

$mail->setFrom('backup@trendscollection.co.nz', 'Trends Automated Backup');
$mail->addAddress('jasonl@tuapeka.co.nz');
$mail->addAddress('jeoffyh@tuapeka.co.nz');

$mail->addAttachment($backupzip);
$mail->isHTML(false);

$mail->Subject = $sendsubject;
$mail->Body    = $bodyofemail;
$mail->AltBody = $bodyofemail;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}


// Delete the file from your server
unlink($backupfile);
unlink($backupzip);
?>
