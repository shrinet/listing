<?php	session_start();	
	//provider Other experiences details
	class customer {
		
		//data from page
		function set_page_data($udata) {
			return $udata;
		}
		
		function check_mail($data) {
			if(!strlen(trim($data[name]))) $ermsg.="Enter name<br>";
			if(!strlen(trim($data[e_mail]))) $ermsg.="Enter Email<br>";
			elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $data[e_mail]))
				$ermsg.="E-mail adress appeares to be incorrect<br>";
			if(!strlen(trim($data[message]))) $ermsg.="Enter message<br>";
			if(!strlen(trim($data[security]))) $ermsg.="Enter captcha<br>";
			// else if(!$captcha->validate_submit($data['vk_user_rndcode'],$data['security']))  $ermsg.="Captcha not matching";
			$data['error']=$ermsg;	
			return $data;
		}
		
		
		//validations 
		
		function check_payments($data) {
		
			$ermsg="";
			global $obj_admin_db, $captcha;
			if($data[sub_total]>$data[credit]) {
			  if(!strlen(trim($data[card_type]))) $ermsg.="Select Credit Card<br>";
			}
			if(!strlen(trim($data[first_name])) || !strlen(trim($data[last_name])) || !strlen(trim($data[address])) || !strlen(trim($data[city])) || !strlen(trim($data[state])) || !strlen(trim($data[zip])) || !strlen(trim($data[zip])) || !strlen(trim($data[phone]))) $ermsg.="Enter Billing Address";
			$data['error']=$ermsg;	
			return $data;
		}
		
		function check_payment($data) {
		
			$ermsg="";
			global $obj_admin_db, $captcha;
			if($_SESSION['sub_total']>$_SESSION['credit']) {
			if(!strlen(trim($data[creditcardnumber]))) $ermsg.="Enter Credit Card Number<br>";
			if(!strlen(trim($data[card_type]))) $ermsg.="Select Card Type<br>";
			if(!strlen(trim($data[card_expire_month]))) $ermsg.="Select Card Expiry Month<br>";
			if(!strlen(trim($data[card_expire_year]))) $ermsg.="Select Card Expiry Year<br>";
			if(!strlen(trim($data[card_security_code]))) $ermsg.="Select Card Security Code<br>";
			if(!strlen(trim($data[account_name]))) $ermsg.="Enter Card Holder Name<br>";
			}
			if(!strlen(trim($data[first_name])) || !strlen(trim($data[last_name])) || !strlen(trim($data[address])) || !strlen(trim($data[city])) || !strlen(trim($data[state])) || !strlen(trim($data[zip])) || !strlen(trim($data[zip])) || !strlen(trim($data[phone]))) $ermsg.="Enter Billing Address";
			$data['error']=$ermsg;	
			return $data;
		}
			function check_upgradepayment($data) {
			$ermsg="";
			global $obj_admin_db, $captcha;
			if(!strlen(trim($data[sub]))) $ermsg.="Select Subscription plan<br>";
			if(!strlen(trim($data[creditcardnumber]))) $ermsg.="Enter Credit Card Number<br>";
			if(!strlen(trim($data[card_type]))) $ermsg.="Select Card Type<br>";
			if(!strlen(trim($data[card_expire_month]))) $ermsg.="Select Card Expir Month<br>";
			if(!strlen(trim($data[card_expire_year]))) $ermsg.="Select Card Expir Year<br>";
			if(!strlen(trim($data[card_security_code]))) $ermsg.="Select Card Security Code<br>";
			$data['error']=$ermsg;	
			return $data;
		}
		
		
		
		
		function check_giftcard($data) {
		
			$ermsg="";
			global $obj_admin_db, $captcha;
			
			  if(!strlen(trim($data[creditcardnumber]))) $ermsg.="Enter Credit Card Number<br>";
			  if(!strlen(trim($data[card_type]))) $ermsg.="Select Card Type<br>";
			  if(!strlen(trim($data[card_expire_month]))) $ermsg.="Select Card Expir Month<br>";
			  if(!strlen(trim($data[card_expire_year]))) $ermsg.="Select Card Expir Year<br>";
			  if(!strlen(trim($data[card_security_code]))) $ermsg.="Select Card Security Code<br>";
			  if(!strlen(trim($data[account_name]))) $ermsg.="Enter name on card<br>";
			  
			
			$data['error']=$ermsg;	
			return $data;
		}

		
//validations 
			function check_data_withoutsub($data) {
				$ermsg="";
				if(!strlen(trim($data[sub]))) $ermsg.="Select membership<br>";
			$data['error']=$ermsg;	
			return $data;
		}
		
			
			function check_data_withoutc($data) {
				$ermsg="";
				global $obj_admin_db, $captcha;
				//if(!strlen(trim($data[sub]))) $ermsg.="Select membership<br>";
if(!strlen(trim($data[first_name]))) $ermsg.="Enter First name<br>";
			if(!strlen(trim($data[last_name]))) $ermsg.="Enter Last name<br>";
			if($data['agent']=='yes') { if(!strlen(trim($data[licenseno]))) $ermsg.="Enter License Number<br>"; }
			if(!strlen(trim($data[password]))) $ermsg.="Enter Password<br>";
			//if(!strlen(trim($data[sub]))) $ermsg.="Select membership<br>";
			if(strlen(trim($data[password])) <> strlen(trim($data[passwordc]))) $ermsg.="Password doesn't Match<br>";
			
			//if(!strlen(trim($data[state]))) $ermsg.="Select state<br>";
			//if(!strlen(trim($data[category]))) $ermsg.="Select Category.<br>";
			
			if(!strlen(trim($data[licenseno]))) $ermsg.="Enter lisence no<br>";
			if(!strlen(trim($data[licensestate]))) $ermsg.="Enter state<br>";
			
			if(!strlen(trim($data[email]))) $ermsg.="Enter e-mail adress<br>";
			elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $data[email]))
				$ermsg.="E-mail adress appeares to be incorrect<br>"; 	
			else 
			{
				$customer_select_query="SELECT * FROM ".TABLE_USERS." WHERE email='".strtolower(trim(stripslashes($data[email])))."'";
				$customer_select_urow=$obj_admin_db->fetchRow($customer_select_query);
				if($customer_select_urow) $ermsg.="* E-mail address already exists<br>";					
			}	
						
			if(!strlen(trim($data[vk_user_rcode]))) $ermsg.="Enter captcha<br>";
			else if(!$captcha->validate_submit($data['vk_user_rndcode'],$data['vk_user_rcode']))  $ermsg.="Incorrect Security Check";
							
			$data['error']=$ermsg;	
			return $data;
		}
		
		
		function check_data_withoutcc($data) {
			$ermsg="";
			global $obj_admin_db, $captcha;
			
			if(!strlen(trim($data[first_name]))) $ermsg.="Enter First name<br>";
			if(!strlen(trim($data[last_name]))) $ermsg.="Enter Last name<br>";
			if($data['agent']=='yes') { if(!strlen(trim($data[licenseno]))) $ermsg.="Enter License Number<br>"; }
			if(!strlen(trim($data[password]))) $ermsg.="Enter Password<br>";
			//if(!strlen(trim($data[sub]))) $ermsg.="Select membership<br>";
			if(strlen(trim($data[password])) <> strlen(trim($data[passwordc]))) $ermsg.="Password doesn't Match<br>";
			
			//if(!strlen(trim($data[state]))) $ermsg.="Select state<br>";
			//if(!strlen(trim($data[category]))) $ermsg.="Select Category.<br>";
			
			//if(!strlen(trim($data[licenseno]))) $ermsg.="Enter lisence no<br>";
			//if(!strlen(trim($data[licensestate]))) $ermsg.="Enter state<br>";
			
			if(!strlen(trim($data[email]))) $ermsg.="Enter e-mail adress<br>";
			elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $data[email]))
				$ermsg.="E-mail adress appeares to be incorrect<br>"; 	
			else 
			{
				$customer_select_query="SELECT * FROM ".TABLE_USERS." WHERE email='".strtolower(trim(stripslashes($data[email])))."'";
				$customer_select_urow=$obj_admin_db->fetchRow($customer_select_query);
				if($customer_select_urow) $ermsg.="* E-mail address already exists<br>";					
			}	
						
			if(!strlen(trim($data[vk_user_rcode]))) $ermsg.="Enter captcha<br>";
			else if(!$captcha->validate_submit($data['vk_user_rndcode'],$data['vk_user_rcode']))  $ermsg.="Incorrect Security Check";
			
			$data['error']=$ermsg;	
			return $data;
		}
		
		// payment option
		function update_payment($data,$user_type,$id) {
			global $obj_admin_db;
			$category="Consumer";
			
			$change_account="select * from ".TABLE_USERS." where id=".$_SESSION['user_log_id'];
	        $change_account_data = $obj_admin_db->fetchRow($change_account);
			
			if($change_account_data['subscription']==1) $from_account='Switched From Full Member';
			elseif($change_account_data['subscription']==2) $from_account='Switched From Dual Member';
			elseif($change_account_data['subscription']==3) $from_account='Switched From Agent/Broker Member';
			elseif($change_account_data['subscription']==4) $from_account='Switched From Free Member';
			elseif($change_account_data['subscription']==5) $from_account='Switched From Investor/Broker Member';
			
			
			if($data[sub] == 1) $to_account=' To Full Member';
			elseif($data[sub] == 2) $to_account=' To Dual Member';
			elseif($data[sub] == 3) $to_account=' To Agent/Broker Member';
			elseif($data[sub] == 4) $to_account=' To Free Member';
			elseif($data[sub] == 5) $to_account=' To Investor/Broker Member';
			
			$explination=$from_account.$to_account;
			
			if($data[sub] == 3) {
				$category=""; 
				$bmsg="<p>Once we verify your real estate license and license status, we will send you a confirmation email separate from this one.
				We were usually pretty quick, but license verification may take up to 24 hours.</p><br>";
				$cq=" category='Agent/Broker', ";
			}	
			
			
			//insertion to table
			$order_insert_query="INSERT INTO ".TABLE_ORDERS." SET 
			card_type='".$data['card_type']."',
			amount='".$data['total']."',
			explination='".$explination."',
			total_amount='".stripslashes($data['total'])."',
			credit_balance= '".stripslashes($data['credit'])."',
			user_id='".$_SESSION['user_log_id']."'";
			$order_insert_result=$obj_admin_db->get_qresult($order_insert_query);
			$invoice=mysql_insert_id();
			
			$subject_insert_query="Update ".TABLE_USERS." SET 
			card_type='".$data['card_type']."',
			card_expire_month='".$data['card_expire_month']."',
			card_expire_year='".$data['card_expire_year']."',
			card_security_code='".$data['card_security_code']."',
			billing_first_name = '".stripslashes($data['first_name'])."',
			billing_last_name = '".stripslashes($data['last_name'])."',
			address = '".stripslashes($data['address'])."',
			billing_address = '".stripslashes($data['address'])."',
			billing_city = '".stripslashes($data['city'])."',
			billing_state = '".stripslashes($data['state'])."',
			billing_zip = '".stripslashes($data['zip'])."',
			billing_phone = '".stripslashes($data['phone'])."',
			total_days= '".stripslashes($data['total_days'])."',
			credit_balance= '".stripslashes($data['credit'])."',
			duration_days= '".$data[duration_days]."',
			".$cq."
			total= '".stripslashes($data['total'])."',
			gift= '".stripslashes($data['gift'])."',
			discount= '".stripslashes($data['discount'])."',
			payment_date='".date("y-m-d")."',
			user_type=".(int)$user_type." 
			where id=".(int)$id;
			$done_insert_result=$obj_admin_db->get_qresult($subject_insert_query);
			
			$renew_updatequery="INSERT INTO ".TABLE_CARDS." SET 
				card_type='".$data['card_type']."',
				account_name='".$data['account_name']."',
				creditcardnumber='".$data['creditcardnumber']."',
				expiry_year='".$data['card_expire_year']."',
				expiry_month='".$data['card_expire_month']."',
				cvv='".$data['card_security_code']."',
				user_id='".(int)$id."'";
				
	        $renew_result=$obj_admin_db->get_qresult($renew_updatequery);
			
			if($done_insert_result) 
			{			
				$_SESSION['user_log_type'] = $user_type;
				$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; 
				border:1px dotted #cccccc;" bgcolor="#FFFFFF">
						<tr>
							<td style="padding-left:15px;">
								<img src="http://listingpockets.com/images/logo.png" border="0" />
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Payment Success</b>
							</td>
						</tr>
						<tr>
							<td>
								'.$bmsg.'
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:15px;line-height:25px;">
							     Dear '. ucwords($_SESSION['user_log_name']).', <br/>
								 Your Payment is completed successfully, your Membership is now Activated.<br/>
								 Total: $'. $data[total].'<br/>
								 Invoice Numer: 4312703'. $invoice.'<br/>
								 Credit Balance: $'. $_SESSION['credit_amount'].'<br/>
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
				$To_Email =$data['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Membership Details from Listing Pockets';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
				
			if($data['ssl_amount']<=0) redirect_page('http://www.listingpockets.com/paymentsuccess.php?sub='.$data[sub].'&ssl_email='.$change_account_data['email'].'');
				 
				 else { 
				 
				 echo '<form method="post" action="https://www.myvirtualmerchant.com/VirtualMerchant/process.do" id="form_payments">
						<input type="hidden" name="ssl_amount" value="'.$data['ssl_amount'].'">
						<input type="hidden" name="ssl_merchant_id" value="597049">
						<input type="hidden" name="ssl_user_id" value="webpage">
						<input type="hidden" name="ssl_pin" value="3WGCVX">
						<input type="hidden" name="ssl_show_form" value="false">
						<input type="hidden" name="ssl_transaction_type" value="ccsale">
						<input type="hidden" name="ssl_email" value="'.$change_account_data['email'].'">
						<input type="hidden" name="ssl_card_number" value="'.$data['creditcardnumber'].'">
						<input type="hidden" name="ssl_exp_date" size="4" value="'.$data['card_expire_month'].$data['card_expire_year'].'">
						<input type="hidden" name="ssl_avs_address" value="'.$data['address'].'"> 
						<input type="hidden" name="ssl_first_name" value="'.$data['first_name'].'"> 
						<input type="hidden" name="ssl_last_name" value="'.$data['last_name'].'"> 
						<input type="hidden" name="ssl_city" value="'.$data['city'].'"> 
						<input type="hidden" name="ssl_phone" value="'.$data['state'].'"> 
						<input type="hidden" name="ssl_avs_address" value="'.$data['phone'].'"> 
						<input type="hidden" name="ssl_avs_zip" value="'.$data['zip'].'">
						<input type="hidden" name="ssl_cvv2cvc2" value="'.$data['card_security_code'].'">
						<input type="hidden" name="ssl_invoice_number" value="4312703'.$invoice.'">
						<input type="hidden" name="ssl_result_format" value="HTML">
						<input type="hidden" name="ssl_receipt_decl_method" value="POST">
						<input type="hidden" name="ssl_receipt_decl_post_url" value="https://listingpockets.com/payment.php">
						<input type="hidden" name="ssl_receipt_apprvl_method" value="POST">
						<input type="hidden" name="ssl_receipt_apprvl_post_url" value="http://www.listingpockets.com/paymentsuccess.php?sub='.$data['sub'].'">
						<input type="hidden" name="btn_payment" value="Continue"></form>';
						echo '<script>document.getElementById("form_payments").submit();</script>';	
                        exit();							 
			  }
			}
			
		}	
		
		
		// payment option
		function update_payment_info($data,$user_type,$id) {
			global $obj_admin_db;
			$category="Consumer";
			
			$change_account="select * from ".TABLE_USERS." where id=".$_SESSION['user_log_id'];
	        $change_account_data = $obj_admin_db->fetchRow($change_account);
			
			if($change_account_data['subscription']==1) $from_account='Switched From Full Member';
			elseif($change_account_data['subscription']==2) $from_account='Switched From Dual Member';
			elseif($change_account_data['subscription']==3) $from_account='Switched From Agent/Broker Member';
			elseif($change_account_data['subscription']==4) $from_account='Switched From Free Member';
			elseif($change_account_data['subscription']==5) $from_account='Switched From Investor/Broker Member';
			
			
			if($data[sub] == 1) $to_account=' To Full Member';
			elseif($data[sub] == 2) $to_account=' To Dual Member';
			elseif($data[sub] == 3) $to_account=' To Agent/Broker Member';
			elseif($data[sub] == 4) $to_account=' To Free Member';
			elseif($data[sub] == 5) $to_account=' To Investor/Broker Member';
			
			$explination=$from_account.$to_account;
			
			if($data[sub] == 3) {
				$category=""; 
				$bmsg="<p>Once we verify your real estate license and license status, we will send you a confirmation email separate from this one.
				We were usually pretty quick, but license verification may take up to 24 hours.</p><br>";
				$cq=" category='Agent/Broker', ";
			}	
			
			$card_resave="select * from ".TABLE_CARDS." where id=".$data['card_id'];
	        $card_resave_data = $obj_admin_db->fetchRow($card_resave);
			
			//insertion to table
			$order_insert_query="INSERT INTO ".TABLE_ORDERS." SET 
			card_type='".$card_resave_data['card_type']."',
			amount='".$_SESSION['total_amount']."',
			total_amount='".stripslashes($data['total'])."',
			credit_balance= '".stripslashes($data['credit'])."',
			explination='".$explination."',
			user_id='".$_SESSION['user_log_id']."'";
			$order_insert_result=$obj_admin_db->get_qresult($order_insert_query);
			$invoice=mysql_insert_id();
			
			$subject_insert_query="Update ".TABLE_USERS." SET 
			card_type='".$data['card_type']."',
			card_expire_month='".$card_resave_data['card_expire_month']."',
			card_expire_year='".$card_resave_data['card_expire_year']."',
			card_security_code='".$card_resave_data['card_security_code']."',
			billing_first_name = '".stripslashes($data['first_name'])."',
			billing_last_name = '".stripslashes($data['last_name'])."',
			address = '".stripslashes($data['address'])."',
			billing_address = '".stripslashes($data['address'])."',
			billing_city = '".stripslashes($data['city'])."',
			billing_state = '".stripslashes($data['state'])."',
			billing_zip = '".stripslashes($data['zip'])."',
			billing_phone = '".stripslashes($data['phone'])."',
			total_days= '".stripslashes($data['total_days'])."',
			credit_balance= '".stripslashes($data['credit'])."',
			duration_days= '".$data[duration_days]."',
			".$cq."
			total= '".stripslashes($data['total'])."',
			gift= '".stripslashes($data['gift'])."',
			discount= '".stripslashes($data['discount'])."',
			payment_date='".date("y-m-d")."',
			user_type=".(int)$user_type." 
			where id=".(int)$_SESSION['user_log_id'];
			$done_insert_result=$obj_admin_db->get_qresult($subject_insert_query);
			
			$renew_updatequery="INSERT INTO ".TABLE_CARDS." SET 
				card_type='".$card_resave_data['card_type']."',
				account_name='".$card_resave_data['account_name']."',
				creditcardnumber='".$card_resave_data['creditcardnumber']."',
				expiry_year='".$card_resave_data['expiry_year']."',
				expiry_month='".$card_resave_data['expiry_month']."',
				cvv='".$card_resave_data['cvv']."',
				user_id='".(int)$_SESSION['user_log_id']."'";
				
	        $renew_result=$obj_admin_db->get_qresult($renew_updatequery);
			
			if($done_insert_result) 
			{			
				$_SESSION['user_log_type'] = $user_type;
				$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; 
				border:1px dotted #cccccc;" bgcolor="#FFFFFF">
						<tr>
							<td style="padding-left:15px;">
								<img src="http://listingpockets.com/images/logo.png" border="0" />
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Payment Success</b>
							</td>
						</tr>
						<tr>
							<td>
								'.$bmsg.'
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:15px;line-height:25px;">
							     Dear '. ucwords($_SESSION['user_log_name']).', <br/>
								 Your Payment is completed successfully, your Membership is now Activated.<br/>
								 Total: $'.$_SESSION['total_amount'].'<br/>
								 Invoice Numer: 4312703'. $invoice.'<br/>
								 Credit Balance: $'. $_SESSION['credit_amount'].'<br/>
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
				$To_Email =$data['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Membership Details from Listing Pockets';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
				  						
			if($data['ssl_amount']<=0) redirect_page('http://www.listingpockets.com/paymentsuccess.php?sub='.$data[sub].'&ssl_email='.$change_account_data['email'].'');
				 
				 else { 
				  echo '<form method="post" action="https://www.myvirtualmerchant.com/VirtualMerchant/process.do" id="form_payment" name="form_id">
						<input type="hidden" name="ssl_amount" value="'.$data['ssl_amount'].'">
						<input type="hidden" name="ssl_merchant_id" value="597049">
						<input type="hidden" name="ssl_user_id" value="webpage">
						<input type="hidden" name="ssl_pin" value="3WGCVX">
						<input type="hidden" name="ssl_show_form" value="false">
						<input type="hidden" name="ssl_transaction_type" value="ccsale">
						<input type="hidden" name="ssl_email" value="'.$change_account_data['email'].'">
						<input type="hidden" name="ssl_card_number" value="'.$card_resave_data['creditcardnumber'].'">
						<input type="hidden" name="ssl_exp_date" size="4" value="'.$card_resave_data['expiry_month'].$card_resave_data['expiry_year'].'">
						<input type="hidden" name="ssl_cvv2cvc2" value="'.$card_resave_data['cvv'].'">
						<input type="hidden" name="ssl_avs_address" value="'.$data['address'].'"> 
						<input type="hidden" name="ssl_first_name" value="'.$data['first_name'].'"> 
						<input type="hidden" name="ssl_last_name" value="'.$data['last_name'].'"> 
						<input type="hidden" name="ssl_city" value="'.$data['city'].'"> 
						<input type="hidden" name="ssl_phone" value="'.$data['state'].'"> 
						<input type="hidden" name="ssl_avs_address" value="'.$data['phone'].'"> 
						<input type="hidden" name="ssl_avs_zip" value="'.$data['zip'].'">
						<input type="hidden" name="ssl_invoice_number" value="4312703'.$invoice.'">
						<input type="hidden" name="ssl_result_format" value="HTML">
						<input type="hidden" name="ssl_receipt_decl_method" value="POST">
						<input type="hidden" name="ssl_receipt_decl_post_url" value="https://listingpockets.com/payment.php">
						<input type="hidden" name="ssl_receipt_apprvl_method" value="POST">
						<input type="hidden" name="ssl_receipt_apprvl_post_url" value="http://www.listingpockets.com/paymentsuccess.php?sub='.$data[sub].'">
						<input type="hidden" name="btn_payment" value="Continue"></form>';
						echo '<script>document.getElementById("form_payment").submit();</script>';	
                        exit();				 
			  }
			}
			
		}
		
		function featured_payment($data,$id) {
			$subject_insert_query="Update ".TABLE_POST." SET 
			featured='1' 
			where id='".(int)$id."'";
			$subject_insert_result=mysql_query($subject_insert_query) or die(mysql_error());
			redirect_page("5.php?create=".$_GET['id']);
		}
		
		function update_upgradpayment($data,$id) {
			global $obj_admin_db;
			//insertion to table
			$subject_insert_query="Update ".TABLE_USERS." SET 
			card_type='".$_POST['card_type']."',
			card_expire_month='".$_POST['card_expire_month']."',
			card_expire_year='".$_POST['card_expire_year']."',
			card_security_code='".$_POST['card_security_code']."',
			user_type=2,
			broker_status=0,
			subscription=".(int)$data[sub].",	 
			acc_status=1 
			where id='".(int)$id."'";
			$subject_insert_result=mysql_query($subject_insert_query) or die(mysql_error());
			$_SESSION['user_log_type']=2;
			
				if($subject_insert_result) echo '<script>location.replace("search.php");</script>';
		}	
		
		//data INSERTING
		function insert_customer($data) {
			global $obj_admin_db;
			
			$from_account='New Registration as';
			
			
			if($data[sub] == 1) $to_account=' Full Member';
			elseif($data[sub] == 2) $to_account=' Dual Member';
			elseif($data[sub] == 3) $to_account=' Agent/Broker Member';
			elseif($data[sub] == 4) $to_account=' Free Member';
			elseif($data[sub] == 5) $to_account=' Investor/Broker Member';
			//elseif($data[sub] == 6) $to_account=' Agent/Broker Member';
			$explination=$from_account.$to_account;
			
			$bmsg="";
			$msg="";
			$token = rand(100000000,10000000);
						
			//insertion to table
		if($data['sub'] == 1 ) $actype=1;
		   elseif($data['sub'] == 2 ) $actype=2;
				elseif($data['sub'] == 3 ) $actype=1;
					elseif($data['sub'] == 4) $actype=3;
					   elseif($data['sub'] == 5) $actype=2;
						 //elseif($data['sub'] == 6 ) $actype=1;
			
			$email_exist_check="select * from ".TABLE_USERS." where email='".$data[email]."'";
	        $email_exist = $obj_admin_db->fetchRow($email_exist_check);
			
			
			$subject_insert_query="INSERT INTO ".TABLE_USERS." SET 
			first_name='".$data[first_name]."', 
			last_name='".$data[last_name]."', 
			email='".$data[email]."',
			user_type=".(int)$actype.",
			state='".$data[state]."',
			address = '".stripslashes($data['address'])."',
			city = '".stripslashes($data['city'])."',
			licenseno='".$data[licenseno]."',
			licensen_state= '".$data[licensestate]."',
			licensen_company= '".$data[licensen_company]."',
			company_address= '".$data[company_address]."',
			company_city= '".$data[company_city]."',
			company_state= '".$data[company_state]."',
			company_zip= '".$data[company_zip]."',
			com_phno= '".$data[com_phno]."',
			token=".(int)$token.",
			category='".$cat."',
			password='".$data[password]."',
			creditcardnumber='".$data['creditcardnumber']."',
			card_type='".$data['card_type']."',
			card_expire_month='".$data['card_expire_month']."',
			card_expire_year='".$data['card_expire_year']."',
			card_security_code='".$data['card_security_code']."',
			billing_first_name = '".stripslashes($data['first_name'])."',
			billing_last_name = '".stripslashes($data['last_name'])."',
			billing_address = '".stripslashes($data['address'])."',
			billing_city = '".stripslashes($data['city'])."',
			billing_state = '".stripslashes($data['state'])."',
			zip = '".stripslashes($data['zip'])."',
			phone = '".stripslashes($data['phone'])."',
			billing_country= '".stripslashes($data['country'])."',
			duration_days= '".(int)$data[duration_days]."',
			subscription=".(int)$data['sub'].",
			total= '".stripslashes($data['total'])."',
			gift= '".stripslashes($data['gift'])."',
			discount= '".stripslashes($data['discount'])."',
			fbemail= '".stripslashes($_SESSION['fbemail'])."',
			fbpassword= '".stripslashes($_SESSION['fbpassword'])."',
			phone_show='".$_POST['phone_show']."',
			fax_show='".$_POST['fax_show']."',
			cell_show='".$_POST['cell_show']."',
			contact_show='".$_POST['contact_show']."',
			twitter_show='".$_POST['twitter_show']."',
			facebook_show='".$_POST['facebook_show']."',
			google_show='".$_POST['google_show']."',
			web_show='".$_POST['web_show']."',
			paid=0,
			payment_date='".date("y-m-d")."'";
			$subject_insert_result=$obj_admin_db->get_qresult($subject_insert_query);
			if($subject_insert_result) 
			{			
				$ID= mysql_insert_id();
			
			//insertion to table
			$order_reg_query="INSERT INTO ".TABLE_ORDERS." SET 
			card_type='".$data['card_type']."',
			amount='".$data['total']."',
			total_amount='".stripslashes($data['total'])."',
			credit_balance= '".stripslashes($data['credit'])."',
			explination='".$explination."',
			user_id='".(int)$ID."'";
			$order_reg_result=$obj_admin_db->get_qresult($order_reg_query);
			$invoice=mysql_insert_id();
			
			$renew_reg_query="INSERT INTO ".TABLE_CARDS." SET 
				card_type='".$data['card_type']."',
				account_name='".$data['account_name']."',
				creditcardnumber='".$data['creditcardnumber']."',
				expiry_year='".$data['card_expire_year']."',
				expiry_month='".$data['card_expire_month']."',
				cvv='".$data['card_security_code']."',
				user_id='".(int)$ID."'";
				
	        $renew_reg_result=$obj_admin_db->get_qresult($renew_reg_query);
				
				
					
				  echo '<form method="post" action="https://www.myvirtualmerchant.com/VirtualMerchant/process.do" id="form_id" name="form_id">
						<input type="hidden" name="ssl_amount" value="'.$data['total'].'">
						<input type="hidden" name="ssl_merchant_id" value="597049">
						<input type="hidden" name="ssl_user_id" value="webpage">
						<input type="hidden" name="ssl_pin" value="3WGCVX">
						<input type="hidden" name="ssl_show_form" value="false">
						<input type="hidden" name="ssl_transaction_type" value="ccsale">
                        <input type="hidden" name="ssl_invoice_number" value="4312703'.$invoice.'">
						<input type="hidden" name="ssl_email" value="'.$data['email'].'">
						<input type="hidden" name="ssl_card_number" value="'.$data['creditcardnumber'].'"> <br/>
						<input type="hidden" name="ssl_exp_date" size="4" value="'.$data['card_expire_month'].$data['card_expire_year'].'">
						<input type="hidden" name="ssl_cvv2cvc2_indicator" value="1">
						<input type="hidden" name="ssl_cvv2cvc2" value="'.$data['card_security_code'].'">
						<input type="hidden" name="ssl_first_name" value="'.$data['first_name'].'"> 
						<input type="hidden" name="ssl_last_name" value="'.$data['last_name'].'"> 
						<input type="hidden" name="ssl_avs_address" value="'.$data['address'].'"> 
						<input type="hidden" name="ssl_city" value="'.$data['city'].'"> 
						<input type="hidden" name="ssl_state" value="'.$data['state'].'">
						<input type="hidden" name="ssl_country" value="USA">
						<input type="hidden" name="ssl_phone" value="'.$data['phone'].'"> 
						<input type="hidden" name="ssl_avs_zip" value="'.$data['zip'].'">
						<input type="hidden" name="ssl_result_format" value="HTML">
						<input type="hidden" name="ssl_receipt_decl_method" value="POST">
						<input type="hidden" name="ssl_receipt_decl_post_url" value="https://listingpockets.com/register_step3.php">
						<input type="hidden" name="ssl_receipt_apprvl_method" value="POST">
						<input type="hidden" name="ssl_receipt_apprvl_post_url" value="http://www.listingpockets.com/thankyou.php">
						<input type="hidden" name="btn_payment" value="Continue"></form>';
						echo '<script>document.getElementById("form_id").submit();</script>';	
                        exit();									 
			} else return "Registration info not posted , Try again";	
		}
		
		
		//data INSERTING
		function insert_giftcard($data) {
			global $obj_admin_db;
			$bmsg="";
			$msg="";
			
			$giftcard_by="select * from ".TABLE_USERS." where id=".$_SESSION['user_log_id'];
	        $giftcard_by_sent = $obj_admin_db->fetchRow($giftcard_by);
			
			$plan_select_query="SELECT * FROM ".TABLE_PLANS." WHERE plan_price=".(int)$_SESSION['membership_type'];
            $plan_select_urow=$obj_admin_db->fetchRow($plan_select_query);
				
				$cat = "Your gift card transaction is completed successfully.";
				$bmsg="<p>Your Gift Card Token Number: '".$token."'</p><br>";
				
				$cat1 = "You received a gift from ".ucwords($giftcard_by_sent['first_name'])." &nbsp; ".ucwords($giftcard_by_sent['last_name'])." &nbsp; Email: &nbsp; '".$_SESSION['user_log_email']."'";
				$bmsg1="<p>Membership is: '".$plan_select_urow['plan_name']."'</p><br>";
			
											
			$order_insert_query_gift="INSERT INTO ".TABLE_ORDERS." SET 
			card_type='".$data['card_type']."',
			amount='".$_SESSION['membership_type']."',
			total_amount='".stripslashes($data['total'])."',
			credit_balance= '".stripslashes($data['credit'])."',
			user_id='".(int)$_SESSION['user_log_id']."'";
			$order_insert_result_gift=$obj_admin_db->get_qresult($order_insert_query_gift);
			$invoice=mysql_insert_id();
			
			
			$renew_updatequery="INSERT INTO ".TABLE_CARDS." SET 
				card_type='".$data['card_type']."',
				account_name='".$data['account_name']."',
				creditcardnumber='".$data['creditcardnumber']."',
				expiry_year='".$data['card_expire_year']."',
				expiry_month='".$data['card_expire_month']."',
				cvv='".$data['card_security_code']."',
				user_id='".(int)$_SESSION['user_log_id']."'";
				
	        $renew_result=$obj_admin_db->get_qresult($renew_updatequery);
			
			$gift_coupans="INSERT INTO ".TABLE_GIFT_COUPONS." SET 
			token=".(int)$_SESSION['token'].",
			membership_type='".$_SESSION['membership_type']."',
			reciepient_email='".$_SESSION['reciepient_email']."',
			send_email='".$_SESSION['user_log_email']."',
			creditcardnumber='".$data['creditcardnumber']."',
			card_type='".$data['card_type']."',			
			card_expire_month='".$data['card_expire_month']."',
			card_expire_year='".$data['card_expire_year']."',
			card_security_code='".$data['card_security_code']."',
			payment_date='".date("y-m-d")."'";
			
			$gift_coupans_value=$obj_admin_db->get_qresult($gift_coupans);
			if($gift_coupans_value) 
			{			
				$ID= mysql_insert_id();
			     echo '<form method="post" action="https://www.myvirtualmerchant.com/VirtualMerchant/process.do" id="form_gift" name="form_id">
						<input type="hidden" name="ssl_amount" value="'.$data['ssl_amount'].'">
						<input type="hidden" name="ssl_merchant_id" value="597049">
						<input type="hidden" name="ssl_user_id" value="webpage">
						<input type="hidden" name="ssl_pin" value="3WGCVX">
						<input type="hidden" name="ssl_show_form" value="false">
						<input type="hidden" name="ssl_transaction_type" value="ccsale">
						<input type="hidden" name="ssl_email" value="'.$_SESSION['user_log_email'].'">
						<input type="hidden" name="ssl_card_number" value="'.$data['creditcardnumber'].'"> <br/>
						<input type="hidden" name="ssl_exp_date" size="4" value="'.$data['card_expire_month'].$data['card_expire_year'].'">
						<input type="hidden" name="ssl_avs_address" value="'.$data['address'].'"> 
						<input type="hidden" name="ssl_first_name" value="'.$data['first_name'].'"> 
						<input type="hidden" name="ssl_last_name" value="'.$data['last_name'].'"> 
						<input type="hidden" name="ssl_city" value="'.$data['city'].'"> 
						<input type="hidden" name="ssl_phone" value="'.$data['state'].'"> 
						<input type="hidden" name="ssl_avs_address" value="'.$data['phone'].'"> 
						<input type="hidden" name="ssl_avs_zip" value="'.$data['zip'].'">
						<input type="hidden" name="ssl_cvv2cvc2" value="'.$data['card_security_code'].'">
						<input type="hidden" name="ssl_invoice_number" value="4312703'.$invoice.'">
						<input type="hidden" name="ssl_result_format" value="HTML">
						<input type="hidden" name="ssl_receipt_decl_method" value="POST">
						<input type="hidden" name="ssl_receipt_decl_post_url" value="https://listingpockets.com/giftcard_payment.php">
						<input type="hidden" name="ssl_receipt_apprvl_method" value="POST">
						<input type="hidden" name="ssl_receipt_apprvl_post_url" value="http://www.listingpockets.com/gift_success.php">
						<input type="hidden" name="btn_payment" value="Continue"></form>';
						echo '<script>document.getElementById("form_gift").submit();</script>';	
                        exit();	
												 
			} else return "Gift card is not successfull , Try again";	
		}
		
		//data INSERTING
		function insert_shopping($data) {
			global $obj_admin_db;
			
			$from_account='Added Zip Codes';
			$to_account='';
			
			$explination=$from_account.$to_account;
			
			$bmsg="";
			$msg="";
			$token = rand(100000000,10000000);
						
				
			$email_exist_check="select * from ".TABLE_USERS." where email='".$data[ssl_email]."'";
	        $email_exist = $obj_admin_db->fetchRow($email_exist_check);
			
				
			//insertion to table
			$order_reg_query="INSERT INTO ".TABLE_ORDERS." SET 
			card_type='".$data['card_type']."',
			amount='".$data['total']."',
			total_amount='".stripslashes($data['total'])."',
			credit_balance= '".stripslashes($data['credit'])."',
			explination='".$explination."',
			user_id='".(int)$email_exist['id']."'";
			$order_reg_result=$obj_admin_db->get_qresult($order_reg_query);
			$invoice=mysql_insert_id();
			
			$renew_reg_query="INSERT INTO ".TABLE_CARDS." SET 
				card_type='".$data['card_type']."',
				account_name='".$data['account_name']."',
				creditcardnumber='".$data['creditcardnumber']."',
				expiry_year='".$data['card_expire_year']."',
				expiry_month='".$data['card_expire_month']."',
				cvv='".$data['card_security_code']."',
				user_id='".(int)$email_exist['id']."'";
				
	        $renew_reg_result=$obj_admin_db->get_qresult($renew_reg_query);
				
			if($renew_reg_result) {	
					
				  echo '<form method="post" action="https://www.myvirtualmerchant.com/VirtualMerchant/process.do" id="form_id" name="form_id">
						<input type="hidden" name="ssl_amount" value="'.$data['total'].'">
						<input type="hidden" name="ssl_merchant_id" value="597049">
						<input type="hidden" name="ssl_user_id" value="webpage">
						<input type="hidden" name="ssl_pin" value="3WGCVX">
						<input type="hidden" name="ssl_show_form" value="false">
						<input type="hidden" name="ssl_transaction_type" value="ccsale">
                        <input type="hidden" name="ssl_invoice_number" value="4312703'.$invoice.'">
						<input type="hidden" name="ssl_email" value="'.$data['ssl_email'].'">
						<input type="hidden" name="ssl_card_number" value="'.$data['creditcardnumber'].'"> <br/>
						<input type="hidden" name="ssl_exp_date" size="4" value="'.$data['card_expire_month'].$data['card_expire_year'].'">
						<input type="hidden" name="ssl_cvv2cvc2_indicator" value="1">
						<input type="hidden" name="ssl_cvv2cvc2" value="'.$data['card_security_code'].'">
						<input type="hidden" name="ssl_first_name" value="'.$data['first_name'].'"> 
						<input type="hidden" name="ssl_last_name" value="'.$data['last_name'].'"> 
						<input type="hidden" name="ssl_avs_address" value="'.$data['address'].'"> 
						<input type="hidden" name="ssl_city" value="'.$data['city'].'"> 
						<input type="hidden" name="ssl_state" value="'.$data['state'].'">
						<input type="hidden" name="ssl_country" value="USA">
						<input type="hidden" name="ssl_phone" value="'.$data['phone'].'"> 
						<input type="hidden" name="ssl_avs_zip" value="'.$data['zip'].'">
						<input type="hidden" name="ssl_result_format" value="HTML">
						<input type="hidden" name="ssl_receipt_decl_method" value="POST">
						<input type="hidden" name="ssl_receipt_decl_post_url" value="https://listingpockets.com/shopping_cart.php">
						<input type="hidden" name="ssl_receipt_apprvl_method" value="POST">
						<input type="hidden" name="ssl_receipt_apprvl_post_url" value="http://www.listingpockets.com/shopping_success.php">
						<input type="hidden" name="btn_payment" value="Continue"></form>';
						echo '<script>document.getElementById("form_id").submit();</script>';	
                        exit();									 
			} else return "Registration info not posted , Try again";	
		}
		
		function insert_freeagent($data) {		
					global $obj_admin_db;
			
			$from_account='New Registration as';
			
			
			if($data[sub] == 1) $to_account=' Full Member';
			elseif($data[sub] == 2) $to_account=' Dual Member';
			elseif($data[sub] == 3) $to_account=' Agent/Broker Member';
			elseif($data[sub] == 4) $to_account=' Free Member';
			elseif($data[sub] == 5) $to_account=' Investor/Broker Member';
			elseif($data[sub] == 6) $to_account=' Agent/Broker Member';
			$explination=$from_account.$to_account;
			
			$bmsg="";
			$msg="";
			$token = rand(100000000,10000000);
						
			//insertion to table
		if($data['sub'] == 1 ) $actype=1;
		   elseif($data['sub'] == 2 ) $actype=2;
				elseif($data['sub'] == 3 ) $actype=1;
					elseif($data['sub'] == 4) $actype=3;
					   elseif($data['sub'] == 5) $actype=2;
						 elseif($data['sub'] == 6 ) $actype=1;
			
			$email_exist_check="select * from ".TABLE_USERS." where email='".$data[email]."'";
	        $email_exist = $obj_admin_db->fetchRow($email_exist_check);
			
			
			$subject_insert_query="INSERT INTO ".TABLE_USERS." SET 
			first_name='".$data[first_name]."', 
			last_name='".$data[last_name]."', 
			email='".$data[email]."',
			user_type=".(int)$actype.",
			state='".$data[state]."',
			address = '".stripslashes($data['address'])."',
			city = '".stripslashes($data['city'])."',
			licenseno='".$data[licenseno]."',
			licensen_state= '".$data[licensestate]."',
			licensen_company= '".$data[licensen_company]."',
			company_address= '".$data[company_address]."',
			company_city= '".$data[company_city]."',
			company_state= '".$data[company_state]."',
			company_zip= '".$data[company_zip]."',
			com_phno= '".$data[com_phno]."',
			token=".(int)$token.",
			category='".$cat."',
			password='".$data[password]."',
			creditcardnumber='".$data['creditcardnumber']."',
			card_type='".$data['card_type']."',
			card_expire_month='".$data['card_expire_month']."',
			card_expire_year='".$data['card_expire_year']."',
			card_security_code='".$data['card_security_code']."',
			billing_first_name = '".stripslashes($data['first_name'])."',
			billing_last_name = '".stripslashes($data['last_name'])."',
			billing_address = '".stripslashes($data['address'])."',
			billing_city = '".stripslashes($data['city'])."',
			billing_state = '".stripslashes($data['state'])."',
			zip = '".stripslashes($data['zip'])."',
			phone = '".stripslashes($data['phone'])."',
			billing_country= '".stripslashes($data['country'])."',
			duration_days= '".(int)$data[duration_days]."',
			subscription=".(int)$data['sub'].",
			total= '".stripslashes($data['total'])."',
			gift= '".stripslashes($data['gift'])."',
			discount= '".stripslashes($data['discount'])."',
			fbemail= '".stripslashes($_SESSION['fbemail'])."',
			fbpassword= '".stripslashes($_SESSION['fbpassword'])."',
			phone_show='".$_POST['phone_show']."',
			fax_show='".$_POST['fax_show']."',
			cell_show='".$_POST['cell_show']."',
			contact_show='".$_POST['contact_show']."',
			twitter_show='".$_POST['twitter_show']."',
			facebook_show='".$_POST['facebook_show']."',
			google_show='".$_POST['google_show']."',
			web_show='".$_POST['web_show']."',
			paid=0,
			payment_date='".date("y-m-d")."'";
			$subject_insert_result=$obj_admin_db->get_qresult($subject_insert_query);		
if($subject_insert_result) 
			{			
				//echo 'test'.$_SESSION['reg_id']=mysql_insert_id();
				$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; color:#FF0000
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
							<td>
						<p>Please take a moment to activate your account by clicking on the link below. If, for some reason, that doesn&acute;t work, please copy/paste 
												it in your browser&acute;s url field above.</p><br>

						<p>Please add this to our email</p><br>
						<p>Please activate your account here: <a href="http://www.listingpockets.com/verifyemail.php?token='.$token.'">
							http://www.listingpockets.com/verifyemail.php?token='.$token.'</a></p>
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
				
				
				$From_Display = 'Listing Pockets';
				$From_Email = ADMIN_EMAIL;
				$To_Email =$data['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Please Activate Your Account';
				$Message = $Body;
				$Format = 1;
				//$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
				echo '<script>location.replace("thankyou1.php");</script>';								 
			} else return "Registration info not posted , Try again";	
		}
		
		
	
		function insert_freecustomer($data) {
			global $obj_admin_db;
			//insertion to table
			$token = rand(100000000,10000000);
			$subject_insert_query="INSERT INTO ".TABLE_USERS." SET 
			first_name='".$data[first_name]."', 
			last_name='".$data[last_name]."', 
			email='".$data[email]."',
			user_type=3,
			acc_status=0,
			state='".$data[state]."',
			category='".$data[category]."',
			licenseno='".$data[licenseno]."',
			subscription=4,
			token=".(int)$token.",
			password='".$data[password]."',
			fbemail='".mysql_escape_string(stripslashes($data['fbemail']))."',
	        fbpassword='".mysql_escape_string(stripslashes($data['fbpassword']))."',
			phone_show='on',
			fax_show='on',
			cell_show='on',
			contact_show='on',
			twitter_show='on',
			facebook_show='on',
			google_show='on',
			web_show='on',
			paid=1";
			$subject_insert_result=$obj_admin_db->get_qresult($subject_insert_query);
			if($subject_insert_result) 
			{			
				//echo 'test'.$_SESSION['reg_id']=mysql_insert_id();
				$Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; color:#FF0000
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
							<td>
						<p>Please take a moment to activate your account by clicking on the link below. If, for some reason, that doesn&acute;t work, please copy/paste 
												it in your browser&acute;s url field above.</p><br>

						<p>Please add this to our email</p><br>
						<p>Please activate your account here: <a href="http://www.listingpockets.com/verifyemail.php?token='.$token.'">
							http://www.listingpockets.com/verifyemail.php?token='.$token.'</a></p>
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
				
				
				$From_Display = 'Listing Pockets';
				$From_Email = ADMIN_EMAIL;
				$To_Email =$data['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Please Activate Your Account';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
				echo '<script>location.replace("thankyou.php");</script>';								 
			} else return "Registration info not posted , Try again";	
		}
		
		
	}
?>