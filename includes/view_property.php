<?php session_start();
    require_once("includes/DbConfig.php");
	require_once("includes/general.php");
	if(!$_GET['id']) redirect_page("login.php");
	if(!$_SESSION['user_log_id']) redirect_page("login.php");
	if($_SERVER['HTTP_REFERER']=="") $url="index.php"; else $url=$_SERVER['HTTP_REFERER'];
	$post_select_query="SELECT * FROM ".TABLE_POST." where id=".(int)$_GET['id'];
	$post_select_rows=$obj_db->fetchRow($post_select_query);
	$customer_select_query="SELECT * FROM ".TABLE_USERS." WHERE id=".(int)$_SESSION['user_log_id'];
	$customer_select_urow=$obj_admin_db->fetchRow($customer_select_query);
	$user_select_query="SELECT * FROM ".TABLE_USERS." where id=".(int)$_SESSION['user_log_id'];
	$user_select_rows=$obj_db->fetchRow($user_select_query);
	if($post_select_rows['user_id'] != $_SESSION['user_log_id']) {
	 
			if($user_select_rows['user_type']==3 ) redirect_page("upgrade.php");
	}		
	
	$path= $post_select_rows['contact_street'].', '.$post_select_rows['contact_city'].' '.$post_select_rows['contact_state'].' '.$post_select_rows['contact_zip_code'];
	$path = str_replace(" ","+",$path);
	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$path.'&sensor=false');
	$output= json_decode($geocode);
	$latitude = $output->results[0]->geometry->location->lat;
	$longitude = $output->results[0]->geometry->location->lng;
	if($latitude == '') $latitude=0;
	if($longitude == '') $longitude=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/skin.css" />
<title>Listing Pockets - <?php echo $paths; ?></title>
<script src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
<script type="text/javascript">

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        start: 3
    });
});

</script>
<script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyChM9xKR6bOy41hz2DoQJci9-BK9-l5SlI" type="text/javascript"></script>
<script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
    <script type="text/javascript">
    //<![CDATA[
	
    var WINDOW_HTML = '<?php if($latitude == 0 && longitude ==0) {	echo 'Incorrect Location';  } else { echo '<strong>'.$post_select_rows['headline'].'</strong> <br /><br />'; echo $post_select_rows['contact_street'].', '.$post_select_rows['contact_city'].' '.$post_select_rows['contact_state'].' '.$post_select_rows['contact_zip_code'];   } ?> ';	
	
    function loader(x,y) {
      if (GBrowserIsCompatible()) {
     
	var map = new GMap2(document.getElementById("map"));
map.addControl(new GSmallMapControl());
map.addControl(new GMapTypeControl());
map.setCenter(new GLatLng(x,y), 13);

var cafeIcon = new GIcon();
cafeIcon.image = "http://listingpockets.com/marker.png";
cafeIcon.shadow = "http://chart.apis.google.com/chart?chst=d_map_pin_shadow";
cafeIcon.iconSize = new GSize(30,30);
cafeIcon.shadowSize = new GSize(22, 20);
cafeIcon.iconAnchor = new GPoint(6, 20);
cafeIcon.infoWindowAnchor = new GPoint(5, 1);
markerOptions = { icon:cafeIcon };

var bounds = map.getBounds();
var southWest = bounds.getSouthWest();
var northEast = bounds.getNorthEast();
var lngSpan = northEast.lng() - southWest.lng();
var latSpan = northEast.lat() - southWest.lat();
  var point = new GLatLng(x,y);
	var marker = new GMarker(point, markerOptions);
	map.addOverlay(marker);
  GEvent.addListener(marker, "click", function() {
	marker.openInfoWindowHtml(WINDOW_HTML);
	  });
	marker.openInfoWindowHtml(WINDOW_HTML);
      }
    }
    //]]>
</script>
<script>
	$( document ).ready( function() {  
		loader(<?php echo $latitude;?>,<?php echo $longitude;?>);
		$('#')
	});
	
</script>
 <script language="javascript">
function savep(pid,id) {
	$('#savepalert').load("saveproperty.php?pid="+pid+"&id="+id);
}
function showdes() {
	$('.des').show();
}
function requestinfo(id)
{  <?php if($user_select_rows['user_type'] == 0 || $user_select_rows['user_type'] == 3) echo 'alert("Please Upgrade to Contact this Lister.");'; 
	else echo 'window.open("requestinfo.php?id="+id,"mywindow","menubar=0,resizable=1,width=657,height=530");'; ?>
}
function emailthis(id)
{	
	<?php if($user_select_rows['user_type'] == 0 || $user_select_rows['user_type'] == 3) echo 'alert("Please Upgrade to Email this Lister.");'; 
	 else echo 'window.open("email_this_listing.php?id="+id,"mywindow","menubar=0,resizable=1,width=657,height=460");'; ?>
}
function flag(pid)
{
	<?php if(!$_SESSION['user_log_id']) echo 'alert("Please login to flag this.");'; 
	 else echo 'window.open("flagalisting.php?pid="+pid,"mywindow","menubar=0,resizable=1,width=657,height=460");'; ?>
}
  var map = null;
		
  function getMap()
  {
	 map = new Microsoft.Maps.Map(document.getElementById('myMap'), {credentials: 'Ap2-nhdosWseq46ftAc9EpgRyTR8vkd-CV3ooPyQXj4-QyeDMKf_q_nXilrR_yds', center: new Microsoft.Maps.Location(<?php echo $latitude;?>,<?php echo $longitude;?>), mapTypeId: Microsoft.Maps.MapTypeId.birdseye, zoom: 18});
	 addDefaultInfobox();
  }
function addDefaultInfobox()
      {
        map.entities.clear();         
        var infoboxOptions = {title:'<?php echo '<strong>'.$post_select_rows['headline'].'</strong>'; ?>', description:'<?php if($latitude == 0 && longitude ==0) {	echo 'Incorrect Location';  } else { echo $post_select_rows['contact_street'].', '.$post_select_rows['contact_city'].' '.$post_select_rows['contact_state'].' '.$post_select_rows['contact_zip_code'];   } ?> '}; 
        var defaultInfobox = new Microsoft.Maps.Infobox(map.getCenter(), infoboxOptions );    
        map.entities.push(defaultInfobox);
      }

</script>

</head>

<body onunload="GUnload()" onload="getMap();">
	<div id="page">
	<?php include("header2.php"); ?>
		
	
		<div id="wrap">
	<?php if(!$_SESSION['user_log_id']) { ?>	
	<div class="bx by bh"><div class="b b1">
							<div class="branding ib fl"><a title="Pocket Lister" href="index.php"><img width="200" height="50" alt="Pocket Listings" src="images/logo.png"></a><h1>Off-Market Real Estate | Pocket Listings</h1></div><div class="ch ib">
     <p><a title="Join Listing Pockets" href="register.php">Join Listing Pockets</a> and reach beyond your brokerage and personal network.&nbsp;<br></p>
							</div>
					</div></div>
	<?php } ?>				
			<div class="hd" id="left"></div>
			<div id="main">
				<div class="hd" id="pc"></div>
				<div id="content">
						<div class="hd" id="ic"></div>
		<div class="bx by bc"><div class="b b6"><!--<h2>property</h2>--></div></div>
			<div class="c" id="cc">
			<table border="0" cellpadding="4" cellspacing="2" width="100%">
			<tr>
			
			 <td >
         <table border="0" cellpadding="4" cellspacing="2">
		<tr>
		 <td> <a href="<?php echo $url; ?>" class="back" style="padding-top:5px; padding-bottom:5px; color:#FFFFFF"> Back </a> </td>
		 <td> <a href="javascript:void(0);" onclick="savep(<?php echo $post_select_rows['id']; ?>,<?php if($_SESSION['user_log_id']) echo $_SESSION['user_log_id']; else echo '0'; ?>);" id="savep"><img src="images/save.jpg" /></a>
			
				</td>
				 <td> <a href="javascript:emailthis(<?php echo $post_select_rows['id']; ?>);"><img src="images/email.jpg" /></a></td>
				 <td><a href="javascript:requestinfo(<?php echo $post_select_rows['id']; ?>);"><img src="images/contact.jpg" /></a></td>
				 <td  ><a href="javascript:flag(<?php echo $post_select_rows['id']; ?>);"><img src="images/flag.jpg" /></a></td>
		</tr>
		 </table>
</td>
			</tr>
		<tr>
			 <td colspan="2"  class="pd-basic-title"> <b style="font-size:18px;">
			 <?php echo $user_select_rows['category'].'&nbsp;- &nbsp;';
									if($post_select_rows['anonymous'] != "Y") echo $post_select_rows['contact_street'].', &nbsp;'; else echo $post_select_rows['address_des'];
							    				echo ','.$post_select_rows['contact_city'].'&nbsp;'; 
												if($post_select_rows['anonymous'] != "Y") echo $post_select_rows['contact_state'].'&nbsp;';
												echo $post_select_rows['contact_zip_code']; ?></b>
				</td>
			</tr>
			 <tr>
			  <td width="392px"><img src="photos/<?php if(file_exists("photos/".$post_select_rows['id'].".jpg")) echo $post_select_rows['id']; else echo "default"; ?>.jpg" style="border:2px solid #ccc;" width="395px" height="263px" /><br />
			  <?php $image_uri="photos/";  ?>
	   <ul id="mycarousel" class="jcarousel-skin-tango">
				
    <li><img src="photos/<?php if(file_exists("photos/".$post_select_rows['id'].".jpg")) echo $post_select_rows['id']; else echo "default"; ?>.jpg" width="55" height="75" alt="" /></li>
	<?php for($i=2;$i<=20;$i++) { 
		$img_uri="photos/".$post_select_rows['id']."_".$i.".jpg";
		if(!file_exists($img_uri)) continue;
	?>
	<li><img src="<?php echo $img_uri;?>" width="55" height="75" alt="" /></li>
	<?php } ?>
	
  </ul>
			  
			  </td>
			   <td valign="top">
			           <table border="0" cellspacing="1" cellpadding="6" bgcolor="#CCCCCC" >
					    <tr>
					<td class="pd-basic-title " colspan="2">Basic Information </td>
					
					</tr>
               <tr bgcolor="F2EFEB">
			   
					<td width="90px">Price </td>
					<td ><b style="font-size:18px;">$<?php echo $post_select_rows['price']; ?> </b></td>
					</tr>
					 <tr bgcolor="F2EFEB" >
					<td>Bed(s): </td>
					<td><?php echo $post_select_rows['bedrooms']; ?> </td>
					</tr>
					 <tr  bgcolor="F2EFEB">
					<td>Bath(s): </td>
					<td><?php echo $post_select_rows['bathrooms']; ?></td>
					</tr>
					 <tr  bgcolor="F2EFEB">
					<td>
					Type: </td>
					<td><?php echo $post_select_rows['category'];  ?> </td>
					</tr>
					 <tr  bgcolor="F2EFEB">
					<td>
					Lot Size: </td>
					<td><?php echo $post_select_rows['lot_size'].' '.$post_select_rows['lot_type']; ?> </td>
					</tr>
					
					<tr  bgcolor="F2EFEB">
					<td>year built : </td>
					<td><?php echo $post_select_rows['year_built']; ?></td>
					</tr>
					<tr  bgcolor="F2EFEB">
					<td class="last">Date listed on ListingPockets: </td>
					<td class="last"><?php echo $post_select_rows['post_date']; ?></td>
					</tr>
           </table>
			   </td>
			 </tr>
			 <tr>
			 <td  class="pd-basic-title" valign="top" colspan="2"><b style="font-size:20px;">Description</b></td>
			 </tr>
			 <tr>
			  <td colspan="2">
			    <p><?php echo $post_select_rows['additional_msg']; ?></p>
			  </td>
			 </tr>
			 <tr>
				 <td valign="top">
				  <table border="0" cellpadding="6" cellspacing="0" align="left">
				  <tr>
				   <td  class="pd-basic-title">Property Address: &nbsp;</td>
				  </tr>
				  		<tr>
							<td style="border-bottom:1px dashed #ccc;">
							<?php echo $post_select_rows['contact_street'];?>
							</td>
							</tr>
							<tr>
							<td style="border-bottom:1px dashed #ccc;">
							
							<?php echo $post_select_rows['contact_city'];?>
							</td>
							</tr>
							<tr>
							<td style="border-bottom:1px dashed #ccc;">
							<?php echo $post_select_rows['contact_state'];?>
							</td>
							</tr>
						<tr>
							<td style="border-bottom:1px dashed #ccc;">
								<?php echo $post_select_rows['contact_zip_code']; ?>
							</td>
						</tr>
						<?php /*?><tr>
							<td style="border-bottom:1px dashed #ccc;">
								<?php echo $post_select_rows['address_des']; ?>
							</td>
						</tr><?php */?>
						<tr>
						</tr>
						<tr>
						 <td  class="pd-basic-title">Lister Details</td>
						</tr>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Contact Name : &nbsp;</strong>
						    <?php echo $post_select_rows['contact_name']; ?>
						 </td>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Category : &nbsp;</strong>
						   <?php echo $lister_select_rows['category']; ?>
						 </td>
						</tr>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Phone: </strong>
						<?php echo $post_select_rows['contact_phone']; ?>						 </td>
						</tr>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Email: &nbsp;</strong>
						<?php if($post_select_rows['anonymous']=='Y') echo 'Hidden'; else $post_select_rows['contact_email']; ?>
						 </td>
						</tr>
						<tr>
						</tr>
						  <tr>
								<td>
								<!-- MORTGAGE LOAN CALCULATOR BEGIN -->
								<script type="text/javascript">
								mlcalc_default_calculator = 'loan';
								mlcalc_currency_code = 'usd';
								mlcalc_amortization = 'year_nc';
								mlcalc_purchase_price = '300,000';
								mlcalc_down_payment = '10';
								mlcalc_mortgage_term = '30';
								mlcalc_interest_rate = '4.5';
								mlcalc_property_tax = '3,000';
								mlcalc_property_insurance = '1,500';
								mlcalc_pmi = '0.52';
								mlcalc_loan_amount = '150,000';
								mlcalc_loan_term = '15';
								</script><br />
								</td></tr>
								<tr>
								 <td  class="pd-basic-title">Property Amenities : &nbsp;</td>
								</tr>
								<tr>
								 <td >
									<ul>
									<?php $community= explode(",",$post_select_rows['community_features']);
									 //print_r($features);
										foreach($community as $comm) {
											echo '<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;">'. $comm. '</li>';
										} ?>
									</ul>	
								 </td>
								</tr>
								<tr>
								 <td class="pd-basic-title">Other Special Features : &nbsp;</td>
								</tr>
								<tr>
								 <td><strong></strong><br />
									<?php $otherspl= explode(",",$post_select_rows['special_features']);
										foreach($otherspl as $spl) {
											if (!is_null($spl)) echo $spl. '<br />';
										} ?>
								 </td>
								</tr>
								<tr>
								    <td class="pd-basic-title">Mortgage Calculator</td>
								</tr>
								<tr>
								<td>
								<script type="text/javascript">if(typeof jQuery == "undefined"){document.write(unescape("%3Cscript src='" + (document.location.protocol == 'https:' ? 'https:' : 'http:') + "//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));mlcalc_jquery_noconflict=1;};</script><div style="font-weight:normal;font-size:9px;font-family:Tahoma;padding:0;margin:0;border:0;text-align:center;background:transparent;color:#EEEEEE;width:300px;text-align:right;padding-right:10px;" id="mlcalcWidgetHolder"><script type="text/javascript">document.write(unescape("%3Cscript src='" + (document.location.protocol == 'https:' ? 'https://ssl.mlcalc.com' : 'http://cdn.mlcalc.com') + "/widget-wide.js' type='text/javascript'%3E%3C/script%3E"));</script>Powered by <a href="http://www.mlcalc.com/" style="font-weight:normal;font-size:9px;font-family:Tahoma;color:#EEEEEE;text-decoration:none;">Car Loan Calculator</a></div>
								<!-- MORTGAGE LOAN CALCULATOR END -->
								 </td>
						  </tr>
						  
						  
				  </table>
				  </td>
			  <td colspan="2" width="100%" valign="top">
				     <table border="0" cellpadding="6" cellspacing="0" width="100%">
						<tr>
						 <td  class="pd-basic-title">Property Details</td>
						</tr>
						<tr>
						 <td><strong>Property  Features : &nbsp;</strong>
						 	<ul>
						    <?php $features= explode(",",$post_select_rows['property_features']);
							 //print_r($features);
								foreach($features as $feature) {
									echo '<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;">'. $feature. '</li>';
								} ?>
								<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;"><strong>Guest House :</strong> <?php echo $post_select_rows['guesthouse']; ?></li>
								<?php if($customer_select_urow['subscription'] == "3") {
											echo '<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;"><strong>Commission :</strong>: '.$post_select_rows['commission'].'</li>';
											if($post_select_rows['commission_note']) echo '<li><strong>Note:</strong> '.$post_select_rows['commission_note'].'</li>';
									}  ?>
								<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;"><strong>Listed By:</strong> <?php if($customer_select_urow['subscription'] == "3") echo 'Agent/broker '; else echo 'Owner'; ?></li>
							</ul>	
						 </td>
						</tr>
						
						<div id="savepalert"></div>
				 </table>
				 </td>
			 </tr>
			 <tr><td  class="pd-basic-title" colspan="2">Property Map</td></tr>

			 	<td colspan="2">
					<?php if($_SESSION['user_log_id']) {
					
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
											 if($post_select_rows['anonymous'] =='Y') echo 'Anonymous';
											 else echo '<div id="map" style="width:550px; height:300px;"></div><div id="myMap" style="position:relative; width:550px; height:300px;"></div>';	
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>	<br />	
								 
								 
				</td>
			 </tr>
			</table>
	 <?php $dt = explode(" ",$post_select_rows['post_date']);
	 	   $pdate = explode("-",$dt[0]);
		   $ldt = explode(" ",$post_select_rows['last_refreshed']);
		   $lrdate = explode("-",$ldt[0]);
		   $view_count = (int)$post_select_rows['pageviews'] + 1;
		   $updatepageview = "UPDATE ".TABLE_POST." SET last_refreshed='".date("Y-m-d H-m-s")."', pageviews=".(int)$view_count." where id=".(int)$_GET['id'];
		   $obj_db->get_qresult($updatepageview);
	 ?>			
     <p><strong>Link to This Listing:</strong> &nbsp; &nbsp; <input type="text" value="http://listingpockets.com/view_listing.php?id=<?php echo $_GET['id']; ?>" size="40" style="min-height:10px;" /></p> 
	 <p><strong>Originally Received:</strong>&nbsp; <?php echo $pdate[1].'/'.$pdate[2].'/'.$pdate[0]; ?> <strong>&nbsp; &nbsp;&nbsp; &nbsp;Last Refreshed:</strong>&nbsp; <?php echo $lrdate[1].'/'.$lrdate[2].'/'.$lrdate[0];  echo '&nbsp;'.$ldt[1]; ?> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<strong>Total Views:</strong>&nbsp; <?php echo $view_count; ?></p>
        	</div>
        <div class="bx bz bc"><div class="b b6"><br></div></div>
     				</div>
			</div>
			<div class="hd" id="rel"></div>
			<div class="hd" id="right"></div>
		</div>	<?php include("footer2.php"); ?>

	</div>


</body>
</html>