<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
</script>

<?php
if(isset($_POST['btn_press_save'])) {
			$ermsg='';
			if(!strlen($_POST['master_password'])) $ermsg='Enter Master Password';					
			
			if(!$ermsg) {
								
					$subject_insert_query="UPDATE ".TABLE_USERS." SET
					master_password='".mysql_real_escape_string($_POST['master_password'])."'";
					$subject_insert_result=$obj_admin_db->get_qresult($subject_insert_query);
														
			}							
          if($subject_insert_result) redirect_page("index.php?p=dialy_password&act=suc");
}

?>
				<h2>Master Password</h2>
				<ul class="tabs">
					<li class="active"><a href="#" title="Details"><span>Edit</span></a></li>
				</ul>
				<div class="box">
				 <p style="color:#FF0000;"> <?php if($ermsg) echo $ermsg; if($_GET['act']=='suc') echo 'Master Password Changed Successfully'; ?></p>
				<form method="post" id="frm1">
				<fieldset>
				   
					<label>Master Password:</label>
					<span class="small_input"><input class="small" name="master_password" type="password" value="<?php echo $_POST['master_password'];?>" /></span>
					<br class="hid" />
					<span style="font-size:14px;">
					 
					 </span><br class="hid" /> 
					</div>
				<p>&nbsp;</p><input type="hidden" class="button1" name="btn_press_save" value="Update"  />
			
				<a href="javascript:void();" onclick="submit1();" class="button" title="Submit"><span>Submit</span></a>
			
				<span class="clear"></span>
				</fieldset>
				</div>					
				</div>
   			