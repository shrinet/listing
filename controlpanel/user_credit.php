<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
</script>
<script>
	function submit2(){
		$(' #frm2 ').submit();
	}
</script> 
<?php
if($_GET['action'] == 'edit') { 
$user_select_query="select * from ".TABLE_USERS." where id=".$_GET['user_id'];
$data=$obj_db->fetchRow($user_select_query);

if(isset($_POST['btn_press_save'])) {
			$ermsg=array();					
			
			if(count($ermsg)==0) {
								
					$notes_date = date("F j, Y, g:i a");
					
					$subject_insert_query="UPDATE ".TABLE_USERS." SET
					credit_balance='".mysql_real_escape_string($_POST['credit_balance'])."'
					WHERE id=".$_GET['user_id'];
					$subject_insert_result=$obj_admin_db->get_qresult($subject_insert_query);
							if($_POST['notes']) 
							{
							     $subject_insert_notes="INSERT ".TABLE_NOTES." SET
					                    notes='".$_POST['notes']."',
										user_id='".$_GET['user_id']."',
										notes_type='credit',
										notes_date='".$notes_date."',
										admin_name='".$_SESSION['alogname']."'";
										
								$subject_notes_result=$obj_admin_db->get_qresult($subject_insert_notes);								
							}
							
			}							
    redirect_page("index.php?p=user_credit");
}

?>
				<h2>Edit User Credit</h2>
				<ul class="tabs">
					
					<li class="active"><a href="#" title="Details"><span>Edit</span></a></li>
				</ul>
				<div class="box">
				<form method="post" id="frm1">
				<fieldset>
				
					<label>Credit Balance:</label>
					<?php 
					 $now = time(); 
						 $your_date = strtotime($data['payment_date']);
						 $datediff = abs($now - $your_date); 
						 
						 $dayscompleted= floor($datediff/(60*60*24));
						 if($dayscompleted=='0') $dayscompleted=1;
						 //echo $dayscompleted;
						 $daysleft=$data['duration_days']-$dayscompleted;
						 
						 if($data['subscription'] == 1 ) { $amount=19.99; $sub_days=60; }
						   elseif($data['subscription'] == 2 ) { $amount=29.99; $sub_days=60; }
								elseif($data['subscription'] == 3 ) { $amount=49.99; $sub_days=360; }
									  elseif($data['subscription'] == 5) { $amount=59.99; $sub_days=360; }
										 else { $amount=0; } 
				
					 
					 if($sub_days!='') { $paid_amount=($dayscompleted/$sub_days)*$amount; } 
					
					if($data['credit_balance']==0.00) $credit=$amount-$paid_amount;
					else $credit=$data['credit_balance'];
					?>
					<span class="small_input"><input class="small" name="credit_balance" type="text" value="<?php echo $credit;?>" /></span><br class="hid" />
					<label>Credit Comment:</label>
					<textarea name="notes"></textarea><br class="hid" />
					<label>Credit Comments:</label>
					<br /><br />
					<div style="width: 692px;height: 150px;overflow:-moz-scrollbars-vertical;overflow-y:auto; border:2px solid #0033FF;">
					<span style="font-size:14px;">
					  <?php 
					    $user_select_credit="select * from ".TABLE_NOTES." where user_id ='".(int)$_GET['user_id']."' AND notes_type='credit' ORDER BY id desc";
		                $user_select_srows1=$obj_db->fetchNum($user_select_credit);
						$user_res_srows1=$obj_db->get_qresult($user_select_credit);
						
						if(!$user_select_srows1) echo 'No Credit notes for this user';
						else {
						        $j=1;
								while($user_credit=$obj_db->fetchArray($user_res_srows1))
								{
								  echo $user_credit['notes'].' - '.$user_credit['notes_date'].'&nbsp;'.'By'.'&nbsp;'.$user_credit['admin_name'].'<br>'.'<br>';
								  $j++;
								}
						     }
					  ?>
					 </span><br class="hid" /> 
					</div>
				<p>&nbsp;</p><input type="hidden" class="button1" name="btn_press_save" value="Update"  />
			
				<a href="javascript:void();" onclick="submit1();" class="button" title="Submit"><span>Submit</span></a>
			
				<span class="clear"></span>
				</fieldset>
				</div>					
<?php } else {
		$page_url = "index.php?p=user_credit";
		if($_GET['act']=='del' && isset($_GET['user_id'])) {
		$delq="Delete from ".TABLE_USERS." where id=".$_GET['user_id'];
		$deld=mysql_query($delq);
			if($deld) redirect_page("index.php?p=users");
		} 
		
		?>
				<h2>Users Credits</h2>
				
				<div class="box">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="">
				<?php
					        if($_POST['but_search']) 
							$user_select_query="select * from ".TABLE_USERS." where first_name like '%".$_POST['page_search']."%' OR last_name like '%".$_POST['page_search']."%' OR email='".$_POST['page_search']."' order by id desc"; 
							
							else $user_select_query="select * from ".TABLE_USERS." order by id desc";  
							
							$user_select_srows=$obj_db->fetchNum($user_select_query);
							if(!$user_select_srows) {										
						?>
						<br class="hid" />
						<tr>
							<td height="25px" colspan="2" align="center" class="error">
								<b >No Users.</b>
							</td>
						</tr>
						<?php } ?>
						<tr>
						<td colspan="7">
						<label>Search By Email or Name:</label>
						<label>
						  <form method="post" id="frm2" action="index.php?p=user_credit">
							<input class="small" name="page_search" type="text" value="<?php echo $_POST['page_search'];?>" />&nbsp;&nbsp;&nbsp;
							<input type="hidden" class="button1" name="but_search" value="Search"  />
							<a href="javascript:void();" onclick="$('#frm2').submit();" class="button" title="Submit"><span>Search</span></a>
							<span class="clear"></span> <br/>
						 </form>
						</label>
						</td>
					  </tr>
					  <?php if($user_select_srows) { ?>
						<tr>
							<td style="text-align:center">
							<strong>	S.No</strong>
							</td>
							<td style="text-align:center">
								<strong>Full Name</strong>
							</td>
							<td style="text-align:center">
								<strong>Credit Balance</strong>
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
								<a href="<?php echo $page_url;?>&user_id=<?php echo $user_select_rows['id'];?>&action=edit"><?php echo $user_select_rows['first_name'].' '.$user_select_rows['last_name'];?></a>
							</td>
                  			<td style="text-align:center">						
							<?php 
									 $now = time(); 
									 $your_date = strtotime($user_select_rows['payment_date']);
									 $datediff = abs($now - $your_date); 
									 
									 $dayscompleted= floor($datediff/(60*60*24));
									 if($dayscompleted=='0') $dayscompleted=1;
									 //echo $dayscompleted;
									 $daysleft=$user_select_rows['duration_days']-$dayscompleted;
									 
									 if($user_select_rows['subscription'] == 1 ) { $amount=19.99; $sub_days=60; }
									   elseif($user_select_rows['subscription'] == 2 ) { $amount=29.99; $sub_days=60; }
											elseif($user_select_rows['subscription'] == 3 ) { $amount=49.99; $sub_days=360; }
												  elseif($user_select_rows['subscription'] == 5) { $amount=59.99; $sub_days=360; }
													 else { $amount=0; } 
							
								 
								       if($sub_days!='') { $paid_amount=($dayscompleted/$sub_days)*$amount; } 
								
							        	if($user_select_rows['credit_balance']==0.00) $credit=$amount-$paid_amount;
								        else $credit=$user_select_rows['credit_balance'];
								        echo '$'.number_format($credit,2); $credit_amount=number_format($credit,2);
							?>
							</td>
							
						</tr>
						<?php } //while end 
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
   <?php } }?>			