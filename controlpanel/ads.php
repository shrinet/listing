<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
</script> 
<?php 
$page_url = "index.php?p=ads";
if($_GET['act']=='ap' && $_GET['id']) {
	if($_GET['aid']==0)	{
		$update="update ".TABLE_POST." set status=1 where id=".$_GET['id'];
	}
	else {
	$update="update ".TABLE_POST." set status=0 where id=".$_GET['id'];
	}
		mysql_query($update) or die(mysql_error());
}

if($_GET['act']=='del' && $_GET['user_id']) {
		$delete_query="UPDATE ".TABLE_POST." SET deleted=1 WHERE  id=".(int)$_GET['user_id'];
		$deletedrow=$obj_admin_db->get_qresult($delete_query);
			if($deletedrow) redirect_page("index.php?p=ads");
			else $ermsg= "Not Deleted";
	} ?>
<?php if($errmsg){?>
	<p class="alert">
		<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $errmsg;?></span>
		<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>
	</p>
<?php } ?>
		<h2>Listings</h2>
		<ul class="tabs">
			<li class="<?php if(!$_GET['act']=='del') echo "active"; else echo "";?>"><a href="index.php?p=ads" title="Details"><span>Active Listings</span></a></li>
			<li class="<?php if($_GET['act']=='del') echo "active"; else echo "";?>"><a href="index.php?p=ads&act=del" title="Products"><span>Deleted/Expired Listings</span></a></li>
		</ul>
		<div class="box">
		     <table border="0" cellpadding="0" cellspacing="0" width="100%" style="">
				   <tr>
						<td colspan="7">
						<label>Search by City,State or Zip or LP No.</label>
						<label>
						  <form method="get" id="frm1" action="" name="search">
							<input class="small" name="location" type="text" value="<?php echo $_GET['location']; ?>" />&nbsp;&nbsp;&nbsp;
							<input type="hidden" class="button1" name="action" value="Search"  />
							<a href="javascript:void();" onclick="$('#frm1').submit();" class="button" title="Submit"><span>Search</span></a>
							<span class="clear"></span> <br/>
						 </form>
						</label>
						</td>
					</tr>
					<tr><td>&nbsp;
					  
					</td></tr>
			  </table>
			  
		
		<?php if($_GET['act']=='del') { ?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="">
		  
		        <?php
					if(isset($_GET['location']) && ($_GET['action']=='Search')) {
					$user_select_query1="select * from ".TABLE_POST." where (id='".(int)$_GET['location']."' OR contact_city='".$_GET['location']."' OR contact_state='".$_GET['location']."' OR contact_zip_code='".(int)$_GET['location']."') AND status=1 ORDER by id DESC "; 
					} else {
					$user_select_query1="select * from ".TABLE_POST." where copy =0 AND deleted=0 AND status=1 ORDER by id DESC ";
					}
					$user_select_srows1=$obj_db->fetchNum($user_select_query1);
					if(!$user_select_srows1) {										
				?>
				<tr>
					<td height="25px" colspan="2" align="center" class="error">
						<b >No Listings.</b>
					</td>
				</tr>
				<?php } ?>
				<?php if($user_select_srows1) { ?>
					<?php //PAGE NUMBERS USAGE
						$PageNos_Navigation = array("First_Last_Links"=>1, 
													"Page_Navigator"=>"page", 
													"Total_Records"=>$user_select_srows, 
													"Records_PerPage"=>8, 
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
						$user_select_query1.=" LIMIT $StartCount, $PerPage ";					
						$user_select_res1=$obj_db->get_qresult($user_select_query1);
					?>  
					<tr>
						<td><strong>Image</strong></td>
						<td><strong>Property Address</strong></td>
						<td><strong>LP No.</strong></td>
						<td><strong>Property Type</strong></td>
						<td><strong>Asking</strong></td>
						<td><strong>BR</strong></td>
						<td><strong>BT</strong></td>
						<td><strong>SF</strong></td>
						<?php /*?><td><strong>Status</strong></td>
						<td><strong>Action</strong></td><?php */?>
						
						<?php $j=0;
						while($user_select_rows1=$obj_db->fetchArray($user_select_res1)) {
							extract($user_select_rows1);
							$user_select_rows1 = remove_slashes($user_select_rows1);
							$i++;
				?>
				<tr>
					<td><a target="_blank" href="../view_property.php?id=<?php echo $user_select_rows1['id']; ?>"><img src="../photos/<?php if(file_exists("../photos/".$user_select_rows1['id'].".jpg")) echo $user_select_rows1['id'].'.jpg'; else echo "logo.png"; ?>" style="border:2px solid #ccc;" width="100px" height="65px" /></a></td>
						<td>
						  <?php echo $user_select_rows1['contact_state']; ?>, <?php echo $user_select_rows1['contact_city']; ?>, <?php echo $user_select_rows1['contact_zip_code']; ?> <?php if($user_select_rows1['contact_street']) echo ','.$user_select_rows1['contact_street']; ?>
						</td>
						<td>
						  <?php echo '10-000'.$user_select_rows1['id']; ?>
						</td>
						<td>
				<strong><a href="../view_property.php?id=<?php echo $user_select_rows1['id']; ?>"><?php $t=$user_select_rows1['type']; echo $typename[$t]; ?></a></strong>
							<br><?php echo $user_select_rows1['category']; ?>
							</td>
							<td>
							$<?php echo $user_select_rows1['price']; ?>
							</td>
							<td>
							<?php echo $user_select_rows1['bedrooms']; ?>
							</td><td>
							<?php echo $user_select_rows1['bathrooms']; ?>
							</td><td>
							<?php echo $user_select_rows1['living_space']; ?>
							</td>
						<?php /*?><td>
							<a href="index.php?p=ads&act=ap&aid=<?php echo $user_select_rows1['status'];?>&id=<?php echo $user_select_rows1['id'];?>"><?php if($user_select_rows1['status']==0) {?><img style="height:15px; width:15px;" src="images/C1.png" /><?php } else { ?><img style="height:15px; width:15px;" src="images/C2.png" /><?php } ?></a>
						</td>
						<td>
							<a href="index.php?p=edit&user_id=<?php echo $user_select_rows1['id'];?>" class="link">Edit</a> | <a href="<?php echo $page_url;?>&act=del&user_id=<?php echo $user_select_rows1['id'];?>" class="link" onclick="if(!confirm('Are you sure to delete this listing?')) return false;">Delete</a>
						</td><?php */?>
				</tr>
				<?php } //while end 
					//page number display
					if((int)$PageNos_Navigation["Total_Pages"] > 1) {
				?>
				<tr>
					<td  style="border:0px solid #CCCCCC; text-align:center;" colspan="4" bgcolor="#FFFFFF">			
						<?php display_pagenumbers(); ?>
					</td>
				</tr>
				<?php }} //if end ?>  
		  
		  
		  
		
		</table>
		<?php } else { ?>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="">
				<?php
					if(isset($_GET['location']) && ($_GET['action']=='Search')) {
					$user_select_query="select * from ".TABLE_POST." where id='".(int)$_GET['location']."' OR contact_city='".$_GET['location']."' OR contact_state='".$_GET['location']."' OR contact_zip_code='".(int)$_GET['location']."' AND status=1 ORDER by id DESC "; 
					} else {
					$user_select_query="select * from ".TABLE_POST." where copy =0 AND deleted=0 AND status=1 ORDER by id DESC ";
					}
					$user_select_srows=$obj_db->fetchNum($user_select_query);
					if(!$user_select_srows) {										
				?>
				<tr>
					<td height="25px" colspan="2" align="center" class="error">
						<b >No Listings.</b>
					</td>
				</tr>
				<?php } ?>
				<?php if($user_select_srows) { ?>
					<?php //PAGE NUMBERS USAGE
						$PageNos_Navigation = array("First_Last_Links"=>1, 
													"Page_Navigator"=>"page", 
													"Total_Records"=>$user_select_srows, 
													"Records_PerPage"=>8, 
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
					<tr>
						<td><strong>Image</strong></td>
						<td><strong>Property Address</strong></td>
						<td><strong>LP No.</strong></td>
						<td><strong>Property Type</strong></td>
						<td><strong>Asking</strong></td>
						<td><strong>BR</strong></td>
						<td><strong>BT</strong></td>
						<td><strong>SF</strong></td>
						<td><strong>Status</strong></td>
						<td><strong>Action</strong></td>
						
						<?php $j=0;
						while($user_select_rows=$obj_db->fetchArray($user_select_res)) {
							extract($user_select_rows);
							$user_select_rows = remove_slashes($user_select_rows);
							$i++;
				?>
				<tr>
					<td><a target="_blank" href="../view_property.php?id=<?php echo $user_select_rows['id']; ?>"><img src="../photos/<?php if(file_exists("../photos/".$user_select_rows['id'].".jpg")) echo $user_select_rows['id'].'.jpg'; else echo "logo.png"; ?>" style="border:2px solid #ccc;" width="100px" height="65px" /></a></td>
						<td>
						  <?php if($user_select_rows['address_des']) echo $user_select_rows['address_des'].','; 
						  else { echo $user_select_rows['contact_street'].',';
						  if($user_select_rows['contact_street_no']!=0) $user_select_rows['contact_street_no'].','; }
						  ?>
						  <?php echo $user_select_rows['contact_city']; ?>, <?php echo $user_select_rows['contact_state']; ?>, <?php echo $user_select_rows['contact_zip_code']; ?>
						</td>
						<td style="width:80px;">
						  <?php echo '10-000'.$user_select_rows['id']; ?>
						</td>
						<td>
					<strong><a href="../view_property.php?id=<?php echo $user_select_rows['id']; ?>"><?php $t=$user_select_rows['type']; echo $typename[$t]; ?></a></strong>
							<br><?php echo $user_select_rows['category']; ?>
							</td>
							<td>
							$<?php echo $user_select_rows['price']; ?>
							</td>
							<td>
							<?php echo $user_select_rows['bedrooms']; ?>
							</td><td>
							<?php echo $user_select_rows['bathrooms']; ?>
							</td><td>
							<?php echo $user_select_rows['living_space']; ?>
							</td>
						<td>
							<a href="index.php?p=ads&act=ap&aid=<?php echo $user_select_rows['status'];?>&id=<?php echo $user_select_rows['id'];?>"><?php if($user_select_rows['status']==0) {?><img style="height:15px; width:15px;" src="images/C1.png" /><?php } else { ?><img style="height:15px; width:15px;" src="images/C2.png" /><?php } ?></a>
						</td>
						<td>
							<a href="index.php?p=edit&user_id=<?php echo $user_select_rows['id'];?>" class="link">Edit</a> | <a href="<?php echo $page_url;?>&act=del&user_id=<?php echo $user_select_rows['id'];?>" class="link" onclick="if(!confirm('Are you sure to delete this listing?')) return false;">Delete</a>
						</td>
				</tr>
				<?php } //while end 
					//page number display
					if((int)$PageNos_Navigation["Total_Pages"] > 1) {
				?>
				<tr>
					<td  style="border:0px solid #CCCCCC; text-align:center;" colspan="4" bgcolor="#FFFFFF">			
						<?php display_pagenumbers(); ?>
					</td>
				</tr>
				<?php }} //if end ?>
			</table>
			<?php } ?>
		</div>