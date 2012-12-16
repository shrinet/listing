<?php defined('ACCESS_SUBFILES') or die('Restricted access');

			require_once("classes/flag_adds.php");

			$action = $_GET['action'];
			
			$id=(int)$_GET['id'];

			$page_url="index.php?p=flag_adds";

			$page_url2="index.php?p=flag_adds";	
			
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

			$parent_show="FLAGGED ADDS";					

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

	<label>User ID :</label>

	<span class="small_input"><input class="small" name="user_id" type="text" value="<?php echo htmlentities($data['user_id']);?>" /></span><br class="hid" />
	<label>Property ID :</label>

	<span class="small_input"><input class="small" name="property_id" type="text" value="<?php echo $data['property_id'];?>" /></span><br class="hid" />

	<label>Flag Message:</label>

	<span class="small_input"><input class="small" name="flag_message" type="text" value="<?php echo $data['flag_message'];?>" /></span><br class="hid" />

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

			$catg_select_query="SELECT * FROM ".POCKETS_FLAG." ORDER BY id desc";

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
			<th class="col2">User ID</th>
			<th class="col2">Property Image</th>
			<th class="col2">Flag Message</th>
			<th class="col3" style="width:30px;">Flag Time</th>

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

		
		$flag_img= "../photos/".$catg_select_rows['property_id'].".jpg";
		if(!file_exists($flag_img)) $flag_img="../photos/logo.png"; 
		?>	

		<tr >

			<td><?php echo $j++;?></td>
			<td><?php echo stripslashes($catg_select_rows['user_id']);?></td>
			<td><a href="../view_property.php?id=<?php echo stripslashes($catg_select_rows['property_id']);?>" target="_blank"><img width="100px" height="50px" style="" src="<?php echo $flag_img; ?>"></a></td>
			<td><?php echo $catg_select_rows['flag_message'];?></td>
			<td><?php echo stripslashes($catg_select_rows['flag_time']);?></td>
		  	<td class="action">
					<li>
					<a class="edit" href="<?php echo $page_url;?>&action=edit&id=<?php echo $catg_select_rows['id'];?>" title="edit"></a>
					</li>
					<li><a class="delete" href="<?php echo $page_url;?>&action=delete&id=<?php echo $catg_select_rows['id'];?>" onclick="if(!confirm('Are you sure to delete this?')) return false;" title="delete"></a></li>
				</ul>

			</td>			

		</tr>

		<?php }?>

		

	</table>

	<p id="pagin"><?php if((int)$PageNos_Navigation["Total_Pages"] > 1) { display_pagenumbers();  } //if end ?>	</p>

	<?php } //if end ?>	

</div>



<?php }?>
<?php 
if($id && $action=="delete"){

				//$notdelids=" AND id not in (1,2,3,4,5,6,12,13,14,15,16,17)";
				
				
               $flag_select_query="select * from ".POCKETS_FLAG." where id =".$_GET['id'];
			   $flag_select_srows=$obj_db->fetchRow($flag_select_query);
			   
			   $listing_select_query="select * from ".TABLE_POST." where id =".$flag_select_srows['property_id'];
			   $listing_select_srows=$obj_db->fetchRow($listing_select_query);
			   
			  
			   $user_select_query="select * from ".TABLE_USERS." where id =".$listing_select_srows['user_id'];
			   $user_select_srows=$obj_db->fetchRow($user_select_query);
			   
			   $remove_credit_query="UPDATE ".TABLE_USERS." SET 
				               credit_balance= credit_balance-1
							   where id=".(int)$user_select_srows['id'];
			   $remove_credit_res=$obj_admin_db->get_qresult($remove_credit_query);
			   
			   $delete_query="UPDATE ".TABLE_POST." SET deleted=1 WHERE  id=".(int)$flag_select_srows['property_id'];
		       $deletedrow=$obj_admin_db->get_qresult($delete_query);
			  
			   $Body='<table border="0" cellpadding="0" cellspacing="0" width="840px" align="center" style="font-family:Tahoma; font-size:12px; 
				border:1px dotted #cccccc;" bgcolor="#FFFFFF">
						<tr>
							<td style="padding-left:15px;">
								<img src="http://listingpockets.com/images/logo.png" border="0" />
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">Dear '.$user_select_srows['first_name'].'&nbsp;'.$user_select_srows['last_name'].',</b>
							</td>
						</tr>
						<tr>
							<td bgcolor="#e6e9eb" height="30px">
								<b style="padding-left:15px;">
								Your post has been Flagged and removed for not following the guidelines of ListingPockets.com,Please review our 
								<a href="http://www.listingpockets.com/tos.php">terms & conditions</a>.
								<br>Please note that $1 credit has been removed off your account.If you feel that this was done in error please feel free to repost your add back to listing pocklets.com.you may call us at any time 866 226 - 9529 or please email us at   Customercare@ListingPockets.com					
			

								</b>
							</td>
						</tr>
						<tr height="10px">
							<td>
							</td>
						</tr>
						<tr>
							<td  style="padding-left:15px;line-height:25px;">
							
							<p>

                             
							Thank you ,<br>
							Listing Pockets Team <br>

							</p>
                         </td>
						
						</tr>
				</table>';		
				
				
				$From_Display = 'ListingPockets.com';
				$From_Email = ADMIN_EMAIL;
				$To_Email =$user_select_srows['email'];
				$CC = "";
				$BCC = "";
				$Sub =  'Listing Removed';
				$Message = $Body;
				$Format = 1;
				$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
				$obj_press->delete_press($id);
			}	
			
			//$obj_press->delete_press($id);

?>
	