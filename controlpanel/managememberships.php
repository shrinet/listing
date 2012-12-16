<?php defined('ACCESS_SUBFILES') or die('Restricted access');
	require_once("classes/managememberships.php");
	$parent_show= "Membership Plan";

	$action = $_GET['action'];
	
	$id=(int)$_GET['id'];

	$page_url="index.php?p=mem";

	$page_url2="index.php?p=mem";	
	
	$obj_press = new press();

			
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

	<label>Name :</label>

	<span class="small_input"><input class="small" name="plan_name" type="text" value="<?php echo htmlentities($data['plan_name']);?>" /></span><br class="hid" />
<label>Price :</label>

	<span class="small_input"><input class="small" name="plan_price" type="text" value="<?php echo $data['plan_price'];?>" /></span><br class="hid" />
<!--	<label>Days:</label>

	<span class="small_input"><input class="small" name="plan_days" type="text" value="<?php // echo $data['plan_days'];?>" /></span><br class="hid" />
	
-->
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


	<li class="active"><a href="#" title="List"><span>List</span></a></li>

	<?php if($c) {?>

	<li><a href="<?php echo $page_url2;?>" title="Categories"><span>Back</span></a></li>

	<?php } ?>

</ul>

<div class="box">

	<table border="0" cellpadding="0" cellspacing="0" style="width:720px;">

		<?php			

			$catg_select_query="SELECT * FROM ".TABLE_PLANS." ORDER BY plan_id";

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

			<th class="col2">Plan Name</th>
			<th class="col3">Price</th>
<!--			<th class="col4">Days</th>
-->
			<th class="col5" style="text-align:center;">Edit</th>

		</tr>
<?php	

			$catg_select_query.=" LIMIT $StartCount, $PerPage ";					

			$catg_select_res=$obj_db->get_qresult($catg_select_query);

			while($catg_select_rows=$obj_db->fetchArray($catg_select_res)) {

		?>	

		<tr >



			<td><?php echo $j++;?></td>

			<td ><?php echo stripslashes($catg_select_rows['plan_name']);?></td>
			<td >$<?php echo stripslashes($catg_select_rows['plan_price']);?></td>
<!--			<td ><?php // echo stripslashes($catg_select_rows['plan_days']);?></td>
-->		  	<td class="action" width="20px">

				<ul>

					<li>

					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['plan_id'];?>" title="edit"></a>

					</li>


				</ul>

			</td>			

		</tr>

		<?php }?>

		

	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>



<?php }?>

	