<?php
	$file = $_GET['file'];
	header('Content-Description: File Transfer');
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: '.filesize($file));
	ob_clean();
	flush();
	readfile($file);
	unlink($file);
	exit;
?>