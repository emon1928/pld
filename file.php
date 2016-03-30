<?php 


//- turn off compression on the server
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 'Off');

//Header no cache. 
// Date in the past
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header("Cache-Control: no-cache");
//header("Pragma: no-cache");

//header("Content-type:application/pdf");
// It will be called downloaded.pdf
//header("Content-Disposition:attachment;filename='downloaded.pdf'");
//readfile("/var/www/form.pdf");

/* If no headers are sent, send one 
if (!headers_sent())
{
	echo "no header sent <br>";
	exit;
}
*/




//$file = fopen("/var/www/form.pdf","r") or die("\nUnable to open file!");
$file = "/var/www/annual_report_2009.pdf";

if (file_exists($file)){
	// set the headers, prevent caching
	header("Pragma: public");
	header("Expires: -1");
	header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
	header('Content-Disposition: attachment; filename='.basename($file)); 
	header("Content-Length:". filesize($file));
	header("Content-type:application/pdf");
	
	readfile($file);
	
	//ob_end_clean();//required here or large files will not work
	//fpassthru($file);//works fine now
	
}
else 
	echo "The file $filename does not exist";

//single line from the file, pointer move to next line
//echo fgets($file);
//echo "\n".fgets($file);

// Output one character until end-of-file
/*
while(!feof($file)) {
	echo fgetc($file);
}
*/

//fclose($file);
echo "<html><body>";
// What headers are to be sent?
//var_dump(headers_list());


echo "</body></html>";
?>