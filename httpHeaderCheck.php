<?php 

/* 
 * Resend the Header after the file request
 */

 //check any download or view request 
 
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//collect the input data
	$file_id = $_REQUEST['form1'];
	// stupid but for readbility, can be dome form_data($_REQUEST['form1'];
	$file_id = form_data($file_id);
	$req_method = $_REQUEST['reqM'];
	$req_method = form_data($req_method);
	
	// allow a file to be streamed instead of sent as an attachment
	$is_attachment = ($req_method=="dwn") ? true : false;
	
	//check the collect value. if the If statement is not empty then execute if
	if(!empty($file_id)){
		//check the id in db in conjunction with user session. implement pending
		$file = "/var/www/annual_report_2009.pdf";
		if (file_exists($file)){
			
			//- turn off compression on the server
			@apache_setenv('no-gzip', 1);
			@ini_set('zlib.output_compression', 'Off');
			// set the headers, prevent caching
			header("Pragma: no-cache");
			header("Expires: -1");
			header("Cache-Control: no-cache, must-revalidate,no-store,post-check=0, pre-check=0");
			header("Content-Length:". filesize($file));
			header("Content-type:application/pdf");
			
			//checl if it download or view
			if($is_attachment)
				header('Content-Disposition: attachment; filename='.basename($file));
			else 
				header('Content-Disposition: inline; filename='.basename($file)); // inline for view
					
				
			$isread_Sucess = readfile($file);
			if(!$isread_Sucess){
				// file couldn't be opened
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		
			//ob_end_clean();//required here or large files will not work
			//fpassthru($file);//works fine now
		
		}
		else {
			// file does not exist
			header("HTTP/1.0 404 Not Found");
			echo "file not found. please try again";
			
		}
	}
	else{
		
	   //input value is empty
	}
}
else 
{
	//not a post method,
}


/*
 * @name form_data
 * @description Form input data validation 
 * @return sanitize data
 */

function form_data ($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>

<html>
<head>
<title>header resend</title>
</head>
<body>
	<h3>here is the form that you bought</h3>
	Apartment Rent/Release Form
	<form action=<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']);?> method="post" target="_self">
		<input type="hidden" name="form1" value="1235234234">
		<input type="hidden" name="reqM" value="dwn">
		<input type="image" src="download-png.png" >
	</form>
	<form action=<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']);?> method="post" target="_self">
		<input type="hidden" name="form1" value="1235234234">
		<input type="hidden" name="reqM" value="inline">
		<input type="image" src="pdf-icon-1.png">
	</form>
</body>
</html>