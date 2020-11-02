<?php
header('Content-Type: application/json; charset=utf-8');   
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
include 'apiConfig.php';
  $con =mysqli_connect($host,$user, $password,$dbname,$port); 
	if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
	require_once('class/class.smtp.php');
    require_once('class/class.phpmailer.php');
	
	 
$userName=$_POST['userName'];
$userMail=$_POST['userMail'];
$userComments=$_POST['userComments'];   
$usertype="user";
//email content starts
$response=array();
 
 
    $mail = new PHPMailer();
 
	 $mail->Mailer = "smtp";
    $mail->Host = 'smtp.office365.com';//'smtp.gmail.com'; //'smtpout.asia.secureserver.net'; 
    $mail->Port =  587;
    $mail->SMTPAuth = true;  
    $mail->Username = "mani95ram@outlook.com"; 
    $mail->Password =  "MA1995ni"; 
 
    $mail->SMTPSecure =  'tls';   
	

    $mail->SetFrom('mani95ram@outlook.com', 'Manikandan Ramalingam'); 

    $mail->Subject = "RE : Thank you Mail - Manikandan R ";
	
       
    $mail->AddAddress($userMail,$userName);
	// email content end

	  
					 $sql = "insert into tbl_portfolio_comments(`username`,`emailid`,`comments`,`dateat`,`timeat`,`sstatus`) values ( '$userName','$userMail','$userComments',curdate(),now(),'i');";
				 
					$result = mysqli_query($con,$sql);
					
					if (!$result)
					{
					  echo mysqli_error($con);
					}      
					else
					{
						  
								$body='<html>
								<head>
								<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<title>Thank You - Message</title>
								</head>
								<body style="background-color:powderblue; padding:30px">
								<div style="border:1px solid #ccc!important;border-radius:16px;background-color:white">
								<blockquote>
								 <center><h1  style="color:MediumSeaGreen;font-family: Arial Rounded MT" >Thank You </h1>
								 <br/>
								 <h3 style="font-family: Arial Rounded MT;color:#4285F5"> Hi <b style="color:Tomato">'.$userName.'</b>, Thank you for leaving your valuable comments.</h3>
								</center>
								<hr/> 
									<div style="border-style: outset;">'.$userComments.'</div>
								  
									<br/>
								 	Thanks & Regards <br/> Manikandan R, <br/> Software developer.
								</blockquote>
							
								</div>

								</body>
								</html>';
				 
				 
				 
				 
								$body = preg_replace("[\\\]",'',$body);
								$mail->MsgHTML($body);
								 
								 
								 if ($mail->Send()) 
								{
									$response["success"] = 1;
									$response["message"] = "Successfully Added";
								}
								else
								{
										$response["success"] = 0;
										$response["message"] = $mail->ErrorInfo;
								}
						
						
					}
 
 

	 
		echo json_encode($response);
		 
?>
