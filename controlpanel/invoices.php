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
<?php if($_GET['act']=='view') { ?>
				<h2>View Invoice</h2>
				<ul class="tabs">
					<li class="active"><a href="#" title="Details"><span>View</span></a></li>
				</ul>
				<div class="box">
				<?php 
				  $invoice_select_query="select * from ".TABLE_ORDERS." where id=".$_GET['id'];  
    			  $invoice_select_srows=$obj_db->fetchRow($invoice_select_query);
				?>
				<fieldset>
				<table width="100%" cellspacing="1" cellpadding="8" border="0" bgcolor="#E7E7E7">
					<tr bgcolor="#F7F7F7">
						<td width="40px">
						 <b style="font-weight:bold;">S.No</b>
						  </td>
						   <td width="100px">
						<b style="font-weight:bold;">Invoice Number</b>
						  </td>
						  <td width="150px">
					   <b style="font-weight:bold;">Type of Service</b>
						  </td>
						  <td width="50px">
					   <b style="font-weight:bold;">Duration</b>
						  </td>
						  <td width="50px">
					 <b style="font-weight:bold;"> Total</b>
						  </td>
						  <td width="100px">
					 <b style="font-weight:bold;">User Details</b>
						  </td>
          			</tr>
					<tr bgcolor="#F7F7F7">
						<td>1.</td>
						<td>
							<?php echo '4312703'.$invoice_select_srows['id']; ?>
						</td>
						<td>
							<?php echo $invoice_select_srows['explination']; ?></span>
						</td>
						<td>							
							<?php if(($invoice_select_srows['total_amount']==40) || ($invoice_select_srows['total_amount']==50)) $days_new=60;
								  elseif(($invoice_select_srows['total_amount']==120) || ($invoice_select_srows['total_amount']==140)) $days_new=360;
								  echo $days_new.' days';
							?>
						</td>				
						<td><?php echo '$'.$invoice_select_srows['total_amount']; ?></td>
						<td><a target="_blank" href="index.php?p=users&user_id=<?php echo $invoice_select_srows['user_id'];?>&action=edit">See User Details</a></td>
					</tr>
					<tr bgcolor="#F7F7F7">
				  		<td>2.</td>
				  		<td colspan="3">
							Credit Balance
						</td>
						<td colspan="2">
							<?php echo '$'.$invoice_select_srows['credit_balance']; ?>
						</td>
				 </table>
				</fieldset>
				</div>					
<?php } else {
		$page_url = "index.php?p=invoices";
		if($_GET['act']=='del' && isset($_GET['user_id'])) {
		$delq="Delete from ".TABLE_USERS." where id=".$_GET['user_id'];
		$deld=mysql_query($delq);
			if($deld) redirect_page("index.php?p=invoices");
		} 
		
		?>
				<h2>Invoices</h2>
				
				<div class="box">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="">
				<?php
					        if($_POST['but_search']) {
							$invoice_id=substr($_POST['page_search'],7,7);
							$user_select_query="select * from ".TABLE_ORDERS." where id='".$invoice_id."'"; 
							}
							else $user_select_query="select * from ".TABLE_ORDERS." order by id desc";  
							
							$user_select_srows=$obj_db->fetchNum($user_select_query);
							if(!$user_select_srows) {										
						?>
						<br class="hid" />
						<tr>
							<td height="25px" colspan="2" align="center" class="error">
								<b >No Invoices.</b>
							</td>
						</tr>
						<?php } ?>
						<tr>
						<td colspan="7">
						<label>Search By Invoice,User name or Email:</label>
						<label>
						  <form method="post" id="frm2" action="">
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
							<strong>S.No</strong>
							</td>
							<td style="text-align:center">
								<strong>Invoice Number</strong>
							</td>
							<td style="text-align:center">
								<strong>Amount</strong>
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
								<a href="<?php echo $page_url;?>&id=<?php echo $user_select_rows['id'];?>&act=view"><?php echo '4312703'.$user_select_rows['id'];?></a>
							</td>
                  			<td style="text-align:center">						
							<?php echo '$'.$user_select_rows['amount']; ?>
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