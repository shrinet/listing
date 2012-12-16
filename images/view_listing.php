<?php session_start();
    require_once("includes/DbConfig.php");
	require_once("includes/general.php");
	if($_SERVER['HTTP_REFERER']=="") $url="index.php"; else $url=$_SERVER['HTTP_REFERER'];
	$user_select_query="SELECT * FROM ".TABLE_POST." where id=".(int)$_GET['id'];
	$user_select_rows=$obj_db->fetchRow($user_select_query);
	$customer_select_query="SELECT * FROM ".TABLE_USERS." WHERE id=".(int)$_SESSION['user_log_id'];
	$customer_select_urow=$obj_admin_db->fetchRow($customer_select_query);
	$path= $user_select_rows['contact_street'].', '.$user_select_rows['contact_city'].' '.$user_select_rows['contact_state'].' '.$user_select_rows['contact_zip_code'];
	$path = str_replace(" ","+",$path);
	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$path.'&sensor=false');
	$output= json_decode($geocode);
	//echo '<pre>';print_r($output);echo '</pre>';
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
<script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyChM9xKR6bOy41hz2DoQJci9-BK9-l5SlI"  type="text/javascript"></script>
<script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>

<script language="Javascript">
function bigimage(s,i)
{
	if(i==1) $('#view_img').attr('src','photos/'+s+'.jpg');
	else $('#view_img').attr('src','photos/'+s+'_'+i+'.jpg');
}
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        start: 3
    });
});

function savep(pid,id) {
	$('#savepalert').load("saveproperty.php?pid="+pid+"&id="+id);
	//$.post("ajax.php", { imagename: 'image.jpg' } ,function(data){ eval(data); });
}
	
    //<![CDATA[
	
    var WINDOW_HTML = '<?php if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) echo ''; if($latitude == 0 && longitude ==0) {	echo 'Incorrect Location';  } else { echo '<strong>'.$user_select_rows['headline'].'</strong> <br /><br />'; echo $user_select_rows['contact_street'].', '.$user_select_rows['contact_city'].' '.$user_select_rows['contact_state'].' '.$user_select_rows['contact_zip_code'];   } ?> ';	
	
    function loader(x,y) {
      if (GBrowserIsCompatible()) {
     
	var map = new GMap2(document.getElementById("map"));
map.addControl(new GSmallMapControl());
map.addControl(new GMapTypeControl());
map.setCenter(new GLatLng(x,y), 13);

// Create our "cafe" marker icon
var cafeIcon = new GIcon();
cafeIcon.image = "http://listingpockets.com/marker.png";
cafeIcon.shadow = "http://chart.apis.google.com/chart?chst=d_map_pin_shadow";
cafeIcon.iconSize = new GSize(30,30);
cafeIcon.shadowSize = new GSize(22, 20);
cafeIcon.iconAnchor = new GPoint(6, 20);
cafeIcon.infoWindowAnchor = new GPoint(5, 1);
// Set up our GMarkerOptions object literal
markerOptions = { icon:cafeIcon };

// Add 10 markers to the map at random locations
var bounds = map.getBounds();
var southWest = bounds.getSouthWest();
var northEast = bounds.getNorthEast();
var lngSpan = northEast.lng() - southWest.lng();
var latSpan = northEast.lat() - southWest.lat();
  var point = new GLatLng(x,y);
	var marker = new GMarker(point, markerOptions);
	map.addOverlay(marker);
  //map.addOverlay(new GMarker(point, markerOptions));
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
function requestinfo(id)
{  <?php if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) echo 'alert("Please Upgrade to Contact this Lister.");'; 
	else echo 'window.open("requestinfo.php?id="+id,"mywindow","menubar=0,resizable=1,width=657,height=530");'; ?>
}
function emailthis(id)
{	
	<?php if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) echo 'alert("Please Upgrade to Email this Lister.");'; 
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
        var infoboxOptions = {title:'<?php echo '<strong>'.$user_select_rows['headline'].'</strong>'; ?>', description:'<?php if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) echo ''; if($latitude == 0 && longitude ==0) {	echo 'Incorrect Location';  } else { echo $user_select_rows['contact_street'].', '.$user_select_rows['contact_city'].' '.$user_select_rows['contact_state'].' '.$user_select_rows['contact_zip_code'];   } ?> '}; 
        var defaultInfobox = new Microsoft.Maps.Infobox(map.getCenter(), infoboxOptions );    
        map.entities.push(defaultInfobox);
      }
	  
</script>

</head>

<body onunload="GUnload()" onload="getMap();">
	<div id="page">
	<?php include("header2.php"); ?>
		
	
		<div id="wrap">
	<?php if(!$_SESSION['user_log_id'])	{ ?>
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
		<div class="bx by bc"><div class="b b6"><!--<h2>Property Details</h2>--></div></div>
			<div class="c" id="cc">
			<table border="0" cellpadding="4" cellspacing="2">
			<tr>
			
			 <td colspan="2">
         <table border="0" cellpadding="4" cellspacing="2">
		<tr>
		 <td><a href="<?php echo $url; ?>" class="back" style="padding-top:5px; padding-bottom:5px; color:#FFFFFF">< Back </a> </td>
		 <td> <a href="javascript:void(0);" onclick="savep(<?php echo $user_select_rows['id']; ?>,<?php if($_SESSION['user_log_id']) echo $_SESSION['user_log_id']; else echo '0'; ?>);" id="savep"><img src="images/save.jpg" /></a>
			
				</td>
				 <td> <a href="javascript:emailthis(<?php echo $user_select_rows['id']; ?>);"><img src="images/email.jpg" /></a></td>
				 <td><a href="javascript:requestinfo(<?php echo $user_select_rows['id']; ?>);"><img src="images/contact.jpg" /></a></td>
				 <td  ><a href="javascript:flag(<?php echo $user_select_rows['id']; ?>);"><img src="images/flag.jpg" /></a></td>
		</tr>
		</table>
		</td>
		</tr>
			
		<tr>
			 <td colspan="2"  class="pd-basic-title"> <b style="font-size:18px;">
			 <?php echo $user_select_rows['category'].'&nbsp';
			 	if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												if($user_select_rows['anonymous'] != "Y") echo $user_select_rows['contact_street'].',&nbsp;';
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	
			?>
			</td></tr>
			<tr>
			 <td colspan="2"  class="pd-basic-title"> <b style="font-size:18px;">
			<?php
							  echo ucwords($user_select_rows['contact_state']).'&nbsp;';
							  echo ','.ucwords($user_select_rows['contact_city']).'&nbsp;'; 
							  if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3 && $_SESSION['user_log_id']) {
							  			if($user_select_rows['anonymous'] != "Y") echo $user_select_rows['contact_state'].'&nbsp;';
								} echo ','.$user_select_rows['contact_zip_code']; ?></b>
				</td>
			</tr>
			<?php if($user_select_rows['special_features']) { ?>
			<tr>
			 <td colspan="2"  class="pd-basic-title"> <b style="font-size:18px;">
			 <?php echo $user_select_rows['special_features']; ?>
			 </td>
			</tr>
			<?php } ?>
			
			<?php if($user_select_rows['headline']) { ?>
			<tr>
			 <td colspan="2"  class="pd-basic-title"> <b style="font-size:18px;">
			 <?php echo $user_select_rows['headline']; ?>
			 </td>
			</tr>
			<?php } ?>
		
			 <tr>
			  <td id="viewpop" width="392px"><img id="view_img" src="photos/<?php if(file_exists("photos/".$user_select_rows['id'].".jpg")) echo $user_select_rows['id']; else echo "default"; ?>.jpg" style="border:2px solid #ccc;" width="395px" height="263px" /><br/>
			  <?php $img_uri="photos/".$user_select_rows['id']."_".$i.".jpg";  ?>
			    <ul id="mycarousel" class="jcarousel-skin-tango">
				
    <li><img src="photos/<?php if(file_exists("photos/".$user_select_rows['id'].".jpg")) echo $user_select_rows['id']; else echo "default"; ?>.jpg" width="55" height="75" alt="" onclick="bigimage(<?php echo $user_select_rows['id']; ?>,1);" /></li>
	<?php for($i=2;$i<=20;$i++) { 
		$img_uri="photos/".$user_select_rows['id']."_".$i.".jpg";
		if(!file_exists($img_uri)) continue;
	?>
	<li><img src="<?php echo $img_uri;?>" width="55" height="75" alt="" onclick="bigimage(<?php echo $user_select_rows['id']; ?>,<?php echo $i;?>);" /></li>
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
					<td ><b style="font-size:18px;">
					<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo '$'.number_format($user_select_rows['price']);
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
					
					</b>
					</td>
					</tr>
					 <tr bgcolor="F2EFEB" >
					<td>Bed(s): </td>
					<td><?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['beds'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
					</td>
					</tr>
					 <tr  bgcolor="F2EFEB">
					<td>Bath(s): </td>
					<td><?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['bathrooms'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
					</td>
					</tr>
					 <tr  bgcolor="F2EFEB">
					<td>
					Type: </td>
					<td><?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['category'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
					</td>
					</tr>
					 <tr  bgcolor="F2EFEB">
					<td>
					Lot Size:  </td>
					<td><?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['lot_size'].' '.$user_select_rows['lot_type']; 
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
					</td>
					</tr>
					
					
					<tr  bgcolor="F2EFEB">
					<td>Year Built : </td>
					<td><?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['year_built'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
					</td>
					</tr>
					<tr  bgcolor="F2EFEB">
					<td class="last">No. Of Days On LP: </td>
					<td class="last"><?php 
					     $now = time(); 
						 $your_date = strtotime($user_select_rows['post_date']);
						 $datediff = abs($now - $your_date); 
						 $dayscompleted= floor($datediff/(60*60*24));
				
					           if($_SESSION['user_log_id']) echo $dayscompleted; 
								 elseif($_SESSION['user_log_id'] && $customer_select_urow['user_type'] == (0 || 3)) echo '<a href="upgrade.php">Upgrade Now</a>';
								 	 else echo '<a href="register.php">Members only -Sign up</a>'; ?>
					</td>
					</tr>
					
					 
           </table>
			   </td>
			 </tr>
			 <tr>
			 <td valign="top"  class="pd-basic-title" colspan="2"><b style="font-size:20px;">Description</b></td>
			 </tr>
			 <tr>
			  <td colspan="2">
						<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['headline'].'<br>'; 
												echo $user_select_rows['additional_msg'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
					</td>
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
						<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												if($user_select_rows['anonymous'] != "Y") echo $user_select_rows['contact_street']; else $user_select_rows['address_des'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
						</td>
							</td>
							</tr>
							<tr>
							<td style="border-bottom:1px dashed #ccc;">
							
						<?php echo 'City: '.$user_select_rows['contact_city']; ?>		
						</td>
							</tr>
							<tr>
							<td style="border-bottom:1px dashed #ccc;">
						<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
											if($user_select_rows['anonymous'] != "Y")	echo 'State: '.$user_select_rows['contact_state'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
						</td>
							</tr>
							<tr>
							<td style="border-bottom:1px dashed #ccc;">
						<?php echo 'Zip Code: '.$user_select_rows['contact_zip_code']; ?>		
						</td>
						</tr>
						<tr>
						 <td>&nbsp;</td>
						</tr>
						<tr>
						 <td  class="pd-basic-title">Lister Details</td>
						</tr>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Contact Name : &nbsp;</strong>
						<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['contact_name'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
						</td>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Category : &nbsp;</strong>
						<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['category'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
						</td>
						</tr>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Phone: </strong>
						<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
												echo $user_select_rows['contact_phone'];
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>		
						</td>
						</tr>
						<tr>
						 <td style="border-bottom:1px dashed #ccc;"><strong>Email: &nbsp;</strong>
						<?php if($_SESSION['user_log_id']) {
									if($user_select_rows['anonymous']=='Y' && $customer_select_urow['user_type'] != 0 && $customer_select_urow['user_type'] != 3) echo 'Hidden';
										 elseif($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) echo '<a href="upgrade.php">Upgrade Now</a>';
										 	 else echo $user_select_rows['contact_email']; 
							   } 
							   		else  echo '<a href="register.php">Members only -Sign up</a>';	?>
						 </td>
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
								    <td class="pd-basic-title">Mortgage Calculator</td>
								</tr>
								
								<tr>
								<td>
								<script type="text/javascript">if(typeof jQuery == "undefined"){document.write(unescape("%3Cscript src='" + (document.location.protocol == 'https:' ? 'https:' : 'http:') + "//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));mlcalc_jquery_noconflict=1;};</script><div style="font-weight:normal;font-size:9px;font-family:Tahoma;padding:0;margin:0;border:0;text-align:center;background:transparent;color:#EEEEEE;width:300px;text-align:right;padding-right:10px;" id="mlcalcWidgetHolder"><script type="text/javascript">document.write(unescape("%3Cscript src='" + (document.location.protocol == 'https:' ? 'https://ssl.mlcalc.com' : 'http://cdn.mlcalc.com') + "/widget-wide.js' type='text/javascript'%3E%3C/script%3E"));</script><a href="http://www.mlcalc.com/" style="font-weight:normal;font-size:9px;font-family:Tahoma;color:#EEEEEE;text-decoration:none;display:none;">tor</a></div>
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
						    <?php $features= explode(",",$user_select_rows['property_features']);
							 //print_r($features);
							if($_SESSION['user_log_id'] && $customer_select_urow['user_type'] != 0 && $customer_select_urow['user_type'] != 3 ) {
								foreach($features as $feature) {
										 echo '<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;">'. $feature. '</li>';
								}		 
							 } elseif($_SESSION['user_log_id'] && $customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
							  	echo '<a href="upgrade.php">Upgrade Now</a>';
							 	}
							 	else  { 
										echo '<a href="register.php">Members only -Sign up</a>';
									  }
								 ?>
								<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;"><strong>Guest House :</strong> <?php echo $post_select_rows['guesthouse']; ?></li>
								<?php if($customer_select_urow['subscription'] == "3") {
											echo '<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;"><strong>Commission :</strong>: '.$post_select_rows['commission'].''.$post_select_rows['commission_note'].'</li>';
											if($post_select_rows['commission_note']) echo '<li><strong>Note:</strong> </li>';
									}  ?>
								<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;"><strong>Listed By:</strong> <?php if($customer_select_urow['subscription'] == "3") echo 'Agent/broker '; else echo 'Owner'; ?></li>
							</ul>	
						 </td>
						</tr>
						<tr>
						 <td  class="pd-basic-title">Community Features : &nbsp;</td>
						</tr>
						<tr>
						 <td >
						 	<ul>
						    <?php $community= explode(",",$user_select_rows['community_features']);
							 //print_r($features);
							if($_SESSION['user_log_id'] && $customer_select_urow['user_type'] != 0 && $customer_select_urow['user_type'] != 3 ) {
								foreach($community as $comm) {
										 echo '<li style="border-bottom:1px dashed #ccc;line-height:25px;list-style:none;">'. $comm. '</li>';
								} 
							 } elseif($_SESSION['user_log_id'] && $customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
							  	echo '<a href="upgrade.php">Upgrade Now</a>';
							 	}
								 else {
										 echo '<a href="register.php">Members only -Sign up</a>';
									  } ?>
							</ul>	
						 </td>
						</tr>
						<tr>
						 <td class="pd-basic-title">Other Special Features : &nbsp;</td>
						</tr>
						<tr>
						 <td><strong></strong><br />
						    <?php $otherspl= explode(",",$user_select_rows['special_features']);
								if($_SESSION['user_log_id'] && $customer_select_urow['user_type'] != 0 && $customer_select_urow['user_type'] != 3 ) {	
							 foreach($otherspl as $spl) {
									if (!is_null($spl)) echo $spl. '<br />';
								} 
							 } elseif($_SESSION['user_log_id'] && $customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
							  	echo '<a href="upgrade.php">Upgrade Now</a>';
							 	}
								 else {
										 echo '<a href="register.php">Members only -Sign up</a>';
									  } ?>
						 </td>
						</tr>
				  </table>
				 <div id="savepalert"></div>
				 </td>
			  
			 </tr>
			 <tr><td  class="pd-basic-title" colspan="2">Property Map</td></tr>
             
			 	<td colspan="2">
					<?php if($_SESSION['user_log_id']) {
										if($customer_select_urow['user_type'] == 0 || $customer_select_urow['user_type'] == 3) {
												echo '<a href="upgrade.php">Upgrade Now</a>';
										} else {
											 if($user_select_rows['anonymous'] =='Y') echo 'Anonymous';
											 else echo '<div id="map" style="width:550px; height:300px;"></div><div id="myMap" style="position:relative; width:550px; height:300px;"></div>';	
										}
							  } else {
										echo '<a href="register.php">Members only -Sign up</a>';
							  }	 ?>	<br />	
								 
								 
				</td>
			 </tr>
			  <tr>
			   <td colspan="2">
			     <div style="padding-left:45px;" class="fb-comments" data-href="http://www.listingpockets.com/" data-num-posts="2" data-width="470"></div>
			   </td>
			 </tr>
			</table>
			
	 <?php $dt = explode(" ",$user_select_rows['post_date']);
	 	   $pdate = explode("-",$dt[0]);
		   $ldt = explode(" ",$user_select_rows['last_refreshed']);
		   $lrdate = explode("-",$ldt[0]);
		   $view_count = (int)$user_select_rows['pageviews'] + 1;
		   $updatepageview = "UPDATE ".TABLE_POST." SET last_refreshed='".date("Y-m-d H-m-s")."', pageviews=".(int)$view_count." where id=".(int)$_GET['id'];
		   $obj_db->get_qresult($updatepageview);
	 ?>			
     <p><strong>Link to This Listing:</strong> &nbsp; &nbsp; <input type="text" value="http://listingpockets.com/view_listing.php?id=<?php echo $_GET['id']; ?>" size="40" style="min-height:10px;" /></p> 
	 <p><strong>Originally Received:</strong>&nbsp; <?php echo $pdate[1].'/'.$pdate[2].'/'.$pdate[0]; ?> <strong>&nbsp; &nbsp;&nbsp; &nbsp;Last Refreshed:</strong>&nbsp; <?php echo $lrdate[1].'/'.$lrdate[2].'/'.$lrdate[0];  echo '&nbsp;'.$ldt[1]; ?> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<strong>Total Views:</strong>&nbsp; <?php echo $view_count; ?></p>
        	</div>
        <div class="bx bz bc"><div class="b b6">
		Broker/Agent or Listing Pockets does not guarantee the accurancy of the square footage, lot size or other information concerning the conditions or features of the property provided by the seller or obtained from Public Records or other sources.  Buyer is advised to independently verfiy the accuracy of all information through personal inspection and with appropriate professionals.  Copyright @ 2011 by Listing Pockets, LLC Information deemed reliable but not guaranteed.
		<br><br><br>
		</div></div>
     				</div>
			</div>
			<div class="hd" id="rel"></div>
			<div class="hd" id="right"></div>
		</div>	<?php include("footer2.php"); ?>

	</div>

</body>
</html>