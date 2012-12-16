<?php defined('ACCESS_SUBFILES') or die('Restricted access');

			require_once("classes/discountcoupons.php");

			$action = $_GET['action'];
			
			$id=(int)$_GET['id'];

			$page_url="index.php?p=expiration";

			$page_url2="index.php?p=expiration";	
			
			$obj_press = new press();

			if($id && $action=="delete"){

				//$notdelids=" AND id not in (1,2,3,4,5,6,12,13,14,15,16,17)";
				$obj_press->delete_press($id);

			}	
					
			if($action =="add" || $action == "edit") {

				$mode ="Add";

				if($id  && $action=="edit")	{

					$data = $obj_press->get_press($id);

					$mode ="Edit" ;

				}

				

				if($_POST) $data=$_POST;

				$data = remove_slashes($data);

				$msg=array();	

				if(isset($_POST['btn_press_save'])) {

					extract($_POST);

					$msg = $obj_press->action_press($data,$id);

				}		

			}

			$parent_show="Expiration Accounts";					

?>

<h2><?php echo $parent_show.($mode?" : ".$mode:"");?></h2>

<?php if($action == "add" || $action == "edit") { ?>
<script>

	function submit1(){

		$(' #frm1 ').submit();

	}

</script> 

<ul class="tabs">

	<li class="active"><a href="#" title="Image"><span><?php echo $mode;?></span></a></li>

	<li><a href="<?php echo $page_url;?>" title="List"><span>Back</span></a></li>

</ul>

<form method="post" id="frm1" enctype="multipart/form-data" action="<?php echo $page_url."&action=".$action.($id?"&id=".$id:"");?>">

	<input name="catg_parent" type="hidden" value="<?php echo $c;?>" />

<fieldset>

	<label>Discount Coupon Name :</label>

	<span class="small_input"><input class="small" name="discount_name" type="text" value="<?php echo htmlentities($data['discount_name']);?>" /></span><br class="hid" />
	
	<p>&nbsp;</p><input type="hidden" class="button1" name="btn_press_save" value="Update"  />

	<a href="javascript:void();" onclick="submit1();" class="button" title="Submit"><span>Submit</span></a>

	<span class="clear"></span>

</fieldset>

</form>

<?php if($msg) foreach($msg as $ms){?>

<p class="alert">

	<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $ms;?></span>

	<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>

</p>

<?php } ?>


<?php } else { ?>
<ul class="tabs">

	<?php /*?><li><a href="<?php echo $page_url;?>&action=add<?php if($c) echo '&sub='.get_subcategory($c);?>" title="Add"><span>Add</span></a></li><?php */?>

	<li class="active"><a href="#" title="List"><span>List</span></a></li>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			

			$catg_select_query="SELECT * FROM ".TABLE_USERS." WHERE paid=1 AND subscription!=4 ORDER BY id DESC";

			$catg_select_srows=$obj_db->fetchNum($catg_select_query);
			
			
			if(!$catg_select_srows) {										

		?>	

		<tr>

			<td height="20px" align="center" class="error">

				<b >No Data.</b>

			</td>

		</tr>	

		</table>

		<?php } else { ?>

		<?php //PAGE NUMBERS USAGE

			$PageNos_Navigation = array("First_Last_Links"=>1, 

										"Page_Navigator"=>"page", 

										"Total_Records"=>$catg_select_srows, 

										"Records_PerPage"=>20, 

										"Page_Numbers"=>10, 

										"Page_url"=>$page_url, 

										"css_class"=>"link1", 

										"book_mark"=>""

								);

			

			get_pageno_numbers();	

			$StartCount = $PageNos_Navigation["StartCount"]; 

			$PerPage = $PageNos_Navigation["Records_PerPage"];

		 

			$j=(int)$StartCount+1;

			$i=0;	

			$notds=3;

		?>

		<tr>

			<th class="col1" style="width:30px;" >S.No</th>

			<th class="col2">Full Name</th>
			<th class="col2">Email</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$catg_select_res=$obj_db->get_qresult($catg_select_query);

			while($catg_select_rows=$obj_db->fetchArray($catg_select_res)) {
			
			
			 $now = time(); 
			 $your_date = strtotime($catg_select_rows['payment_date']);
			 $datediff = abs($now - $your_date); 
			 
			 $dayscompleted= floor($datediff/(60*60*24));
			 $daysleft=$catg_select_rows['duration_days']-$dayscompleted.'<br>';
			 $days=$catg_select_rows['duration_days'];

				/*extract($catg_select_rows);

				$i++;

				$subcatg_select_query="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_parent='".$catg_select_rows['catg_id']."' ORDER BY  catg_sorder, catg_title";

				$subcatg_select_row=$obj_db->fetchNum($subcatg_select_query);

				$purl="index.php?p=prod&c=".$catg_select_rows['catg_id'];

				if($subcatg_select_row) $purl=$page_url."&c=".$catg_select_rows['catg_id'];*/

		?>	

		<tr >

           <?php if($daysleft<=15) { ?>

			<td><?php echo $j++;?></td>

			<td><a href="index.php?p=users&user_id=<?php echo $catg_select_rows['id']; ?>&action=edit"><?php echo stripslashes($catg_select_rows['first_name']).'&nbsp;'.stripslashes($catg_select_rows['last_name']);?></a></td>
			<td><?php echo stripslashes($catg_select_rows['email']);?></td>
			
		  	<?php /*?><td class="action">

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['discount_id'];?>" title="edit"></a>

					</li>

					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['discount_id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>

				</ul>

			</td><?php */?>			

		</tr>

		<?php } } ?>

		

	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>

<div>
  &nbsp;&nbsp;
</div>

<h2>Expiration Listings</h2>


<ul class="tabs">

	<?php /*?><li><a href="<?php echo $page_url;?>&action=add<?php if($c) echo '&sub='.get_subcategory($c);?>" title="Add"><span>Add</span></a></li><?php */?>

	<li class="active"><a href="#" title="List"><span>List</span></a></li>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			

			$property_select_query="SELECT * FROM ".TABLE_POST." WHERE copy=0 and deleted=0 and status=1 ORDER BY id DESC";

			$property_select_srows=$obj_db->fetchNum($property_select_query);
			
			if(!$property_select_srows) {										

		?>	

		<tr>

			<td height="20px" align="center" class="error">

				<b >No Data.</b>

			</td>

		</tr>	

		</table>

		<?php } else { ?>

		<?php //PAGE NUMBERS USAGE

			$PageNos_Navigation = array("First_Last_Links"=>1, 

										"Page_Navigator"=>"page", 

										"Total_Records"=>$catg_select_srows, 

										"Records_PerPage"=>20, 

										"Page_Numbers"=>10, 

										"Page_url"=>$page_url, 

										"css_class"=>"link1", 

										"book_mark"=>""

								);

			

			get_pageno_numbers();	

			$StartCount = $PageNos_Navigation["StartCount"]; 

			$PerPage = $PageNos_Navigation["Records_PerPage"];

		 
			$j=(int)$StartCount+1;

			$i=0;	

			$notds=3;

		?>

		<tr>

			<th class="col1" style="width:30px;" >S.No</th>
			<th class="col2">LP No.</th>
			<th class="col2">Property Type</th>
			<th class="col2">User id</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$property_select_res=$obj_db->get_qresult($property_select_query);

			while($prpt_select_rows=$obj_db->fetchArray($property_select_res)) {
			
			
			 $now = time(); 
			 $your_date = strtotime($prpt_select_rows['post_date']);
			 $datediff = abs($now - $your_date); 
			 
			 $dayscompleted= floor($datediff/(60*60*24));
			 
			 if($prpt_select_rows['category']=='Rentals - Vacation') $daysleft=180-$dayscompleted.'<br>';
			 else $daysleft=60-$dayscompleted.'<br>';

				/*extract($catg_select_rows);

				$i++;

				$subcatg_select_query="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_parent='".$catg_select_rows['catg_id']."' ORDER BY  catg_sorder, catg_title";

				$subcatg_select_row=$obj_db->fetchNum($subcatg_select_query);

				$purl="index.php?p=prod&c=".$catg_select_rows['catg_id'];

				if($subcatg_select_row) $purl=$page_url."&c=".$catg_select_rows['catg_id'];*/

		?>	

		<tr >

           <?php if($daysleft<=15) { ?>

			<td><?php echo $j++;?></td>

			<td><a href="../view_property.php?id=<?php echo stripslashes($prpt_select_rows['id']);?>" target="_blank"><?php echo stripslashes($prpt_select_rows['id']);?></a></td>
			<td><?php echo stripslashes($prpt_select_rows['category']);?></td>
			<td><a href="index.php?p=users&user_id=<?php echo stripslashes($prpt_select_rows['user_id']);?>&action=edit" target="_blank"><?php echo stripslashes($prpt_select_rows['user_id']);?></a></td>
			
		  	<?php /*?><td class="action">

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['discount_id'];?>" title="edit"></a>

					</li>

					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['discount_id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>

				</ul>

			</td><?php */?>			

		</tr>

		<?php } } ?>

		

	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>

<div>&nbsp;</div>

<h2>Listings Posted in last 24 hours</h2>


<ul class="tabs">

	<?php /*?><li><a href="<?php echo $page_url;?>&action=add<?php if($c) echo '&sub='.get_subcategory($c);?>" title="Add"><span>Add</span></a></li><?php */?>

	<li class="active"><a href="#" title="List"><span>List</span></a></li>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			
            $yesterday=date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s") . " -1 day"));
			
			$property_select_query="SELECT * FROM ".TABLE_POST." WHERE copy=0 and deleted=0 and status=1 and post_date >='".$yesterday."' ORDER BY id DESC";

			$property_select_srows=$obj_db->fetchNum($property_select_query);
			
			if(!$property_select_srows) {										

		?>	

		<tr>

			<td height="20px" align="center" class="error">

				<b >No Data.</b>

			</td>

		</tr>	

		</table>

		<?php } else { ?>

		<?php //PAGE NUMBERS USAGE

			$PageNos_Navigation = array("First_Last_Links"=>1, 

										"Page_Navigator"=>"page", 

										"Total_Records"=>$catg_select_srows, 

										"Records_PerPage"=>20, 

										"Page_Numbers"=>10, 

										"Page_url"=>$page_url, 

										"css_class"=>"link1", 

										"book_mark"=>""

								);

			

			get_pageno_numbers();	

			$StartCount = $PageNos_Navigation["StartCount"]; 

			$PerPage = $PageNos_Navigation["Records_PerPage"];

		 
			$j=(int)$StartCount+1;

			$i=0;	

			$notds=3;

		?>

		<tr>

			<th class="col1" style="width:30px;" >S.No</th>
			<th class="col2">LP No.</th>
			<th class="col2">Property Type</th>
			<th class="col2">User id</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$property_select_res=$obj_db->get_qresult($property_select_query);

			while($prpt_select_rows=$obj_db->fetchArray($property_select_res)) {
			
			
?>	

		<tr >


			<td><?php echo $j++;?></td>

			<td><a href="../view_property.php?id=<?php echo stripslashes($prpt_select_rows['id']);?>" target="_blank"><?php echo stripslashes($prpt_select_rows['id']);?></a></td>
			<td><?php echo stripslashes($prpt_select_rows['category']);?></td>
			<td><a href="index.php?p=users&user_id=<?php echo stripslashes($prpt_select_rows['user_id']);?>&action=edit" target="_blank"><?php echo stripslashes($prpt_select_rows['user_id']);?></a></td>
			
		  	<?php /*?><td class="action">

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['discount_id'];?>" title="edit"></a>

					</li>

					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['discount_id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>

				</ul>

			</td><?php */?>			

		</tr>

		<?php }  ?>

		

	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>

<div>&nbsp;</div>

<h2>Accounts Registered in Last 24 hours</h2>

<ul class="tabs">

	<?php /*?><li><a href="<?php echo $page_url;?>&action=add<?php if($c) echo '&sub='.get_subcategory($c);?>" title="Add"><span>Add</span></a></li><?php */?>

	<li class="active"><a href="#" title="List"><span>List</span></a></li>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			

			$yesterday=date('Y-m-d H:i:s',strtotime(date("Y-m-d H:i:s") . " -1 day"));
			
			$catg_select_query="SELECT * FROM ".TABLE_USERS." WHERE paid=1 AND joindate >= '".$yesterday."' ORDER BY id DESC";

			$catg_select_srows=$obj_db->fetchNum($catg_select_query);
			
			
			if(!$catg_select_srows) {										
		?>	

		<tr>

			<td height="20px" align="center" class="error">

				<b >No Data.</b>

			</td>

		</tr>	

		</table>

		<?php } else { ?>

		<?php //PAGE NUMBERS USAGE

			$PageNos_Navigation = array("First_Last_Links"=>1, 

										"Page_Navigator"=>"page", 

										"Total_Records"=>$catg_select_srows, 

										"Records_PerPage"=>20, 

										"Page_Numbers"=>10, 

										"Page_url"=>$page_url, 

										"css_class"=>"link1", 

										"book_mark"=>""

								);

			

			get_pageno_numbers();	

			$StartCount = $PageNos_Navigation["StartCount"]; 

			$PerPage = $PageNos_Navigation["Records_PerPage"];

		 

			$j=(int)$StartCount+1;

			$i=0;	

			$notds=3;

		?>

		<tr>

			<th class="col1" style="width:30px;" >S.No</th>

			<th class="col2">Full Name</th>
			<th class="col2">Email</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$catg_select_res=$obj_db->get_qresult($catg_select_query);

			while($catg_select_rows=$obj_db->fetchArray($catg_select_res)) {
			

		?>	

		<tr >

			<td><?php echo $j++;?></td>

			<td><a href="index.php?p=users&user_id=<?php echo $catg_select_rows['id']; ?>&action=edit"><?php echo stripslashes($catg_select_rows['first_name']).'&nbsp;'.stripslashes($catg_select_rows['last_name']);?></a></td>
			<td><?php echo stripslashes($catg_select_rows['email']);?></td>
			
		  	<?php /*?><td class="action">

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['discount_id'];?>" title="edit"></a>

					</li>

					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['discount_id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>

				</ul>

			</td><?php */?>			

		</tr>

		<?php } ?>

		
	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>

<div>
  &nbsp;&nbsp;
</div>


<h2>Zip Code Registrations in Last 24 hours</h2>

<ul class="tabs">

	<?php /*?><li><a href="<?php echo $page_url;?>&action=add<?php if($c) echo '&sub='.get_subcategory($c);?>" title="Add"><span>Add</span></a></li><?php */?>

	<li class="active"><a href="#" title="List"><span>List</span></a></li>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			

			$yesterday=date('Y-m-d',strtotime(date("Y-m-d") . " -1 day"));
			
			$catg_select_query="SELECT * FROM ".TABLE_USERS." WHERE paid=1 AND paid_zip_code=1 AND zip_payment_date >= '".$yesterday."' ORDER BY id DESC";

			$catg_select_srows=$obj_db->fetchNum($catg_select_query);
			
			
			if(!$catg_select_srows) {										
		?>	

		<tr>

			<td height="20px" align="center" class="error">

				<b >No Data.</b>

			</td>

		</tr>	

		</table>

		<?php } else { ?>

		<?php //PAGE NUMBERS USAGE

			$PageNos_Navigation = array("First_Last_Links"=>1, 

										"Page_Navigator"=>"page", 

										"Total_Records"=>$catg_select_srows, 

										"Records_PerPage"=>20, 

										"Page_Numbers"=>10, 

										"Page_url"=>$page_url, 

										"css_class"=>"link1", 

										"book_mark"=>""

								);

			

			get_pageno_numbers();	

			$StartCount = $PageNos_Navigation["StartCount"]; 

			$PerPage = $PageNos_Navigation["Records_PerPage"];

		 

			$j=(int)$StartCount+1;

			$i=0;	

			$notds=3;

		?>

		<tr>

			<th class="col1" style="width:30px;" >S.No</th>

			<th class="col2">Full Name</th>
			<th class="col2">Email</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$catg_select_res=$obj_db->get_qresult($catg_select_query);

			while($catg_select_rows=$obj_db->fetchArray($catg_select_res)) {
			

		?>	

		<tr >

			<td><?php echo $j++;?></td>

			<td><a href="index.php?p=users&user_id=<?php echo $catg_select_rows['id']; ?>&action=edit"><?php echo stripslashes($catg_select_rows['first_name']).'&nbsp;'.stripslashes($catg_select_rows['last_name']);?></a></td>
			<td><?php echo stripslashes($catg_select_rows['email']);?></td>
			
		  	<?php /*?><td class="action">

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['discount_id'];?>" title="edit"></a>

					</li>

					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['discount_id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>

				</ul>

			</td><?php */?>			

		</tr>

		<?php } ?>

		
	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>

<div>
  &nbsp;&nbsp;
</div>


<h2>Zip codes Expiration Accounts</h2>

<ul class="tabs">

	<?php /*?><li><a href="<?php echo $page_url;?>&action=add<?php if($c) echo '&sub='.get_subcategory($c);?>" title="Add"><span>Add</span></a></li><?php */?>

	<li class="active"><a href="#" title="List"><span>List</span></a></li>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			

			$catg_select_query="SELECT * FROM ".TABLE_USERS." WHERE paid=1 AND paid_zip_code=1 ORDER BY id DESC";

			$catg_select_srows=$obj_db->fetchNum($catg_select_query);
			
			
			if(!$catg_select_srows) {										

		?>	

		<tr>

			<td height="20px" align="center" class="error">

				<b >No Data.</b>

			</td>

		</tr>	

		</table>

		<?php } else { ?>

		<?php //PAGE NUMBERS USAGE

			$PageNos_Navigation = array("First_Last_Links"=>1, 

										"Page_Navigator"=>"page", 

										"Total_Records"=>$catg_select_srows, 

										"Records_PerPage"=>20, 

										"Page_Numbers"=>10, 

										"Page_url"=>$page_url, 

										"css_class"=>"link1", 

										"book_mark"=>""

								);

			

			get_pageno_numbers();	

			$StartCount = $PageNos_Navigation["StartCount"]; 

			$PerPage = $PageNos_Navigation["Records_PerPage"];

		 

			$j=(int)$StartCount+1;

			$i=0;	

			$notds=3;

		?>

		<tr>

			<th class="col1" style="width:30px;" >S.No</th>

			<th class="col2">Full Name</th>
			<th class="col2">Email</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$catg_select_res=$obj_db->get_qresult($catg_select_query);

			while($catg_select_rows=$obj_db->fetchArray($catg_select_res)) {
			
			
			 $now = time(); 
			 $your_date = strtotime($catg_select_rows['zip_payment_date']);
			 $datediff = abs($now - $your_date); 
			 
			 $dayscompleted= floor($datediff/(60*60*24));
			 $daysleft=180-$dayscompleted.'<br>';

		?>	

		<tr >

           <?php if($daysleft<=15) { ?>

			<td><?php echo $j++;?></td>

			<td><a href="index.php?p=users&user_id=<?php echo $catg_select_rows['id']; ?>&action=edit"><?php echo stripslashes($catg_select_rows['first_name']).'&nbsp;'.stripslashes($catg_select_rows['last_name']);?></a></td>
			<td><?php echo stripslashes($catg_select_rows['email']);?></td>
			
		  	<?php /*?><td class="action">

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['discount_id'];?>" title="edit"></a>

					</li>

					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['discount_id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>

				</ul>

			</td><?php */?>			

		</tr>

		<?php } } ?>

		

	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>

<div>
  &nbsp;&nbsp;
</div>
<?php }?>	