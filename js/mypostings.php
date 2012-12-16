<?php session_start();
    require_once("includes/DbConfig.php");
	require_once("includes/general.php");
	if(!$_SESSION['user_log_id']) redirect_page("login.php");
	$customer_select_query="SELECT * FROM ".TABLE_USERS." WHERE id=".(int)$_SESSION['user_log_id'];
	$customer_select_urow=$obj_admin_db->fetchRow($customer_select_query);
	$page_url="mypostings.php";
	if($_GET['repost'] && $_SESSION['user_log_id']) {
		$delete_query="UPDATE ".TABLE_POST." SET status=1,post_date='".date("Y-m-d H:m:s")."' WHERE  id=".(int)$_GET['repost'];
		$deletedrow=$obj_admin_db->get_qresult($delete_query);
			if($deletedrow) redirect_page("mypostings.php");
	}
	if($_GET['delete'] && $_SESSION['user_log_id']) {
		$delete_query="UPDATE ".TABLE_POST." SET deleted=1 WHERE  id=".(int)$_GET['delete'];
		$deletedrow=$obj_admin_db->get_qresult($delete_query);
			if($deletedrow) redirect_page("mypostings.php");
			else $ermsg= "Not Deleted";
	}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listing Pockets - My Listings</title>
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.6.2.min.js"></script>
</head>
<body>
	<div id="page">
	<?php include("header2.php"); ?>
		</div>
		<div id="wrap">
			<div class="hd" id="left"></div>
			<div id="main">
				<div class="hd" id="pc"></div>
				<div id="content">
						<div class="hd" id="ic"></div>     
		<div class="bx by bc"><div class="b b1">
		
		 <h2>My Active Listings</h2>
         <table border="0" cellpadding="0" cellspacing="0" class="section">
          <tbody>
		  <tr>
		  	<td colspan="3" align="center" style="color:#FF0000;">
				<?php if($ermsg) echo $ermsg; ?>
			</td>
		  </tr>
		  <tr>
		  	<td colspan="3" align="center" >
				<table cellpadding="2" cellspacing="6" style="text-align:center">
					<tr>
						<td><a href="mypostings.php"><strong style="text-decoration:underline;">Property Listings</strong></a> &nbsp; | </td>
						<td><a href="mypostings_roomateads.php"><strong style="text-decoration:underline;">Roommate Listings</strong></a> &nbsp;  |</td>
						<td><a href="mypostings_trash.php"><strong style="text-decoration:underline;">Deleted</strong></a> &nbsp;  </td>
					</tr>
				</table>
			</td>			
		  </tr>
		  <tr>
           <td colspan="3">
		 <table cellspacing="0" cellpadding="5" border="0" width="100%" >
			<tbody>
			<?php
				$user_select_query="SELECT * FROM ".TABLE_POST." where copy=0 and deleted=0 and user_id=".$_SESSION['user_log_id']." order by id DESC";
				$map_query=$user_select_query;
				$user_select_srows=$obj_db->fetchNum($user_select_query);
				if(!$user_select_srows) {										
			?>
			<tr class="Pocket Listing e">
			<td >
			<center>No Listings Posted</center>
			</td>
			</tr>
			</tbody>
			</table>
			<?php } else { ?>
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
					<th align="center">
						<strong>S No.</strong>
					</th>
					<th align="center">
						<strong>Status</strong>
					</th>
					<th align="center">
					<strong>Manage</strong>
					</th>
					<th align="center">
						<strong>Posting</strong>
					</th>
					<th align="center">
						<strong>Posted In</strong>
					</th>
					<th align="center">
						<strong>Days Left</strong>
					</th>
					<th align="center">
						<strong>Posted Date</strong>
					</th>
				</tr>
				<?php 
				while($user_select_rows=$obj_db->fetchArray($user_select_res)) {
					extract($user_select_rows);
					$user_select_rows = remove_slashes($user_select_rows);
					$i++;
					$pdate=explode(" ",$user_select_rows['post_date']);
					 $now = time(); 
					 $your_date = strtotime($pdate[0]);
					 $datediff = abs($now - $your_date); 
					 $dayscompleted= floor($datediff/(60*60*24));
					 $daysleft=60-$dayscompleted;
				 ?>
				<tr>
					<td width="50px" align="center" style=" <?php if($user_select_rows['status']==1) echo "background-color:#C5CED9;"; else echo "background-color:#CC99FF"; ?>">
					<?php echo $j++; ?>
					</td>
					<td width="50px" align="center" style=" <?php if($user_select_rows['status']==1) echo "background-color:#C5CED9;"; else echo "background-color:#CC99FF"; ?>"> 
					<?php if($user_select_rows['status']== 1) echo 'Active'; else echo 'Pending'; ?>
					</td>
					<td width="100px" align="center" style=" <?php if($user_select_rows['status']==1) echo "background-color:#DDFFDD;"; else echo "background-color:#FFEEFF"; ?>">
					 <?php if($daysleft <= 0) echo '<a  href="mypostings.php?repost='.$user_select_rows['id'].'">Repost</a> &nbsp;'; ?>
					 <a  href="1.php?id=<?php echo $user_select_rows['id']; ?>">Edit</a> &nbsp; <a  href="mypostings.php?delete=<?php echo $user_select_rows['id']; ?>" >Delete</a>
					</td>
					<td width="200px" align="center" style=" <?php if($user_select_rows['status']==1) echo "background-color:#DDFFDD;"; else echo "background-color:#FFEEFF"; ?>">
					<?php echo substr($user_select_rows['headline'],0,100); ?> … 
					</td>
					<td align="center" width="100px" style=" <?php if($user_select_rows['status']==1) echo "background-color:#DDFFDD;"; else echo "background-color:#FFEEFF"; ?>">
					<?php echo $user_select_rows['contact_city']; ?> 
					</td>
					<td align="center" width="50px" style=" <?php if($user_select_rows['status']==1) echo "background-color:#DDFFDD;"; else echo "background-color:#FFEEFF"; ?>"> 
						<?php 
						 
						 if($daysleft <= 0) echo '<span style="color:#FF0000" >Expired</span>'; else echo $daysleft;
						?>
					</td>
					<td align="center"  width="100px" style=" <?php if($user_select_rows['status']==1) echo "background-color:#DDFFDD;"; else echo "background-color:#FFEEFF"; ?>">
					<?php $date=explode(" ",$user_select_rows['post_date']);
						  $date_time=explode(":",$date[1]);	
						  echo $date[0].' '.$date_time[0].':'.$date_time[1]; ?>
					</td>
				</tr>
				<?php } //while end  ?>
			</tbody>
			</table>
				   </td>
				  </tr>
				  <tr>
					<td>
					</td>
				  </tr>
				 </tbody>
			<tr>
				<td>
					<?php	//page number display
					if((int)$PageNos_Navigation["Total_Pages"] > 1) {
				?>
				<span class="pg"> <strong><?php display_pagenumbers(); ?></strong></span>
			<?php } ?>
				</td>
			</tr>
		<?php } //if end ?>
		 </table>
        </div></div>
        <div class="bx bz bc"><div class="b b1"><br></div></div>
     				</div>
			</div>
			<div class="hd" id="rel"></div>
			<div class="hd" id="right"></div>
		</div>		<?php include("footer2.php"); ?>
	</div>
</body>
</html>