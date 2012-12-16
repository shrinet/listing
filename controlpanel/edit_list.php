<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
</script> 
<?php 
$page_url = "index.php?p=edit";

if(isset($_POST['btn_edit']))
{
  $update_values="update ".TABLE_POST." set contact_city='".$_POST['contact_city']."',
                                            contact_street='".$_POST['contact_street']."',
											contact_street_no='".$_POST['contact_street_no']."',
                                            category='".$_POST['category']."',
											price='".$_POST['price']."',
											bedrooms='".$_POST['bedrooms']."',
											bathrooms='".$_POST['bathrooms']."',
										    living_space='".$_POST['living_space']."',
											contact_state='".$_POST['contact_state']."',
											contact_zip_code='".$_POST['contact_zip_code']."',
											year_built='".$_POST['year_built']."',
											hoa='".$_POST['hoa']."',
											floors='".$_POST['floors']."',
											commission='".$_POST['commission']."',
											additional_msg='".$_POST['additional_msg']."',
											property_features='".$_POST['property_features']."',
											pets_allow='".$_POST['pets_allow']."',
											pets_allowed='".$_POST['pets_allowed']."',
											community_features='".$_POST['community_features']."'
                                            where id=".$_GET['user_id'];
  $success_update=mysql_query($update_values);
  
  if($success_update) {
  $image_uri="../photos/".$_GET['user_id'].'.jpg';
  move_uploaded_file($_FILES['imagefile']['tmp_name'], $image_uri);
     redirect_page('index.php?p=ads');
  }
}

if($_GET['act']=='ap' && $_GET['id']) {
	if($_GET['aid']==0)	{
		$update="update ".TABLE_POST." set status=1 where id=".$_GET['id'];
	}
	else {
	$update="update ".TABLE_POST." set status=0 where id=".$_GET['id'];
	}
		mysql_query($update) or die(mysql_error());
}

if($_GET['act']=='del' && isset($_GET['user_id'])) {
$delq="Delete from ".TABLE_POST." where id=".$_GET['user_id'];
$deld=mysql_query($delq);
	if($deld) redirect_page($page_url);
} ?>
<style type="text/css">
#content td{
border:0px;
padding-top:8px;
}
</style>
<?php if($errmsg){?>
	<p class="alert">
		<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $errmsg;?></span>
		<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>
	</p>
<?php } ?>
		<h2>Edit Listing</h2>
		<ul class="tabs">
			<!--<li><a href="index.php?p=corder&act=add" title="Products"><span>Add New</span></a></li>-->
			<li class="active"><a href="#" title="Details"><span>List</span></a></li>
		</ul>
		<div class="box">
			 <form method="post">
			<table border="0" cellpadding="3" cellspacing="3" width="100%" style="">
				<?php
					$user_select_query="select * from ".TABLE_POST." where id=".$_GET['user_id'];
					$user_select_rows=$obj_db->fetchRow($user_select_query);
														
				  if($user_select_rows) { ?>
					 
					<tr>
						<td><strong>Property Street/Address: </strong></td>
						<td>
						  <input class="small" type="text" value="<?php echo $user_select_rows['contact_street']; ?>" name="contact_street" />
						</td>
					</tr>
					<tr>
						<td><strong>Property Street No: </strong></td>
						<td>
						  <input class="small" type="text" value="<?php echo $user_select_rows['contact_street_no']; ?>" name="contact_street_no" />
						</td>
					</tr>
					<tr>
						<td><strong>Property City: </strong></td>
						<td>
						  <input class="small" type="text" value="<?php echo $user_select_rows['contact_city']; ?>" name="contact_city" />
						</td>
					</tr>
					<tr>
						<td><strong>Property State: </strong></td>
						<td>
						  <input class="small" type="text" value="<?php echo $user_select_rows['contact_state']; ?>" name="contact_state" maxlength="2" />
						</td>
					</tr>
					<tr>
						<td><strong>Zip Code: </strong></td>
						<td>
						  <input class="small" type="text" value="<?php echo $user_select_rows['contact_zip_code']; ?>" name="contact_zip_code" />
						</td>
					</tr>
					<?php  if(($user_select_rows['category']=='Rentals - Residential') || ($user_select_rows['category']=='Shared Apt-Homes') || ($user_select_rows['category']=='Rentals - Vacation')) { ?>
					<tr>
						<td><strong>Pets: </strong></td>
						<td>
						  <table align="left">
						    <tr>
							  <td><input type="radio" name="pets_allow" value="yes" <?php if($user_select_rows['pets_allow']=='yes') echo 'checked="checked"';?>>Allow &nbsp; 
						  <input class="small" type="text" value="<?php echo $user_select_rows['pets_allowed']; ?>" name="pets_allowed" maxlength="10" />
						  </td></tr>
						  <tr><td>
						  <input type="radio" name="pets_allow" value="no" <?php if($user_select_rows['pets_allow']=='no') echo 'checked="checked"';?>>Not Allow
							  </td>
							</tr>
						  </table>
						  
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td><strong>Property Type</strong></td>
					    <td>
							<select style="border:1px solid #ccc;" name="category">
							<option value="">Select </option>
							<option value="Real Estate for Sale - Residential" <?php if($user_select_rows['category']=='Real Estate for Sale - Residential') { ?>selected="selected" <?php } ?>>Real Estate for Sale - Residential</option>
							<option value="Real Estate for Sale - Commercial" <?php if($user_select_rows['category']=='Real Estate for Sale - Commercial') { ?>selected="selected" <?php } ?>>Real Estate for Sale - Commercial</option>
							<option value="Rentals - Residential" <?php if($user_select_rows['category']=='Rentals - Residential') { ?>selected="selected" <?php } ?>>Rentals - Residential</option>
							<option value="Rentals - Vacation" <?php if($user_select_rows['category']=='Rentals - Vacation') { ?> selected="selected" <?php } ?>>Rentals - Vacation</option>
							<option value="Rentals - Commercial" <?php if($user_select_rows['category']=='Rentals - Commercial') { ?>selected="selected" <?php } ?>>Rentals - Commercial</option>
							<option value="Shared Apt-Homes" <?php if($user_select_rows['category']=='Shared Apt-Homes') { ?> selected="selected" <?php } ?>>Shared Apt/Homes /Roommate</option>
							</select>
						</td>
					</tr>
					<tr>	
						<td><strong>Asking price($)</strong></td>
					    <td><input class="small" type="text" name="price" value="<?php echo $user_select_rows['price']; ?>" /></td>
					</tr>	
					<tr>
						<td><strong>Bedrooms</strong></td>
					    <td><input class="small" type="text" name="bedrooms" value="<?php echo $user_select_rows['bedrooms']; ?>" /></td>
					</tr>
					<tr>	
						<td><strong>Bathrooms</strong></td>
					    <td><input class="small" type="text" name="bathrooms" value="<?php echo $user_select_rows['bathrooms']; ?>" /></td>					
					</tr>	
					<tr>	
						<td><strong>Square footage</strong></td>
					    <td><input class="small" type="text" name="living_space" value="<?php echo $user_select_rows['living_space']; ?>" /></td>
					</tr>	
					
					<tr>	
						<td><strong>Year built </strong></td>
					    <td><input class="small" type="text" name="year_built" value="<?php echo $user_select_rows['year_built']; ?>" /></td>
					</tr>	
					
					<tr>	
						<td><strong>HOA/Maintenance </strong></td>
					    <td><input class="small" type="text" name="hoa" value="<?php echo $user_select_rows['hoa']; ?>" /></td>
					</tr>	
					<tr>	
						<td><strong>Year built </strong></td>
					    <td><input class="small" type="text" name="floors" value="<?php echo $user_select_rows['floors']; ?>" /></td>
					</tr>	
					<tr>	
						<td><strong>Commission </strong></td>
					    <td><input class="small" type="text" name="commission" value="<?php echo $user_select_rows['commission']; ?>" /></td>
					</tr>	
					<tr>	
						<td><strong>Property Description</strong></td>
					    <td><textarea name="additional_msg"><?php echo $user_select_rows['additional_msg']; ?></textarea></td>
					</tr>
					<tr>	
						<td><strong>Property Features</strong></td>
					    <td><textarea id="property_features" class="small" rows="6" cols="50" name="property_features"><?php echo $user_select_rows['property_features']; ?></textarea>
						</td>
					</tr>	
					<tr>	
						<td><strong>Community Features </strong></td>
					    <td><textarea id="community_features" class="small" rows="6" cols="50" name="community_features"><?php echo $user_select_rows['community_features']; ?></textarea>
						</td>
					</tr>
					<tr>	
						<td><strong>Property Image</strong></td>
					    <td><input type="file" size="30" style="height:30px;" name="imagefile"></td>
					</tr>	
					
					
				    <tr>
					  <td colspan="2">
					   <input type="submit" class="button" value="Update" name="btn_edit" >					    
					  </td>
					</tr>
				
				<?php }  //if end ?>
			</table>
			</form>
		</div>