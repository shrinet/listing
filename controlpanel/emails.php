<?php defined('ACCESS_SUBFILES') or die('Restricted access'); ?>
<style>
	#elm1_toolbargroup {
		width:670px;
	}
</style>
<style>
	#elm2_toolbargroup {
		width:670px;
	}
</style>
<!-- Load TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : 'tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "style,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,iespell,bullist,numlist,outdent,indent",
			theme_advanced_buttons2 : "styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_buttons5 : "",
			theme_advanced_buttons6 : "",
			
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",
			
			// Other options
		    relative_urls : false,

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	});
</script>
<style>
  .black_overlay
  {
  	  display: none;
	  position: fixed;
	  top: 0%;
	  left: 0%;
	  width: 100%;
	  height: 100%;
	  background-color: #000000;
	  z-index:1001;
	  -moz-opacity: 0.7;
	  opacity:.70;
	  filter: alpha(opacity=70); 
   }
  .white_content {
    background-color: #FFFFFF;
    border: 2px solid #00CC00;
    bottom: auto;
    display: none;
    height: 78%;
    left: 258.5px;
    overflow: auto;
    padding: 16px;
    position: fixed;
    right: auto;
    top: 88.5px;
    width: 782px;
    z-index: 1002;
  }  
</style>
<script language="javascript">
	$( document ).ready( function() {  
		
		$( '#fade_popup' ).click( function() {
			$('#light').show('slow');
			$('#fade').show();
		}); 
	});
	function submit_search(){
		$.post("ajax_search.php",$('#frm_popup2').serialize() , function(data){ eval(data); });
	}
	function submit_popup(){
		$.post("ajax_links.php",$('#frm_popup2').serialize() , function(data){ eval(data); });
	}
	
</script>

<!-- /TinyMCE -->
<?php 
$parent_show="SEND EMAILS";					
?>
<script>
	function submit1(){
		$(' #frm1 ').submit();
	}
</script>
<script language="javascript"> 
$( document ).ready( function() { 
	$( '#chk_all' ).click( function() {  
		var s=$( this ).is( ':checked' ) ? 'checked' : "";
		if(s) 		
			$( '.chk_now' ).attr( 'checked', 'checked');
		else
			$( '.chk_now' ).removeAttr( 'checked');	
	} );
} );	
</script>
<?php 
if(isset($_POST['btn_send_email'])) {

$ermsg=array();

if(!strlen(trim($_POST["email_state"])) AND !strlen(trim($_POST["email_city"])) AND !strlen(trim($_POST["email_member"])) AND !strlen(trim($_POST["reg_users"])) AND !strlen(trim($_POST["seltd_users"]))) $ermsg[]="Select user State or City or type or all users or some users<br>";
if(strlen(trim($_POST["email_state"])) AND strlen(trim($_POST["email_city"])) AND strlen(trim($_POST["email_member"])) AND !strlen(trim($_POST["reg_users"])) AND !strlen(trim($_POST["seltd_users"]))) $ermsg[]="Select any one of user State or City or type or all users or some users<br>";
if(!strlen(trim($_POST["mail_content"]))) $ermsg[]="Enter Content<br>";

if(!count($ermsg))
  {
     if($email_send_to_many) {
     $content_update_query="INSERT INTO ".TABLE_EMAIL_CONTENT." SET content='".mysql_real_escape_string($_POST['mail_content'])."'";							
	 $obj_db->get_qresult($content_update_query);	
   }
   
   $msge='<table width="700" border="0" cellspacing="3" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
				  <tr>
					<td width="22%" align="left" valign="top" colspan="2"><img src="http://listingpockets.com/images/logo.png" height="100px" width="230px"></td>
				  </tr>
				 
				  <tr>
					<td width="22%" align="left" valign="top">Content:</td>
					<td width="76%" align="left">'.stripslashes($_POST['mail_content']).'</td>
				  </tr>
				</table>';	
				
	  if(!strlen($_POST["email_member"]) && !strlen($_POST["email_city"]) && !strlen($_POST["seltd_users"])) { $email_send_many="select email from ".TABLE_USERS." WHERE state='".$_POST["email_state"]."'"; }
   elseif(!strlen($_POST["email_state"]) && !strlen($_POST["email_member"]) && !strlen($_POST["seltd_users"])) { $email_send_many="select email from ".TABLE_USERS." WHERE city='".$_POST["email_city"]."'"; }
   elseif(!strlen($_POST["email_state"]) && !strlen($_POST["email_city"]) && !strlen($_POST["seltd_users"])) { 
   if($_POST["email_member"]=='4') $email_send_many="select email from ".TABLE_USERS; 
   else $email_send_many="select email from ".TABLE_USERS." WHERE user_type='".$_POST["email_member"]."'"; 
   }
   
   elseif(!strlen($_POST["email_state"]) && !strlen($_POST["email_city"]) && !strlen($_POST["reg_users"]) && !strlen($_POST["email_member"])) { 
       foreach($_POST["seltd_users"] as $mail){
	   
						$From_Display = "Listing Pockets";
						$From_Email = "donotreply@listingpockets.com";
						$To_Email =$mail;
						$CC = "";
						$BCC = "";
						$Sub = "Listing Pockets";
						$Message = $msge;
						$Format = 1;
						$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
						
	   } $mmsg="Emails sent to Users.";
    } 
   else $email_send_many="select * from ".TABLE_USERS;
   
   $email_send_to_many=$obj_db->get_qresult($email_send_many);
   
   
	while($email_send_all_many=$obj_db->fetchArray($email_send_to_many)) {
		
						//add information to mail info@michaelslimo.com
						$mail= $email_send_all_many['email'];
						$From_Display = "Listing Pockets";
						$From_Email = "donotreply@listingpockets.com";
						$To_Email =$mail;
						$CC = "";
						$BCC = "";
						$Sub = "Listing Pockets";
						$Message = $msge;
						$Format = 1;
						$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
						if($msg)
						 {
							$mmsg="Emails sent to Users.";
							unset($_POST);
						}
				    }
				}
}

?>
<?php /*?><?php 
if(isset($_POST['btn_popup_users'])) {

     $content_update_querys="INSERT INTO ".TABLE_EMAIL_CONTENT." SET content='".mysql_real_escape_string($_POST['popup_mail_content'])."'";							
	 $obj_db->get_qresult($content_update_querys);	
		  
		  $msge='<table width="700" border="0" cellspacing="3" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;"><tr><td width="22%" align="left" valign="top" colspan="2"><img src="http://listingpockets.com/images/logo.png" height="100px" width="230px"></td></tr><tr><td width="22%" align="left" valign="top">Content:</td><td width="76%" align="left">'.stripslashes($_POST['popup_mail_content']).'</td></tr></table>';	      
   

			$From_Display = "Listing Pockets";
			$From_Email = "donotreply@listingpockets.com";
			$To_Email ='test63test@gmail.com';
			$CC = "";
			$BCC = "";
			$Sub = "Listing Pockets";
			$Message = $msge;
			$Format = 1;
			$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);	
			
			} $mmsg="Emails sent to Users3";
		  
		  
?>
<?php */?>
<h2><?php echo $parent_show; ?></h2>

<form method="post" id="frm1" enctype="multipart/form-data" action="">

	<input name="catg_parent" type="hidden" value="<?php echo $c;?>" />

<fieldset>
<table  border="0"  cellpadding="0" cellspacing="0" width="100%">
        <tr>
		  <td style="border:0px;">&nbsp;</td>
		</tr>
		<tr>
		    <td style="border:0px;"><input type="text" name="email_city" onfocus="this.value=''" value="Enter city" onblur="if(this.value=='') this.value='Enter city'" <?php if($_POST['email_city']) { ?>value="<?php echo $_POST['page_search']; ?>" <?php } else { ?>value="Enter city" <?php } ?> class="smallemail"/></td>
			<td  style="border:0px;"><input type="text" name="email_state" onfocus="this.value=''" value="Enter State" onblur="if(this.value=='') this.value='Enter State'" <?php if($_POST['email_state']) { ?>value="<?php echo $_POST['page_search']; ?>" <?php } else { ?>value="Enter State" <?php } ?> class="smallemail"/></td>
			<td  style="border:0px;"><select name="email_member" style="border:1px solid; height: 25px;">
	    <option value="">Select user type</option>
		<option value="0">FULL MEMBER</option>
		<option value="1">DUAL MEMBERS</option>
		<option value="2">AGENTS/BROKERS</option>
		<option value="3">INVESTOR/BANKS</option>
		<option value="4">To All Users</option>
	  </select></td>
	  
	    <td style="border:0px;">
		  <?php /*?><a href="javascript:void(0);" id="fade_popup" ><span>Select Users</span></a><?php */?>
						 
		</td>
		<td  style="border:0px;"><a href="index.php?p=emails_content" target="_blank">Sent Emails Content</a></td>
	</tr>
	
</table>
	
	
	<label>Content :</label>

	<textarea id="elm1" name="mail_content" cols="80" rows="50" style="width: 80%; height:500px;" class="tinymce"><?php echo $_POST['mail_content']; ?></textarea>

	<p>&nbsp;</p><input type="hidden" class="button1" name="btn_send_email" value="Update"  />

	<a href="javascript:void();" onclick="submit1();" class="button" title="Submit"><span>Submit</span></a>

	<span class="clear"></span>

</fieldset>

</form>

<span style="color:#FF0000"><?php if($mmsg) { echo $mmsg; } ?></span>
<?php if($ermsg) foreach($ermsg as $ms){?>

<p class="alert">

	<span class="txt"><span class="icon"></span><strong>Alert:</strong> <?php echo $ms;?></span>

	<a href="#" class="close" title="Close"><span class="bg"></span>Close</a>

</p>
<?php } ?>
 <div id="light" class="white_content">
					<table border="0" cellpadding="0" cellspacing="5" width="100%">
						<tr>
							<td align="left" style="padding-left:270px; border:0px;">&nbsp;
								
							</td>
							<td style=" border:0px; text-align:right" >
								<a onclick="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';" style="cursor:pointer;"><span style="font-size:16px;font-weight:bold;">Close(X)</span></a>
							</td>
						</tr>

						 <form method="post" name="frm_popup2" id="frm_popup2">
						
						<tr>
							<td style=" border:0px;" colspan="2" align="left">
								  <div id="mail_msg" style="color:#FF0000;" align="left">
									
									
									 <table align="center" border="1">
									 <tr>
									 <td style="border:0px;" colspan="5">
									 <table border="0" cellpadding="0" cellspacing="0">
									     <tr>
										   <td style=" border:0px;">&nbsp;</td> 
										   <td style=" border:0px;"><input type="text" id="search_name" name="search_name" class="smallemail" value=""/></td>
										   <td style=" border:0px;"><input type="hidden" class="button1" name="Search" value="Search"  />
										     <a href="javascript:void(0);" class="button" onclick="submit_search();" title="Send"><span>Search</span></a>	
										   </td>
										 </tr>
										 </table>
										 </td>
										 </tr>
										 <tr>
										   <td style=" border:0px;"><input type="radio" name="subscription" value="6" /></td><td style=" border:0px;">ALL</td>
										   <td style=" border:0px;"><input type="radio" name="subscription" value="1" /></td><td style=" border:0px;">FULL MEMBER</td>
										   <td style=" border:0px;"><input type="radio" name="subscription" value="2" /></td><td style=" border:0px;">DUAL MEMBERS</a></td>
										   <td style=" border:0px;"><input type="radio" name="subscription" value="3" /></td><td style=" border:0px;">BROKERS/AGENTS</td>
										   <td style=" border:0px;"><input type="radio" name="subscription" value="5" /></td><td style=" border:0px;"> INVESTOR/BANKS</td>
										 </tr>
									 </table>
									 
								  </div> 
								  
								     <div id="p_quote" style="border:1px solid #00FFFF;">
									 
									 <table>
									   <tr>
									     <td><input type="checkbox" id="chk_all" /></td>
										 <td><strong><b>Select All</b></strong></td>
									   </tr>
									   <tr>
									   		<td colspan="2" id="search_values">
											</td>
									   </tr>
									 </table>
									  
									  <table>
									    <tr>
										  <td>Content:</td>
										  <td><textarea id="elm2" name="popup_mail_content" cols="80" rows="50" style="width: 50%; height:300px;" class="tinymce"><?php echo $_POST['popup_mail_content']; ?></textarea></td>
										</tr>
									  </table>
											 									
										<div align="center" style="height:30px; padding-left:25px;">
											<p>&nbsp;</p><input type="hidden" class="button1" name="btn_popup_users" value="Send"  />
										   <a href="javascript:void(0);" onclick="$('#frm_popup2').submit();" class="button" title="Send"><span>Send Mail</span></a>										
										</div>
									 </div>
							</td>
						</tr>
						</form>
					</table>
				</div>
				<div id="fade" class="black_overlay"></div>	