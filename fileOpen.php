<?php 
/* this script is design to send pdf file to view at 
 * the browser window
 * 
 */
//- turn off compression on the server
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 'Off');

//$file = fopen("/var/www/form.pdf","r") or die("\nUnable to open file!");
$file = "/var/www/annual_report_2009.pdf";

//$file = fopen("/var/www/form.pdf","r") or die("\nUnable to open file!");
$file = "/var/www/annual_report_2009.pdf";

if (file_exists($file)){
	// set the headers, prevent caching
	header("Pragma: public");
	header("Expires: -1");
	header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
	header('Content-Disposition: inline; filename='.basename($file)); // inline for view 
	header("Content-Length:". filesize($file));
	header("Content-type:application/pdf");

	readfile($file);

	//ob_end_clean();//required here or large files will not work
	//fpassthru($file);//works fine now

}
else
	echo "The file $file does not exist";

?>