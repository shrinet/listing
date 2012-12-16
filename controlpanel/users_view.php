<?php
session_start();
$_SESSION['id']=$_GET['user_id'];
$user_select="select * from ".TABLE_USERS." where id =".(int)$_GET['user_id'];
$user_select_srows=$obj_db->fetchRow($user_select);
?>
<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
</script> 
<?php 


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

<!--
<form method="post">


				<h2>View User</h2>
				<ul class="tabs">
                	<li><a href="index.php?p=users&user_id=<?php echo $_SESSION['id'];?>&action=edit"><span>Edit</span></a></li>
					<li><a href="index.php?p=users&act=broker" title="Products"><span>Back</span></a></li>
					<li class="active"><a href="#" title="Details"><span>View</span></a></li>
				</ul>
				<div class="box">
				
				<fieldset>


			
								
					<label>license Number :</label>
					<span class="small_input"><input readonly="true" class="small" name="licenseno" type="text" value="<?php echo htmlentities($user_select_srows['licenseno']);?>" /></span><br class="hid" />
					<label>licensed state :</label>
					<span class="small_input"><input readonly="true" class="small" name="licensen_state" type="text" value="<?php echo htmlentities($user_select_srows['licensen_state']);?>" /></span><br class="hid" />
					
					<label>Licensen Company :</label>
					<span class="small_input"><input class="small" readonly="true" name="licensen_company" type="text" value="<?php echo htmlentities($user_select_srows['licensen_company']);?>" /></span><br class="hid" />
					<label>Company Address :</label>
					<span class="small_input"><input class="small" readonly="true" name="company_address" type="text" value="<?php echo htmlentities($user_select_srows['company_address']);?>" /></span><br class="hid" />
					<label>Company No :</label>
					<span class="small_input"><input class="small" name="com_phno" readonly="true" type="text" value="<?php echo htmlentities($user_select_srows['com_phno']);?>" /></span><br class="hid" />
					<label>Phone :</label>
				<span class="small_input"><input class="small" name="phone" readonly="true" type="text" value="<?php echo htmlentities($user_select_srows['phone']);?>" /></span><br class="hid" />
											
</fieldset>
</form> -->

				<form method="post" id="frm1">

				<h2>View User</h2>
				<ul class="tabs">
                	<li><a href="index.php?p=users&act=broker" title="Products"><span>Back</span></a></li>
					<li class="active"><a href="#" title="Details"><span>View</span></a></li>
				</ul>
				<div class="box">                
				<fieldset>
<label>First Name :</label>
					<span class="small_input"><input class="small" name="first_name" type="text" value="<?php echo htmlentities($user_select_srows['first_name']);?>" /></span><br class="hid" />
					
					<label>Last Name :</label>
					<span class="small_input"><input class="small" name="last_name" type="text" value="<?php echo htmlentities($user_select_srows['last_name']);?>" /></span><br class="hid" />
					
					<label>Address :</label>
					<span class="small_input"><input class="small" name="address" type="text" value="<?php echo htmlentities($user_select_srows['address']);?>" /></span><br class="hid" />
					
					<label>City :</label>
					<span class="small_input"><input class="small" name="city" type="text" value="<?php echo htmlentities($user_select_srows['city']);?>" /></span><br class="hid" />
					
					<?php //if($user_select_srows['subscription']==3 || $data['subscription']==6) {?>
					<label>license Number :</label>
					<span class="small_input"><input class="small" name="licenseno" type="text" value="<?php echo htmlentities($user_select_srows['licenseno']);?>" /></span><br class="hid" />
					<label>licensed state :</label>
					<span class="small_input"><input class="small" name="licensen_state" type="text" value="<?php echo htmlentities($user_select_srows['licensen_state']);?>" maxlength="2" /></span><br class="hid" />
					<?php //} ?>	
                    
                 <p>&nbsp;</p><input type="hidden" class="button1" name="btn_press_save" value="Update"  />
			
				<a href="javascript:void();" onclick="submit1();" class="button" title="Submit"><span>Submit</span></a>
			
				<span class="clear"></span>
				</fieldset>