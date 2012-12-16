<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
</script> 
<script>
	function submit2(){
		$(' #frm2 ').submit();
	}
</script>
<script>
	function submit3(){
		$(' #frm3 ').submit();
	}
</script>
<?php 
if($_GET['action'] == 'view') { 

  redirect_page('index.php?p=user&user_id='.$_GET['user_id'].'&action=view');
}
if($_GET['action'] == 'accept') { 
  
  $update_accept="update ".TABLE_USERS." set user_type=1 where id=".$_GET['user_id'];
  $updatedone_ac=mysql_query($update_accept) or die(mysql_error());
  
  if($updatedone_ac) redirect_page('index.php?p=users');
}

if($_GET['act']=='mail' && $_GET['id']) {
         $user_select_token="select * from ".TABLE_USERS." where id =".$_GET['id'];
		 $user_select_srows=$obj_db->fetchRow($user_select_token);
		 
		 $update_broker="update ".TABLE_USERS." set broker_status=1 where id=".$_GET['id'];
		 $updatedone_bk=mysql_query($update_broker) or die(mysql_error());
		 
		 if($updatedone_bk) {
				$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; 
				border:1px dotted #cccccc;" bgcolor="#FFFFFF">
						<tr>
							<td style="padding-left:15px;">
								<img src="http://listingpockets.com/images/logo.png" border="0" />
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Dear '.$user_select_srows['first_name'].'&nbsp;'.$user_select_srows['last_name'].',</b>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:15px;line-height:25px;">
							
							<p>
							We apologize for the inconvenience, We were not able to verify your identity. If you have any questions/comments please do not hesitate to contact us at info@listingpockets.com or please call us at Phone no 866 226 9529

                             <br>
							Thank you ,<br>
							Listing Pockets Team <br>

							</p>
                         </td>
						
						</tr>
				</table>';		
				
				
				$From_Display = 'ListingPockets.com';
				$From_Email = ADMIN_EMAIL;
				$To_Email =$user_select_srows['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Activatation code for verifying Your Account';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
		 }
		 
		 $broker_email_update="update ".TABLE_USERS." set broker=1 where id =".$_GET['id'];
		 $broker_email_sent=$obj_db->get_qresult($broker_email_update);
		 
     redirect_page("index.php?p=users");
}
?>
<?php 
if($_GET['act']=='bs' && $_GET['id']) {
					$broker_select_query="select * from ".TABLE_USERS." where id =".$_GET['id'];
					$broker_select_srows=$obj_db->fetchRow($broker_select_query);
	if($_GET['bsid']==0)	{
		 $user_select_token="select * from ".TABLE_USERS." where id =".$_GET['id'];
		 $user_select_srows=$obj_db->fetchRow($user_select_token);
		 
		 $update_broker="update ".TABLE_USERS." set broker_status=1 where id=".$_GET['id'];
		 $updatedone_bk=mysql_query($update_broker) or die(mysql_error());
		 
		 if($updatedone_bk) {
				$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; 
				border:1px dotted #cccccc;" bgcolor="#FFFFFF">
						<tr>
							<td style="padding-left:15px;">
								<img src="http://listingpockets.com/images/logo.png" border="0" />
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Pockets</b>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:15px;line-height:25px;">
							<b style="font-size:18px;">Welcome to Listingpockets.com!</b><br>
							<p>Please take a moment to activate your account by clicking on the link below. If, for some reason, that doesn&acute;t work, please copy/paste 
						it in your browser&acute;s url field above.</p><br>

						<p>Please add this to our email</p><br>
						<p>Please activate your account here: <a href="http://www.listingpockets.com/verifyemail.php?token='.$user_select_srows['token'].'">
							http://www.listingpockets.com/verifyemail.php?token='.$user_select_srows['token'].'</a></p><br>

							<p>Remember to tell your colleagues and clients about our site, and please take a second to follow us on <br>
							http://twitter.com/listingpockets and be our friend on http://www.facebook.com/pocketlistings, so we can get your posts broadcast to a larger audience, <br>
							 and increase your chances of a successful sale!</p>
							<p>
							If you have any questions/comments please do not hesitate to contact us at info@listingpockets.com</p><br>						
							<p>May your pocket listings sell quickly, and your buyers find what they need!</p>
							<p>If you have any questions/comments please do not hesitate to contact us at info@listingpockets.com or please call us at Phone no 866 226 9529</p>
							
							Sincerely,
							The Listingpockets.com Team
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
				        <tr>
							<td style="padding:5px 5px;">
								<hr size="1" color="#CCCCCC"/>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
				</table>';		
				
				
				$From_Display = 'ListingPockets.com';
				$From_Email = ADMIN_EMAIL;
				$To_Email =$user_select_srows['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Activatation code for verifying Your Account';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
		 }
		 redirect_page("index.php?p=users");
		 
		 }
		 else {
		$update_broker="update ".TABLE_USERS." set broker_status=0 where id=".$_GET['id'];
		$updatedone_bk=mysql_query($update_broker) or die(mysql_error());
     } 
} ?>
<?php 
if($_GET['act']=='ap' && $_GET['id']) {
					$user_select_query="select * from ".TABLE_USERS." where id =".$_GET['id'];
					$user_select_srows=$obj_db->fetchRow($user_select_query);
	if($_GET['aid']==0)	{
		 $update="update ".TABLE_USERS." set acc_status=1 where id=".$_GET['id'];
		 $updatedone=mysql_query($update) or die(mysql_error());
		 if($updatedone) {
				$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; 
				border:1px dotted #cccccc;" bgcolor="#FFFFFF">
						<tr>
							<td style="padding-left:15px;">
								<img src="http://listingpockets.com/images/logo.png" border="0" />
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Pockets</b>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:15px;line-height:25px;">
							<b style="font-size:18px;">Welcome to Listingpockets.com!</b><br>
							<p>Please take a moment to activate your account by clicking on the link below. If, for some reason, that doesn&acute;t work, please copy/paste 
						it in your browser&acute;s url field above.</p><br>

						<p>Please add this to our email</p><br>
						<p>Please activate your account here: <a href="http://www.listingpockets.com/verifyemail.php?token='.$user_select_srows['token'].'">
							http://www.listingpockets.com/verifyemail.php?token='.$user_select_srows['token'].'</a></p><br>

							<p>Remember to tell your colleagues and clients about our site, and please take a second to follow us on <br>
							http://twitter.com/listingpockets and be our friend on http://www.facebook.com/pocketlistings, so we can get your posts broadcast to a larger audience, <br>
							 and increase your chances of a successful sale!</p>
							<p>
							If you have any questions/comments please do not hesitate to contact us at info@listingpockets.com</p><br>						
							<p>May your pocket listings sell quickly, and your buyers find what they need!</p>
							<p>If you have any questions/comments please do not hesitate to contact us at info@listingpockets.com or please call us at Phone no 866 226 9529</p>
							
							Sincerely,
							The Listingpockets.com Team
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
				        <tr>
							<td style="padding:5px 5px;">
								<hr size="1" color="#CCCCCC"/>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
				</table>';		
				
				
				$From_Display = 'ListingPockets.com';
				$From_Email = ADMIN_EMAIL;
				$To_Email =$user_select_srows['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Activatation code for verifying Your Account';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
		 }
	}
	else {
		$update="update ".TABLE_USERS." set acc_status=0 where id=".$_GET['id'];
		$udpatedone=mysql_query($update) or die(mysql_error());
		 if($updatedone) {
		 
		 }
	}
		
		redirect_page("index.php?p=users");
}

if($_GET['action'] == 'edit') { 

$user_select_query="select * from ".TABLE_USERS." where id=".$_GET['user_id'];
$data=$obj_db->fetchRow($user_select_query);

if(isset($_POST['btn_press_save'])) {
			$ermsg=array();
			//if(!strlen(trim($_POST['first_name']))) $ermsg[]="Enter first name.";
			//if(!strlen(trim($_POST['last_name'])) ) $ermsg[]="Enter Last Name.";
			if(count($ermsg)==0) {
				if($_POST['subscription'] == 1) $user_type = 1;
				if($_POST['subscription'] == 2) $user_type = 2;
				if($_POST['subscription'] == 3) $user_type = 1;
				if($_POST['subscription'] == 4) $user_type = 3;
				if($_POST['subscription'] == 5) $user_type = 2;
				if($_POST['subscription'] == 6) $user_type = 1;
				
					$notes_date = date("F j, Y, g:i a");
					
					$subject_insert_query="UPDATE ".TABLE_USERS." SET
					first_name='".$_POST['first_name']."',
					last_name='".$_POST['last_name']."',
					address='".$_POST['address']."',
					city='".$_POST['city']."',
					licenseno='".$_POST['licenseno']."',
					licensen_state='".$_POST['licensen_state']."',
					phone='".$_POST['phone']."',
					licensen_company='".$_POST['licensen_company']."',
					company_address='".$_POST['company_address']."',
					com_phno='".$_POST['com_phno']."',
					webaddress='".$_POST['webaddress']."',
					state='".$_POST['state']."',
					email='".$_POST['email']."',
					fax='".$_POST['fax']."',
					payment_date='".$_POST['payment_date']."',
					duration_days='".$_POST['duration_days']."',
					notes_date='".$notes_date."',
					facebooklink='".$_POST['facebooklink']."',
					twitterlink='".$_POST['twitterlink']."',
					googleplus='".$_POST['googleplus']."'
				    WHERE id=".$_GET['user_id'];
					$subject_insert_result=$obj_admin_db->get_qresult($subject_insert_query);
							if($_POST['notes']) 
							{
							// echo '<pre>'; print_r($_POST); echo '</pre>';
							    $subject_insert_notes="INSERT ".TABLE_NOTES." SET
					                    notes='".$_POST['notes']."',
										user_id='".$_GET['user_id']."',
										notes_type='account',
										notes_date='".$notes_date."',
										admin_name='".$_SESSION['alogname']."'";
								$subject_notes_result=$obj_admin_db->get_qresult($subject_insert_notes);
							}
							redirect_page("index.php?p=users");
			}							
}

?>
				<h2>Edit User</h2>
				<ul class="tabs">
					<!--<li><a href="index.php?p=corder&act=add" title="Products"><span>Add New</span></a></li>-->
					<li class="active"><a href="#" title="Details"><span>Edit</span></a></li>
				</ul>
				<div class="box">
				<form method="post" id="frm1">
				<fieldset>
				
					<label>First Name :</label>
					<span class="small_input"><input class="small" name="first_name" type="text" value="<?php echo htmlentities($data['first_name']);?>" /></span><br class="hid" />
					
					<label>Last Name :</label>
					<span class="small_input"><input class="small" name="last_name" type="text" value="<?php echo htmlentities($data['last_name']);?>" /></span><br class="hid" />
					
					<label>Address :</label>
					<span class="small_input"><input class="small" name="address" type="text" value="<?php echo htmlentities($data['address']);?>" /></span><br class="hid" />
					
					<label>City :</label>
					<span class="small_input"><input class="small" name="city" type="text" value="<?php echo htmlentities($data['city']);?>" /></span><br class="hid" />
					
					<?php if($data['subscription']==3 || $data['subscription']==6) {?>
					<label>license Number :</label>
					<span class="small_input"><input class="small" name="licenseno" type="text" value="<?php echo htmlentities($data['licenseno']);?>" /></span><br class="hid" />
					<label>licensed state :</label>
					<span class="small_input"><input class="small" name="licensen_state" type="text" value="<?php echo htmlentities($data['licensen_state']);?>" maxlength="2" /></span><br class="hid" />
					<?php } ?>
					<label>Phone :</label>
				<span class="small_input"><input class="small" name="phone" type="text" value="<?php echo htmlentities($data['phone']);?>" /></span><br class="hid" />
					
					<?php /*?><label>Subscription :</label>
					<select style="height:22px; border:1px solid grey; width:150px;" name="subscription">
					<option style="height:16px;" <?php if($data['subscription'] == 0) echo 'selected="selected"'; ?> value="0">Unverified</option>
					<option  style="height:16px;" <?php if($data['subscription'] == 4) echo 'selected="selected"'; ?> value="4">Free Membership</option>
					<option style="height:16px;" <?php if($data['subscription'] == 1) echo 'selected="selected"'; ?> value="1">Full Membership</option>
					<option  style="height:16px;" <?php if($data['subscription'] == 2) echo 'selected="selected"'; ?> value="2">Dual Membership</option>
					<option style="height:16px;" <?php if($data['subscription'] == 3) echo 'selected="selected"'; ?> value="3">Agent/Broker Membership</option>
					<option  style="height:16px;" <?php if($data['subscription'] == 5) echo 'selected="selected"'; ?> value="5">Investor/Banker</option>
					</select>
					
					<label>Category:</label>
					<select style="height:22px; border:1px solid grey; width:150px;" name="category">
					<option style="height:16px;" <?php if($data['category'] == 'Consumer') echo 'selected="selected"'; ?> value="Consumer">Consumer</option>
					<option  style="height:16px;" <?php if($data['category'] == 'Real Estate Agent/Broker') echo 'selected="selected"'; ?> value="Real Estate Agent/Broker">Real Estate Agent/Broker</option>
					</select><?php */?>
					
					<label>Licensen Company :</label>
				<span class="small_input"><input class="small" name="licensen_company" type="text" value="<?php echo htmlentities($data['licensen_company']);?>" /></span><br class="hid" />
					<label>Company Address :</label>
					<span class="small_input"><input class="small" name="company_address" type="text" value="<?php echo htmlentities($data['company_address']);?>" /></span><br class="hid" />
					<label>Company No :</label>
					<span class="small_input"><input class="small" name="com_phno" type="text" value="<?php echo htmlentities($data['com_phno']);?>" /></span><br class="hid" />
					<label>website :</label>
					<span class="small_input"><input class="small" name="webaddress" type="text" value="<?php echo htmlentities($data['webaddress']);?>" /></span><br class="hid" />
					<label>State :</label>
					<span class="small_input"><input class="small" name="state" type="text" value="<?php echo htmlentities($data['state']);?>" maxlength="2" /></span><br class="hid" />
					<label>Email :</label>
					<span class="small_input"><input class="small" name="email" type="text" value="<?php echo htmlentities($data['email']);?>" /></span><br class="hid" />
					<label>Fax :</label>
					<span class="small_input"><input class="small" name="fax" type="text" value="<?php echo htmlentities($data['fax']);?>" /></span><br class="hid" />
					<label>Payment Date :</label>
					<span class="small_input"><input class="small" name="payment_date" type="text" value="<?php echo htmlentities($data['payment_date']);?>" /></span><br class="hid" />
					
					<label>Twitter Profile Link :</label>
					<span class="small_input"><input class="small" name="twitterlink" type="text" value="<?php echo htmlentities($data['twitterlink']);?>" /></span><br class="hid" />
					<label>Facebook Profile Link :</label>
					<span class="small_input"><input class="small" name="facebooklink" type="text" value="<?php echo htmlentities($data['facebooklink']);?>" /></span><br class="hid" />
					<label>Google Plus Profile Link :</label>
					<span class="small_input"><input class="small" name="googleplus" type="text" value="<?php echo htmlentities($data['googleplus']);?>" /></span><br class="hid" />
					
					<label>Duration Days :</label>
					<span class="small_input"><input class="small" name="duration_days" type="text" value="<?php echo htmlentities($data['duration_days']);?>" /></span><br class="hid" />
					<label>Zip Codes of Agent:</label>
					<span class="small_input"><input class="small" name="zip_code" type="text" value="<?php echo htmlentities($data['zip_code']);?>" /></span><br class="hid" />
					<label>Account NOTES : </label>
					<span class="small_input"><input class="small" name="notes" type="text" value="" /></span><br class="hid" />  
					<label>Account NOTES : </label>
					<br /><br />
					<div style="width: 692px;height: 150px;overflow:-moz-scrollbars-vertical;overflow-y:auto; border:2px solid #0033FF;">
					 <span style="font-size:14px;">
					  <?php 
					    $user_select_acount="select * from ".TABLE_NOTES." where user_id ='".(int)$_GET['user_id']."' AND notes_type='account' ORDER BY id desc";
		                $user_select_srows=$obj_db->fetchNum($user_select_acount);
						$user_res_srows=$obj_db->get_qresult($user_select_acount);
						if(!$user_select_srows) echo 'No Account notes for this user';
						else {
						        $i=1;
								while($user_account=$obj_db->fetchArray($user_res_srows))
								{
								  echo $user_account['notes'].' - '.$user_account['notes_date'].'&nbsp;'.'By'.'&nbsp;'.$user_credit['admin_name'].'<br>'.'<br>';
								  $i++;
								}
						     }
					  ?>
					 </span><br class="hid" />  
					 </div>
					 <label>Credit NOTES : </label>
					 <br /><br />
					<div style="width: 692px;height: 150px;overflow:-moz-scrollbars-vertical;overflow-y:auto; border:2px solid #0033FF;">
					 <span style="font-size:14px;">
					  <?php 
					    $user_select_credit="select * from ".TABLE_NOTES." where user_id ='".(int)$_GET['user_id']."' AND notes_type='credit' ORDER BY id desc";
		                $user_select_srows1=$obj_db->fetchNum($user_select_credit);
						$user_res_srows1=$obj_db->get_qresult($user_select_credit);
						if(!$user_select_srows1) echo 'No Credit notes for this user';
						else {
						        $j=1;
								while($user_credit=$obj_db->fetchArray($user_res_srows1))
								{
								  echo $user_credit['notes'].' - '.$user_credit['notes_date'].'&nbsp;'.'By'.'&nbsp;'.$user_credit['admin_name'].'<br>'.'<br>';
								  $j++;
								}
						     }
					  ?>
					 </span><br class="hid" />  
					</div>
				<p>&nbsp;</p><input type="hidden" class="button1" name="btn_press_save" value="Update"  />
			
				<a href="javascript:void();" onclick="submit1();" class="button" title="Submit"><span>Submit</span></a>
			
				<span class="clear"></span>
				</fieldset>
				</div>	
		<?php if($ermsg){ 
				foreach($ermsg as $msg) { ?>
			
			<p class="alert">
				<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $msg;?></span>
				<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>
			</p>
			<?php } ?>
		<?php } ?>
				
<?php } else {
		$page_url = "index.php?p=users";
		if($_GET['act']=='del' && isset($_GET['user_id'])) {
		$delq="Delete from ".TABLE_USERS." where id=".$_GET['user_id'];
		$deld=mysql_query($delq);
			if($deld) redirect_page("index.php?p=users");
		} 
		
		if($_GET['sus']) {
		$user_select="select * from ".TABLE_USERS." where id =".(int)$_GET['sus'];
		$user_select_srows=$obj_db->fetchRow($user_select);
		
		$sus="Update ".TABLE_USERS." SET user_type=0 where id=".(int)$_GET['sus'];
		$suss=mysql_query($sus);
			if($suss) 
			{
			$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; 
				border:1px dotted #cccccc;" bgcolor="#FFFFFF">
						<tr>
							<td style="padding-left:15px;">
								<img src="http://listingpockets.com/images/logo.png" border="0" />
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Pockets</b>
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Dear '.$user_select_srows['first_name'].' &nbsp; '.$user_select_srows['last_name'].'</b>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:15px;line-height:25px;">
							<b style="font-size:18px;">Welcome to Listingpockets.com!</b><br>
							<p>Your account has been suspended  because of 
							1.Posted a fictitious add (or)
							2.Payment method was not able to be verified (or)
							3.Fraud (or)
							4.Mischievous Activities.

							 So please contact Suspended@ListingPockets.com .</p><br>
							 <p>If you have any questions/comments please do not hesitate to contact us at info@listingpockets.com or please call us at Phone no 866 226 9529</p>
						
							Sincerely,
							The Listingpockets.com Team
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
				        <tr>
							<td style="padding:5px 5px;">
								<hr size="1" color="#CCCCCC"/>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
				</table>';		
				
				
				$From_Display = 'ListingPockets.com';
				$From_Email = ADMIN_EMAIL;
				$To_Email =$user_select_srows['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Problems with Your Account';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
			
			 redirect_page("index.php?p=users");
			}
		} 
		
		?>
		<?php if($errmsg){?>
			<p class="alert">
				<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $errmsg;?></span>
				<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>
			</p>
		<?php } ?>
				<h2>Registered Users</h2>
				<ul class="tabs">
	<li class="<?php if(($_GET['p']=='users') && (!$_GET['tab'])) echo "active"; else echo "";?>"><a href="index.php?p=users&act=<?php echo $_GET['act']; ?>" title="Details"><span>Both</span></a></li>
	<li class="<?php if(($_GET['p']=='users') && ($_GET['tab']=='active')) echo "active"; else echo "";?>"><a href="index.php?p=users&act=<?php echo $_GET['act']; ?>&tab=active" title="Details"><span>Active</span></a></li>
	<li class="<?php if(($_GET['p']=='users') && ($_GET['tab']=='susp')) echo "active"; else echo "";?>"><a href="index.php?p=users&act=<?php echo $_GET['act']; ?>&tab=susp" title="Details"><span>Suspended</span></a></li>				
				</ul>
				<div class="box">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="">
					<tr>
					 <td><a href="index.php?p=users">All</a></td>
					 <td colspan="2">
					   <a href="index.php?p=users&act=broker">Broker / Agent</a> | 
					  ( <a href="index.php?p=users&act=broker&tab=new">New Registration</a> )
					 </td>
					 <td><a href="index.php?p=users&act=dual">Dual Membership</a></td>
					 <td><a href="index.php?p=users&act=full">Full Membership</a></td>
					 <td><a href="index.php?p=users&act=investor">Investor/Bank Membership</a></td>
					 <td><a href="index.php?p=users&act=free">Free Membership</a></td>
					</tr>
					<form method="post" id="frm1" action="<?php $page_url2;?>">
					<tr>
						<td colspan="7" align="left">
						  <table width="100%">
						   
						<td align="left" style="width:348px;">
							<input class="small" name="page_search" type="text" onfocus="this.value=''" onblur="if(this.value=='') this.value='Enter Email OR Name' " <?php if($_POST['page_search']) { ?>value="<?php echo $_POST['page_search']; ?>" <?php } else { ?>value="Enter Email OR Name" <?php } ?>/>&nbsp;&nbsp;&nbsp;
							  <select name="user_select" style="border:1px solid #000000;">
							    <option value="Active" <?php if($_POST['user_select']=='Active') echo 'selected="selected"'; ?>>Active</option>
								<option value="Suspend" <?php if($_POST['user_select']=='Suspend') echo 'selected="selected"'; ?>>Suspend</option>
								<option value="Both" <?php if($_POST['user_select']=='Both') echo 'selected="selected"'; ?>>Both</option>
							  </select>
							</td>
							<td>
							<input type="hidden" class="button1" name="but_search" value="Search"  />
							
							<a href="javascript:void();" onclick="$('#frm1').submit();" class="button" title="Submit"><span>Search</span></a>
							<br/>	
							</td>
							</tr>
						  </table>
						</td>
					</tr>
					 </form>
				<?php
					if($_POST['page_search']) 
						$skey=stripslashes($_POST['page_search']);
					else if($_GET['s']) {	
						$skey=stripslashes($_GET['s']);
						$skey = str_replace("+"," ",$skey);
					}	
					
					if($skey) {
						$sq=" and email like '%".mysql_real_escape_string($skey)."%' ";
						$s = str_replace(" ","+",$skey);							  
						$page_url .="&s=".$s;
					}
							if($_POST['but_search']) { 
							  if($_POST['user_select']=='Active') {
							$user_select_query="select * from ".TABLE_USERS." where (first_name like '%".$_POST['page_search']."%' OR last_name like '%".$_POST['page_search']."%' OR email='".$_POST['page_search']."') AND acc_status=1 order by id desc"; 
							} elseif($_POST['user_select']=='Suspend') {
							$user_select_query="select * from ".TABLE_USERS." where (first_name like '%".$_POST['page_search']."%' OR last_name like '%".$_POST['page_search']."%' OR email='".$_POST['page_search']."') AND acc_status=0 order by id desc";
							} else {
							$user_select_query="select * from ".TABLE_USERS." where  ( first_name like '%".$_POST['page_search']."%' OR last_name like '%".$_POST['page_search']."%' OR email='".$_POST['page_search']."' ) order by id desc";
							}  
							} else {
							
							if(($_GET['p']=='users') && ($_GET['act']=='dual')) {
								  if($_GET['tab']=='active') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=2 AND acc_status=1 order by id desc";  }
								  elseif($_GET['tab']=='susp') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=2 AND acc_status=0 order by id desc";  }
								  else $user_select_query="select * from ".TABLE_USERS." $sq where subscription=2 order by id desc"; 
								  }
							 elseif(($_GET['p']=='users') && ($_GET['act']=='broker')) {
								  if($_GET['tab']=='active') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=3 AND acc_status=1 order by id desc";  }
								  elseif($_GET['tab']=='susp') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=3 AND acc_status=0 order by id desc";  }
								  elseif($_GET['tab']=='new') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=3 AND acc_status=0 AND broker_status=0 order by id desc";  }
								  

								  if($_GET['tab']=='active') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=6 AND acc_status=1 order by id desc";  }
								  elseif($_GET['tab']=='susp') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=6 AND acc_status=0 order by id desc";  }
								  elseif($_GET['tab']=='new') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=6 AND acc_status=0 AND broker_status=0 order by id desc";  }								  
								  
								  else $user_select_query="select * from ".TABLE_USERS." $sq where subscription=6 order by id desc"; 
								  }
							
							 elseif(($_GET['p']=='users') && ($_GET['act']=='full')) {
							      if($_GET['tab']=='active') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=1 AND acc_status=1 order by id desc";  }
								  elseif($_GET['tab']=='susp') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=1 AND acc_status=0 order by id desc";  }
								  else $user_select_query="select * from ".TABLE_USERS." $sq where subscription=1 order by id desc"; 
							     }
							 elseif(($_GET['p']=='users') && ($_GET['act']=='investor')) {
							      if($_GET['tab']=='active') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=5 AND acc_status=1 order by id desc";  }
								  elseif($_GET['tab']=='susp') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=5 AND acc_status=0 order by id desc";  }
								  else $user_select_query="select * from ".TABLE_USERS." $sq where subscription=5 order by id desc";
							     }
							 elseif(($_GET['p']=='users') && ($_GET['act']=='free')) {
							      if($_GET['tab']=='active') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=4 AND acc_status=1 order by id desc";  }
								  elseif($_GET['tab']=='susp') { $user_select_query="select * from ".TABLE_USERS." $sq where subscription=4 AND acc_status=0 order by id desc";  }
								  else $user_select_query="select * from ".TABLE_USERS." $sq where subscription=4 order by id desc";
							     }
							else { $user_select_query="select * from ".TABLE_USERS." $sq where paid=1 order by id desc"; }
							}
							$user_select_srows=$obj_db->fetchNum($user_select_query);
							if(!$user_select_srows) {										
						?>
						<br class="hid" />
						<tr>
							<td height="25px" colspan="2" align="center" class="error">
								<b >No Users.</b>
							</td>
						</tr>
						<?php } ?>
						<?php if($user_select_srows) { ?>
						<tr>
							<td style="text-align:center">
							<strong>	S.No</strong>
							</td>
							<td style="text-align:center">
								<strong>Full Name</strong>
							</td>
							<td style="text-align:center">
								<strong>Email</strong>
							</td>
							<td style="text-align:center">
								<strong>Subscription</strong>
							</td>
							<td style="text-align:center" width="50px">
							<strong>Account Status</strong>
							</td>
							<td style="text-align:center">
								<strong>Suspend Account</strong>
							</td>

							<td style="text-align:center">
								<strong>Action</strong>
							</td>
						</tr>
							<?php //PAGE NUMBERS USAGE
								$PageNos_Navigation = array("First_Last_Links"=>1, 
															"Page_Navigator"=>"page", 
															"Total_Records"=>$user_select_srows, 
															"Records_PerPage"=>20, 
															"Page_Numbers"=>10, 
															"Page_url"=>$page_url, 
															"css_class"=>"link", 
													);
								
								get_pageno_numbers();	
								$StartCount = $PageNos_Navigation["StartCount"]; 
								$PerPage = $PageNos_Navigation["Records_PerPage"];
								
								$j=(int)$StartCount+1;
								$i=0;	
								$notds=3;
								$user_select_query.=" LIMIT $StartCount, $PerPage ";					
								$user_select_res=$obj_db->get_qresult($user_select_query);
							?>  
								<?php $j=0;
								while($user_select_rows=$obj_db->fetchArray($user_select_res)) {
									extract($user_select_rows);
									$user_select_rows = remove_slashes($user_select_rows);
									$i++;
						?>
						<tr>
							<td style="text-align:center">
								<?php echo $i;?>
							</td>
							<td style="text-align:center">
								<a href="<?php echo $page_url;?>&user_id=<?php echo $user_select_rows['id'];?>&action=edit"><?php echo $user_select_rows['first_name'].' '.$user_select_rows['last_name'];?></a>
							</td>
							
							<td width="160px" style="text-align:center">
								<?php echo $user_select_rows['email'];?>
							</td>
							<td style="text-align:center;<?php if($user_select_rows['subscription'] == 3 ) echo 'color:#FF0000;';?>">
											<?php if($user_select_rows['subscription'] == 1 ) echo 'Full Membership';
												   elseif($user_select_rows['subscription'] == 2 ) echo 'Dual Membership'; 
												   		elseif($user_select_rows['subscription'] == 4 ) echo 'Free Posting Membership'; 
															elseif($user_select_rows['subscription'] == 3 || $user_select_rows['subscription'] == 6 ) //{ 
															echo 'Agents/Borker Membership'.'&nbsp;'; 
															 ?>
																<?php /*if($user_select_rows['broker']==0) { ?>
																<a href="index.php?p=users&act=mail&id=<?php echo $user_select_rows['id'];?>">Send Mail</a>
																<?php } else { echo 'Sent'; ?><br />
																<a href="index.php?p=users&act=mail&id=<?php echo $user_select_rows['id'];?>">ReSend Mail</a>
																<?php } ?>
																<br /><br /><?php echo $user_select_rows['joindate']; ?>
															<?php
															   }
															   elseif($user_select_rows['subscription'] == 5 ) echo 'Investor/Banker';
																 else echo 'Free member Search &nbsp;'; */?>	
							</td>
							<td style="text-align:center">
							<a href="index.php?p=users&act=ap&aid=<?php echo $user_select_rows['acc_status'];?>&id=<?php echo $user_select_rows['id'];?>">
							<?php if($user_select_rows['acc_status']==0) { ?>
								<img style="height:15px; width:15px;" src="images/C1.png" />
							<?php } else { ?>
									<img style="height:15px; width:15px;" src="images/C2.png" />
							<?php } ?></a>
						  </td>
							<td>
							<?php if($user_select_rows['user_type']==0) echo '<a href="index.php?p=users&user_id='.$user_select_rows['id'].'&action=accept">Accept user</a>'; else echo '<a href="index.php?p=users&sus='.$user_select_rows['id'].'">Suspend user</a>'; ?>
							</td>
							
							<td style="text-align:center">
							
								<?php if($user_select_rows['subscription'] == 3 || $user_select_rows['subscription'] == 6) { ?>
								<a href="index.php?p=users&action=view&user_id=<?php echo $user_select_rows['id'];?>" class="link">View</a> | <?php } ?>
								<a href="index.php?p=users&act=del&user_id=<?php echo $user_select_rows['id'];?>" class="link" onclick="if(!confirm('Are you sure to delete this User?')) return false;">Delete</a>
							</td>
                            
							<td style="text-align:center;<?php if($user_select_rows['subscription'] == 3 ) echo 'color:#FF0000;';?>">
											<?php if($user_select_rows['subscription'] == 3 || $user_select_rows['subscription'] == 6 ) { 
															 ?>
																<?php if($user_select_rows['broker']==0) { ?>
																<a href="index.php?p=users&act=mail&id=<?php echo $user_select_rows['id'];?>">Send Mail</a>
																<?php } else { echo 'Sent'; ?><br />
																<a href="index.php?p=users&act=mail&id=<?php echo $user_select_rows['id'];?>">ReSend Mail</a>
																<?php } ?>
																<br /><br /><?php echo $user_select_rows['joindate']; ?>
															<?php } ?>

                            
						</tr>
						<?php } //while end 
							//page number display
							if((int)$PageNos_Navigation["Total_Pages"] > 1) {
						?>
						<tr>
							<td  style="border:0px solid #CCCCCC; text-align:center"  colspan="7" bgcolor="#FFFFFF">			
								<?php display_pagenumbers(); ?>
							</td>
						</tr>
						<?php }} //if end ?>
					</table>
				</div>
   <?php } ?>			