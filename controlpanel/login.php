<?php



	session_start();

	require_once("../includes/DbConfig.php");

	require_once("../includes/classes/general.php");



	

	if(isset($_POST['btn_login'])) 	{				



		extract($_POST);



		



		$_POST = remove_slashes($_POST);



		$ermsg="";



		if(!strlen(trim($_POST[lusername]))) $ermsg="* Enter Username.<br>";



		if(!strlen(trim($_POST[lpword]))) $ermsg.="* Enter Password<br>";		



		if($ermsg==""){



			$obj_admin_db = new db();



			$obj_admin_db->open_connection();



			$admin_sel_query="SELECT * FROM ".TABLE_ADMINISTRATOR." WHERE admin_user='".mysql_escape_string(trim($_POST[lusername]))."' AND admin_opword='".trim($_POST[lpword])."'";



			$admin_sel_row = $obj_admin_db->fetchRow($admin_sel_query);



			$obj_admin_db->close_connection();



			if($admin_sel_row)	{				

				

				$_SESSION['alogname']=$admin_sel_row[admin_user];

				$_SESSION['logger']=$admin_sel_row[admin_perm];
				
				$_SESSION['logger_id']=$admin_sel_row['id'];
				
				$_SESSION['logger_tasks']=explode(',',$admin_sel_row['tasks']);



				header("location: http://www.listingpockets.com/controlpanel/index.php?p=ads");



			}  else $ermsg="Invalid Username or Password";						



		}	



	}	



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title><?php echo SITE_NAME;?> -  Administrator</title>



<script type="text/javascript" src="../js/pngfix.js"></script>



<link href="style.css" rel="stylesheet" type="text/css" />



</head>



<body style="margin:0px 0px 0px 0px;" onload="document.flogin.lusername.focus();">







<form method="post" name="flogin">



	  <table border="0" cellpadding="0" cellspacing="0" width="500px" align="center">



				<tr>



				   <td height="180px">&nbsp;</td>



				</tr>



				<tr>



					



					<td valign="top" width="977px">



						<table border="0" cellpadding="0" cellspacing="0" width="977px" align="center" class="logbg">



								



								<tr>



									<td valign="top" style="padding-top:0px;">



										<table border="0" cellpadding="2" cellspacing="0" width="300px" align="right">



												



												<tr height="85x">

												   <td>&nbsp;</td>

												</tr>



												



												<tr>



													



													<td align="left" style="padding-top:5px;" class="text4">



														<b>Username</b>



													</td>



												</tr>



												<tr>



													<td valign="top"  >



														 <table border="0" cellpadding="0" cellspacing="0" class="ubox1" width="100%">

														    <tr>

															   <td style="padding-top:6px;"><input type="text" class="ubox" name="lusername" 



														value="<?php echo stripcslashes(trim($_POST['lusername']));?>" tabindex="0" /></td>

															</tr>

														 </table>



													</td>



												</tr>



												<tr>



													<td align="left" class="text4">



														<b>Password</b>



													</td>



												</tr>



												<tr>



													<td valign="top">

													 <table border="0" cellpadding="0" cellspacing="0"  class="ubox1">

													      <tr>

														     <td style="padding-top:6px;"><input type="password" class="ubox" name="lpword" id="lpword"    



														value="<?php echo stripcslashes(trim($_POST['lpword']));?>" />

</td>

														  </tr>

													 </table>



														

													</td>



												</tr>



												<tr>



													<td height="25px">&nbsp;

														 



													</td>



												</tr>



												<tr>



													<td align="right" style="padding-right:40px;" >



													<table border="0" cellpadding="0" cellspacing="0" width="100%">

													    <tr>

														<td class="error"><?php echo $ermsg;?></td>

														    <td align="right">	<input type="submit" name="btn_login" value="" class="buttonLogin" /></td>

														</tr>

													</table>



													</td>



												</tr>



												

												



										</table>



									</td>



								</tr>



								  



						</table>



					</td>



					



				</tr>



			

				



				<tr>



					<td valign="top" align="center" style="padding-top:80px; color:#666;">



						&nbsp;



						Copyright © 2011 • All rights reserved.



					</td>



				</tr>



		</table>     



</form>



</body>