<script>
	function submit2(){
		$(' #frm2 ').submit();
	}
</script> 
<?php defined('ACCESS_SUBFILES') or die('Restricted access');

			require_once("classes/zip_codes_add.php");

			$action = $_GET['action'];
			
			$id=(int)$_GET['id'];

			$page_url="index.php?p=zip_codes";

			$page_url2="index.php?p=zip_codes";	
			
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

			$parent_show="Advrtising With Us";					

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

	<label>Zip Code :</label>

	<span class="small_input"><input class="small" name="zip_code" type="text" value="<?php echo htmlentities($data['zip_code']);?>" /></span><br class="hid" />
	<label>Price :</label>

	<span class="small_input"><input class="small" name="price" type="text" value="<?php echo htmlentities($data['price']);?>" /></span><br class="hid" />

	

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
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="">
					<tr>
						<td colspan="4">
						<label>Search Zip Code:</label>
						<label>
						  <form method="post" id="frm2" action="index.php?p=zip_codes">
							<input class="small" name="page_search" type="text" value="<?php echo $_POST['page_search'];?>" />&nbsp;&nbsp;&nbsp;
							<input type="hidden" class="button1" name="but_search" value="Search"  />
							<a href="javascript:void();" onclick="$('#frm2').submit();" class="button" title="Submit"><span>Search</span></a>
							<span class="clear"></span> <br/>
						 </form>
						</label>
						</td>
					  </tr>
				<?php
					        if($_POST['but_search'])  $user_select_query="select * from ".TABLE_ZIP_CODES." where zip_code='".$_POST['page_search']."'"; 
							
							else $user_select_query="select * from ".TABLE_ZIP_CODES." ORDER BY id DESC";  
							
							$user_select_srows=$obj_db->fetchNum($user_select_query);
							if(!$user_select_srows) {										
						?>
						
						<tr>
							<td height="25px" colspan="2" align="center" class="error">
								<b >No Zip Codes Found.</b>
							</td>
						</tr>
						<?php } ?>
						
					  <?php if($user_select_srows) { ?>
						<tr>
						  <td colspan="3"><strong>Top 50 Search Codes</strong></td>
						</tr>
						<tr>
							<td style="text-align:center">
							<strong>S.No</strong>
							</td>
							<td style="text-align:center">
								<strong>Zip Code</strong>
							</td>
							<td style="text-align:center">
								<strong>Price</strong>
							</td>
							<td style="text-align:center">
								<strong>Action</strong>
							</td>
							
						</tr>
							<?php //PAGE NUMBERS USAGE
								$PageNos_Navigation = array("First_Last_Links"=>1, 
															"Page_Navigator"=>"page", 
															"Total_Records"=>$user_select_srows, 
															"Records_PerPage"=>20, 
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
								<?php $j=0;
								while($user_select_rows=$obj_db->fetchArray($user_select_res)) {
									extract($user_select_rows);
									$user_select_rows = remove_slashes($user_select_rows);
									$i++;
						?>
						<tr>
							<td style="text-align:center">
								<?php echo $i;?>
							</td>
							<td style="text-align:center">
								<b><?php echo $user_select_rows['zip_code']; ?></b>
							</td>
							<td style="text-align:center">
								$<?php echo $user_select_rows['price']; ?>
							</td>
							<td style="text-align:center">

								<li>
			
								<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $user_select_rows['id'];?>" title="edit"></a>
			
								</li>
			
								<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $user_select_rows['id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>
			
							</ul>
				
							</td>			
                  			
						</tr>
						<?php if($i==50) exit(); } //while end 
							//page number display
							if((int)$PageNos_Navigation["Total_Pages"] > 1) {
						?>
						<tr>
							<td  style="border:0px solid #CCCCCC; text-align:center"  colspan="7" bgcolor="#FFFFFF">			
								<?php display_pagenumbers(); ?>
							</td>
						</tr>
						<?php } //if end ?>
					</table>
					<p><?php if($ermsg){ 
				foreach($ermsg as $msg) { ?>
			  
					<p class="alert">
						<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $msg;?></span>
						<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>
					</p>
					<?php } ?>
				<?php } ?></p>
				</div>
<?php } } ?>			