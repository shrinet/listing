<?php defined('ACCESS_SUBFILES') or die('Restricted access');

			require_once("classes/discountcoupons.php");

			$action = $_GET['action'];
			
			$id=(int)$_GET['id'];

			$page_url="index.php?p=discountcoupons";

			$page_url2="index.php?p=discountcoupons";	
			
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

			$parent_show="DISCOUNT COUPONS";					

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
	<label>Discount Coupon Value :</label>

	<span class="small_input"><input class="small" name="discount_value" type="text" value="<?php echo $data['discount_value'];?>" /></span><br class="hid" />

	<label>Discount Coupon Code:</label>

	<span class="small_input"><input class="small" name="discount_coupon" type="text" value="<?php echo $data['discount_coupon'];?>" /></span><br class="hid" />
     
	 <label>Discount Coupon Type:</label>

	<select name="coupan_type" style="border:1px solid;">
	 <option value="$">$</option>
	 <option value="%">%</option>
	</select>

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

	<li><a href="<?php echo $page_url;?>&action=add<?php if($c) echo '&sub='.get_subcategory($c);?>" title="Add"><span>Add</span></a></li>

	<li class="active"><a href="#" title="List"><span>List</span></a></li>

	<?php if($c) {?>

	<li><a href="<?php echo $page_url2;?>" title="Categories"><span>Back</span></a></li>

	<?php } ?>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			

			$catg_select_query="SELECT * FROM ".TABLE_DISCOUNTCOUPONS." ORDER BY discount_id";

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

			<th class="col2">Discount Copon Name</th>
			<th class="col2">Discount Coupon Code</th>
			<th class="col2">Discount Coupon Value</th>

			<th class="col3" style="width:30px;">Action</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$catg_select_res=$obj_db->get_qresult($catg_select_query);

			while($catg_select_rows=$obj_db->fetchArray($catg_select_res)) {

				/*extract($catg_select_rows);

				$i++;

				$subcatg_select_query="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_parent='".$catg_select_rows['catg_id']."' ORDER BY  catg_sorder, catg_title";

				$subcatg_select_row=$obj_db->fetchNum($subcatg_select_query);

				$purl="index.php?p=prod&c=".$catg_select_rows['catg_id'];

				if($subcatg_select_row) $purl=$page_url."&c=".$catg_select_rows['catg_id'];*/

		?>	

		<tr >



			<td><?php echo $j++;?></td>

			<td><?php echo stripslashes($catg_select_rows['discount_name']);?></td>
			<td><?php echo stripslashes($catg_select_rows['discount_coupon']);?></td>
			<td><?php echo $catg_select_rows['coupan_type'];?><?php echo stripslashes($catg_select_rows['discount_value']);?></td>
		  	<td class="action">

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['discount_id'];?>" title="edit"></a>

					</li>

					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['discount_id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>

				</ul>

			</td>			

		</tr>

		<?php }?>

		

	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>



<?php }?>

	