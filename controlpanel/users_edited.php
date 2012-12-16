<?php 
session_start();
$_GET['user_id']=$_SESSION['id'];
require_once("classes/admin_functions.php");
require_once("../includes/general.php");
require_once("../includes/DbConfig.php");
$user_select="select * from ".TABLE_USERS." where id =".(int)$_GET['user_id'];
$user_select_srows=$obj_db->fetchRow($user_select);

?>

<form method="post">


				<h2>View User</h2>
				<ul class="tabs">
					<li><a href="index.php?p=users&act=broker" title="Products"><span>Back</span></a></li>
					<li class="active"><a href="#" title="Detail"><span>Edit</span></a></li>
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
</form>