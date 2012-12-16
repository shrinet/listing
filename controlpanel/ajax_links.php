<?php       require_once("../includes/DbConfig.php");
			require_once("../includes/general.php");
								 
		  if(isset($_POST['btn_popup_users'])) {
		  
		  $msge='<table width="700" border="0" cellspacing="3" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><tr><td width="22%" align="left" valign="top" colspan="2"><img src="http://listingpockets.com/images/logo.png" height="100px" width="230px"></td></tr><tr><td width="22%" align="left" valign="top">Content:</td><td width="76%" align="left">'.stripslashes($_POST['popup_mail_content']).'</td></tr></table>';	      
		   
		   foreach($_POST["users_popup_mail"] as $popup_mail){

			$From_Display = "Listing Pockets";
			$From_Email = "donotreply@listingpockets.com";
			$To_Email =$popup_mail;
			$CC = "";
			$BCC = "";
			$Sub = "Listing Pockets";
			$Message = $msge;
			$Format = 1;
			$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
			
			} $mmsg="Emails sent to Users!";
		  
		  }
?>