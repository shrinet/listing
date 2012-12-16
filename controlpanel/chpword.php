<?php defined('ACCESS_SUBFILES') or die('Restricted access');?>
<?php

	$_POST = remove_slashes_add_htmlentries($_POST);
	if(isset($_POST['btn_change_password'])) {
		extract($_POST);		
		$msg="";
		$ermsg=array();
		if(!strlen(trim($_POST['ousname']))){ $msg .="* Enter old username<br>" ; $ermsg[]="Enter old username.";}
		if(!strlen(trim($_POST[old]))){ $msg .="* Enter old password<br>";  $ermsg[]="Enter old password.";}
		if(!strlen(trim($_POST['usname']))){ $msg .="* Enter username<br>"; $ermsg[]="Enter username.";}
		if(!strlen(trim($_POST['new']))){ $msg .="* Enter new password<br>"; $ermsg[]="Enter new password.";}
		if(!strlen(trim($_POST[new1]))){ $msg .="* Confirm new password<br>"; $ermsg[]="Passwords not matching.";}	
		else if(trim($_POST['new'])<>trim($_POST[new1])){ $msg .="* Passwords not matching";  $ermsg[]="Passwords not matching.";}		

		if($msg=="") {
			$admin_sel_qry="SELECT * FROM ".TABLE_ADMINISTRATOR." WHERE admin_pword ='".md5(trim($_POST['old']))."' and admin_user='".mysql_escape_string(trim($_POST['ousname']))."' and id=1";		
			$admin_sel_row = $obj_admin_db->fetchRow($admin_sel_qry);							
			if($admin_sel_row)	{				
				$admin_update_query="UPDATE ".TABLE_ADMINISTRATOR." SET admin_pword ='".md5(trim($_POST['new']))."',admin_opword='".mysql_escape_string(trim($_POST['new']))."', admin_user='".mysql_escape_string(trim($_POST['usname']))."' where id=1";
				$admin_update_result = $obj_admin_db->get_qresult($admin_update_query);
				if($admin_update_result) {					
					$msg ="* Login details Changed Successfully";
					$ermsg[]="Login details Changed Successfully";
					unset($_POST);
				} else { 
					$msg ="* Login details not changed, try again.";			
					$ermsg[]="Login details not changed, try again.";
				}
			} else $msg ="* Invalid login details";
		}
	}

	if(isset($_POST['btn_email'])) {
		extract($_POST);
		$msg1="";	
		if(!strlen(trim($_POST['contact_email']))) $msg1.="* Enter Contact email address<br>";			
		elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $_POST['contact_email']))
			$msg1.="* Contact email address appeares to be incorrect<br>"; 		
		if(!strlen(trim($_POST['paypal_email']))) $msg1.="* Enter Paypal email address<br>";			
		elseif (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $_POST['paypal_email']))
			$msg1.="* Paypal email address appeares to be incorrect<br>"; 			
		if($msg1=="") {				
			$admin_update_query="UPDATE ".TABLE_ADMINISTRATOR." SET contact_email='".mysql_escape_string(trim($_POST['contact_email']))."', paypal_email='".mysql_escape_string(trim($_POST['paypal_email']))."' where id=1 ";
			$admin_update_result = $obj_admin_db->get_qresult($admin_update_query);
			if($admin_update_result) {					
				$msg1 ="* Email address Changed Successfully";
			} else $msg1 ="* Email address not changed, try again.";
		}
	} 

	$admin_sel_qry="SELECT * FROM ".TABLE_ADMINISTRATOR;
	$admin_sel_row = $obj_admin_db->fetchRow($admin_sel_qry);		

?>
<h2>Settings</h2>
<ul class="tabs">
	<li class="active"><a href="#" title="Item1"><span>Settings</span></a></li>
</ul>
<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
	function submit2(){
		$(' #frm2 ').submit();
	}
</script>
<form method="post" id="frm1">

<fieldset>
	<label>Old User name :</label>
	<span class="small_input"><input class="small" name="ousname" type="text" value="<?php echo trim($_POST['ousname']);?>" /></span><br class="hid" />
	
	<label>Old Password :</label>
	<span class="small_input"><input class="small" name="old" type="password" value="<?php echo trim($_POST['old']);?>" /></span><br class="hid" />
	
	<label>New User name :</label>
	<span class="small_input"><input class="small" name="usname" type="text" value="<?php echo trim($_POST['usname']);?>" /></span><br class="hid" />
	
	<label>New Password :</label>
	<span class="small_input"><input class="small" name="new" type="password" value="<?php echo trim($_POST['new']);?>" /></span><br class="hid" />
	
	<label>Re Enter New Password :</label>
	<span class="small_input"><input class="small" name="new1" type="password" value="<?php echo trim($_POST['new1']);?>" /></span><br class="hid" />
	
	<br class="hid" />
	<p><p><input type="hidden" height="20px" name="btn_change_password" value="Change" class="button" /><a href="javascript:void();" onclick="submit1();" class="button" title="Submit"><span>Submit</span></a>
	</p></p>
	</fieldset>
</form>	
<?php if($msg){?>

<?php foreach($ermsg as $err){?> 
	<p class="alert">
		<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $err;?></span>
		<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>
	</p>
<?php } ?>

<?php } ?>
<h2>Email Settings</h2>
<ul class="tabs">
	<li class="active"><a href="#" title="Item1"><span>Settings</span></a></li>
</ul>
<form method="post" id="frm2">
<fieldset>
	<label>Email Address</label>
	<label>Contact E-mail :</label>
	<span class="small_input"><input class="small" name="contact_email" type="text" value="<?php echo trim($admin_sel_row['contact_email']);?>" /></span><br class="hid" />
	<label>Paypal E-mail :</label>
	<span class="small_input"><input class="small" name="paypal_email" type="text" value="<?php echo trim($admin_sel_row['paypal_email']);?>" /></span><br class="hid" />
	<p></p><input type="hidden" class="button1" name="btn_email" value="Update"  /><a href="javascript:void();" onclick="submit2();" class="button" title="Submit"><span>Submit</span></a>
	<span class="clear"></span>
</fieldset>

</form>

<?php if($msg1){?>
<p class="alert">
	<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $msg1;?></span>
	<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>
</p>
<?php } ?>
