<?php
	//GLOBAL FUNCTIONS
	
	///
	// Redirect Page without header function
	if(!function_exists("redirect_page")) {
		function redirect_page($page){
			echo '<meta http-equiv="REFRESH" content="0;url='.$page.'">';
			exit;
		}
	}
	// Redirect Page with header function
	if(!function_exists("redirect_url")) {
		function redirect_url($page){
			header("location: ".$page);
			exit;
		}
	}
	
	//current date time
	if(!function_exists("curr_time")) {
		function curr_time(){
			date_default_timezone_set('Asia/Calcutta');
			return time();
		}
	}
	
	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		$p = $pageURL;
		$p = explode("/",$p);
		unset($p[count($p)-1]);
		$pageURL = implode("/",$p);
		return $pageURL;
	}
	
	
	
	////Image Thumb
	if(!function_exists("make_thumb")) {
		function make_thumb($img_name,$filename,$new_w,$new_h,$ext)
		{
			//get image extension.
			//$ext=getExtension($img_name);
			//creates the new image using the appropriate function from gd library
			//echo $ext;
			if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))
				$src_img=imagecreatefromjpeg($img_name);
			
			if(!strcmp("png",$ext))
				$src_img=imagecreatefrompng($img_name);
	
			if(!strcmp("GIF",$ext) || !strcmp("gif",$ext))
				$src_img=imagecreatefromgif($img_name);
		
			//gets the dimmensions of the image
			$old_x=imagesx($src_img);
			$old_y=imagesy($src_img);
			
			// next we will calculate the new dimmensions for the thumbnail image
			// the next steps will be taken:
			// 1. calculate the ratio by dividing the old dimmensions with the new ones
			// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
			// and the height will be calculated so the image ratio will not change
			// 3. otherwise we will use the height ratio for the image
			// as a result, only one of the dimmensions will be from the fixed ones
			/*$ratio1=$old_x/$new_w;
			$ratio2=$old_y/$new_h;
			if($ratio1>$ratio2)
			{
				$thumb_w=$new_w;
				$thumb_h=$old_y/$ratio1;
			}
			else
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x/$ratio2;
			}*/
			$thumb_w=$new_w;
			$thumb_h=$new_h;
			
			
			// we create a new image with the new dimmensions
			$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
			
			// resize the big image to the new created one
			imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
			
			// output the created image to the file. Now we will have the thumbnail into the file named by $filename
			if(!strcmp("png",$ext))
				imagepng($dst_img,$filename);
			else
				imagejpeg($dst_img,$filename);
			
			//destroys source and destination images.
			imagedestroy($dst_img);
			imagedestroy($src_img);
		}
	}
	
	
	
	//SEND MAIL
	//STARTING ********
	//Sending mail function
	if(!function_exists("SendMail")) {
		function SendMail($myName,$myFrom,$myTo, $myCCList, $myBCCList, $mySubject,$myMsg, $MailFormat)
		{
			if(!isset($MailFormat) || ($MailFormat!=0 && $MailFormat!=1))
				$MailFormat = 1;
			 
			if($MailFormat==1)
			{
				$myMsgTop = "<table border='0' cellspacing='0' cellpadding='2' width='95%'>
					<tr><td><font face='verdana' size='2'>";
			
				$myMsgBottom = "</font></td></tr></table>";
			}
			else
			{
				$myMsg = strip_tags($myMsg);
				//$myMsg = str_replace("\n","",$myMsg);
				$myMsg = str_replace("\t","",$myMsg);
				$myMsg = str_replace("&nbsp;","",$myMsg);
				$myMsgTop = "";
				$myMsgBottom = "";
			}
			
			$headers = "From: $myName <$myFrom>\n";
			$headers .= "X-Sender: <$myFrom>\n";
			$headers .= "X-Mailer: PHP\n"; // mailer
			$headers .= "Return-Path: <$myFrom>\n";  // Return path for errors
		
			if($MailFormat == 1)
				$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type
		
			if(isset($myCCList) && strlen(trim($myCCList)) > 0)
				$headers .= "cc: $myCCList\n"; 
		
			if(isset($myBCCList) && strlen(trim($myBCCList)) > 0)
				$headers .= "bcc: $myBCCList\n"; 
		
			$receipient = $myTo;
			$subject = $mySubject;
			$message = $myMsgTop.$myMsg.$myMsgBottom;		
			
			$Success=@mail($receipient,$subject,$message,$headers);	
			return $Success;
			//return 1;
		}
	}	
	
	///
	//remove slashes from array or value
	if(!function_exists("remove_slashes")) {
		function remove_slashes($content) {
			if(is_array($content)) {
				foreach($content as $cind=>$cval) {
					if(is_array($content[$cind]))
						$content[$cind] = remove_slashes($content[$cind]);
					else
						$content[$cind] = stripslashes($cval);
				}
			} else 
				$content = stripslashes($content);
			return $content;
		}	 
	}
	
	///
	//remove slashes and convert them htmlentries from array or value
	if(!function_exists("remove_slashes_add_htmlentries")) {
		function remove_slashes_add_htmlentries($content) {
			if(is_array($content)) {
				foreach($content as $cind=>$cval) {
					if(is_array($content[$cind]))
						$content[$cind] = remove_slashes($content[$cind]);
					else
						$content[$cind] = stripslashes(htmlentities($cval));
				}
			} else 
				$content = stripslashes(htmlentities($content));
			return $content;
		}	 
	}
	
	///
	//remove slashes and convert them htmlentries from array or value
	if(!function_exists("htmlentries")) {
		function htmlentries($content) {
			if(is_array($content)) {
				foreach($content as $cind=>$cval) {
					if(is_array($content[$cind]))
						$content[$cind] = htmlentries($content[$cind]);
					else
						$content[$cind] = htmlentities($cval);
				}
			} else 
				$content = htmlentities($content);
			return $content;
		}	 
	}
	
	
	
	///
	//Mail body structure
	if(!function_exists("mail_body_structure")) {
		function mail_body_structure($body_content) {			
			
			$body_content='<table border="0" cellpadding="0" cellspacing="0" width="800px;" style="font-family:Arial; font-size:13px; border:1px solid gray;" align="center">				
						<tr>
							<td bgcolor="#0099FF" style="color:#FFFFFF; font-weight:bold;" width="800px"><a href="'.SITE_NAME.'">'.SITE_NAME.'</a></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="left" style="padding-left:10px;">
								'.$body_content.'
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="left"><a href="'.SITE_URL.'">'.SITE_NAME.'</a></td>
						</tr>
					</table>';		
			return $body_content;	
		}	
	}	
	
	///
	//Generate a string with random aplabets and numbers
	if(!function_exists("random_alpha")) {
		function random_alpha($digits)
		{
			srand ((double) microtime() * 10000000);
			//Array of alphabets
			$input = array (1,2,3,4,5,6,7,8,9,0,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			
			$random_generator="";// Initialize the string to store random numbers
			for($i=1;$i<$digits+1;$i++){ // Loop the number of times of required digits
			
				if(rand(1,2) == 1){// to decide the digit should be numeric or alphabet
				// Add one random alphabet 
				$rand_index = array_rand($input);
				$random_generator .=$input[$rand_index]; // One char is added
				
				}else{
				
				// Add one numeric digit between 1 and 10
				$random_generator .=rand(1,10); // one number is added
				} // end of if else
			
			} // end of for loop 
			
			return $random_generator;
		} // end of function
	}	
	
	//GET PAGE NUMBERS					
	function get_pageno_numbers() {
		global $PageNos_Navigation;
		$PageNos_Navigation["Page_Number"] = 1;
		$PageNos_Navigation["Page_url"] .= (strstr($PageNos_Navigation["Page_url"],"?")?"&":"?");		
		
		$PageNos_Navigation["Page_Number"] = ((int)$_GET[$PageNos_Navigation["Page_Navigator"]]?(int)$_GET[$PageNos_Navigation["Page_Navigator"]]:1);
	
		$StartCount = ((int)$PageNos_Navigation["Page_Number"]-1)*(int)$PageNos_Navigation["Records_PerPage"]; 
		if($StartCount<0) $StartCount = 0;
		
		$PageNos_Navigation["StartCount"] = $StartCount;
		
		$PageNos_Navigation["Page_Start"] = ((int)$PageNos_Navigation["Page_Number"]-1) - (((int)$PageNos_Navigation["Page_Number"]-1) % (int)$PageNos_Navigation["Page_Numbers"]) + 1 ;	
		
		$TotalPages = (int)$PageNos_Navigation["Total_Records"]/(int)$PageNos_Navigation["Records_PerPage"];	
		$k = (int)$PageNos_Navigation["Total_Records"] - floor($TotalPages)*(int)$PageNos_Navigation["Records_PerPage"];		
		if($k!=0) $TotalPages = floor($TotalPages)+1;
		$PageNos_Navigation["Total_Pages"] = $TotalPages;
		//echo "<pre>";print_r($PageNos_Navigation);echo "<pre>";			
	}	
	
	//DISPLAY PAGE NUMBERS 
	function display_pagenumbers() {
		global $PageNos_Navigation;
		$bookmark="";
		if(isset($PageNos_Navigation["book_mark"])) 
			if($PageNos_Navigation["book_mark"]<>"") $bookmark="#".$PageNos_Navigation["book_mark"];
		
		if((int)$PageNos_Navigation["Total_Pages"] > 1)
		{
			if($PageNos_Navigation["First_Last_Links"]) 		
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=1'.$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">First</a> ';		
			if($PageNos_Navigation["Page_Number"] > $PageNos_Navigation["Page_Numbers"]) 		
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . ((int)$PageNos_Navigation["Page_Start"]-1) . $bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">Previous</a> ';
			for($i = 1, $j = (int)$PageNos_Navigation["Page_Start"]; $i<=(int)$PageNos_Navigation["Page_Numbers"] && $j<=(int)$PageNos_Navigation["Total_Pages"]; $j++, $i++)
			{
				$f1 = $f2 = "";
				if($j==(int)$PageNos_Navigation["Page_Number"]) { 
					$f1 = "<font color='#0066CC'>"; 
					$f2 = "</font>"; 
				}
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $j .$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">&nbsp;' . $f1 . '&nbsp;' . $j . '&nbsp;' . $f2 . '&nbsp;</a> ';
			}
			if(((int)$PageNos_Navigation["Page_Start"]+(int)$PageNos_Navigation["Page_Numbers"])<=(int)$PageNos_Navigation["Total_Pages"])
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $j .$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">Next</a> ';
			if($PageNos_Navigation["First_Last_Links"])	
				echo '  <a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $PageNos_Navigation["Total_Pages"] .$bookmark.'"  class="' . $PageNos_Navigation["css_class"] . '">Last</a>  ';		
		}			
	}
	//DISPLAY PAGE NUMBERS 
	function display_pagenumbers1() {
		global $PageNos_Navigation;
		$bookmark="";
		if(isset($PageNos_Navigation["book_mark"])) 
			if($PageNos_Navigation["book_mark"]<>"") $bookmark="#".$PageNos_Navigation["book_mark"];
		
		if((int)$PageNos_Navigation["Total_Pages"] > 1)
		{
			if($PageNos_Navigation["First_Last_Links"]) 		
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=1'.$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">First</a> ';		
			if($PageNos_Navigation["Page_Number"] > $PageNos_Navigation["Page_Numbers"]) 		
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . ((int)$PageNos_Navigation["Page_Start"]-1) . $bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">Previous</a> ';
			for($i = 1, $j = (int)$PageNos_Navigation["Page_Start"]; $i<=(int)$PageNos_Navigation["Page_Numbers"] && $j<=(int)$PageNos_Navigation["Total_Pages"]; $j++, $i++)
			{
				$f1 = $f2 = "";
				if($j==(int)$PageNos_Navigation["Page_Number"]) { 
					$f1 = "<font color='#0066CC'>"; 
					$f2 = "</font>"; 
				}
				//echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $j .$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">&nbsp;' . $f1 . '&nbsp;' . $j . '&nbsp;' . $f2 . '&nbsp;</a> ';
				echo '&nbsp;' . $f1 . '&nbsp;' . $j . '&nbsp;' . $f2 . '&nbsp; of '.$PageNos_Navigation["Total_Pages"]." ";
			}
			if(((int)$PageNos_Navigation["Page_Start"]+(int)$PageNos_Navigation["Page_Numbers"])<=(int)$PageNos_Navigation["Total_Pages"])
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $j .$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">Next</a> ';
			if($PageNos_Navigation["First_Last_Links"])	
				echo '  <a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $PageNos_Navigation["Total_Pages"] .$bookmark.'"  class="' . $PageNos_Navigation["css_class"] . '">Last</a>  ';		
		}			
	}
	//DISPLAY PAGE NUMBERS 
	function display_pagenumbers2() {
		global $PageNos_Navigation;
		$bookmark="";
		if(isset($PageNos_Navigation["book_mark"])) 
			if($PageNos_Navigation["book_mark"]<>"") $bookmark="#".$PageNos_Navigation["book_mark"];
		
		if((int)$PageNos_Navigation["Total_Pages"] > 1)
		{
			echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>';					
			if($PageNos_Navigation["Page_Number"] > 1) 				
				echo '	<td width="80px" style="padding-left:10px;">
							<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . ((int)$PageNos_Navigation["Page_Number"]-1) . $bookmark.'"><img src="images/prevpage.jpg" border="0" /></a>
						</td>';
			echo '		<td  align="center">';
			for($i = 1, $j = (int)$PageNos_Navigation["Page_Start"]; $i<=(int)$PageNos_Navigation["Page_Numbers"] && $j<=(int)$PageNos_Navigation["Total_Pages"]; $j++, $i++)
			{
				$f1 = "";
				if($j==(int)$PageNos_Navigation["Page_Number"]) { 
					$f1 = "-active"; 
				}
				echo '		<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $j .$bookmark.'" class="' . $PageNos_Navigation["css_class"] .$f1. '">' . $j . '</a>';
				
				
			}				
			echo '		</td>';
			//if(((int)$PageNos_Navigation["Page_Start"]+(int)$PageNos_Navigation["Page_Numbers"])<=(int)$PageNos_Navigation["Total_Pages"])			
			if((int)$PageNos_Navigation["Page_Number"]<(int)$PageNos_Navigation["Total_Pages"])			
			echo '		<td width="80px">
							<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . ((int)$PageNos_Navigation["Page_Number"]+1) .$bookmark.'"><img src="images/nextpage.jpg" border="0" /></a>
						</td>';
			echo '	</tr>
			</table>';
		}			
	}
	//DISPLAY PAGE NUMBERS 
	function display_pagenumbers3() {
		global $PageNos_Navigation;
		$bookmark="";
		$next_but=1;
		if(isset($PageNos_Navigation["book_mark"])) 
			if($PageNos_Navigation["book_mark"]<>"") $bookmark="#".$PageNos_Navigation["book_mark"];
		
		if((int)$PageNos_Navigation["Total_Pages"] > 1)
		{
			if($PageNos_Navigation["First_Last_Links"]) 		
				//echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=1'.$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">First</a> ';		
			if($PageNos_Navigation["Page_Number"] > $PageNos_Navigation["Page_Numbers"]) 		
				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . ((int)$PageNos_Navigation["Page_Start"]-1) . $bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">Previous</a> ';
			for($i = 1, $j = (int)$PageNos_Navigation["Page_Start"]; $i<=(int)$PageNos_Navigation["Page_Numbers"] && $j<=(int)$PageNos_Navigation["Total_Pages"]; $j++, $i++)
			{
				$f1 = $f2 = "";
				if($j==(int)$PageNos_Navigation["Page_Number"]) { 
					$f1 = "<font color='#0066CC'>"; 
					$f2 = "</font>"; 
					$next_but=$j;
				}

				echo '<a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $j .$bookmark.'" class="nav-link">' . $f1 . '' . $j . '' . $f2 . '</a> ';
			}
			if(((int)$PageNos_Navigation["Page_Start"]+(int)$PageNos_Navigation["Page_Numbers"])<=(int)$PageNos_Navigation["Total_Pages"])
				echo '<div style="float:right;"><a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $j .$bookmark.'" class="' . $PageNos_Navigation["css_class"] . '">Next</a></div> ';
			/*if($PageNos_Navigation["First_Last_Links"])	
				echo '  <a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . $PageNos_Navigation["Total_Pages"] .$bookmark.'"  class="' . $PageNos_Navigation["css_class"] . '">Last</a>  ';*/
			echo '<div style="float:right;">'; if(($next_but)<>1) echo '  <a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . ($next_but-1) .$bookmark.'"  class="prev">Prev</a></div>';
			else echo '<div style="float:right;">';
			if(($next_but+1)<=$PageNos_Navigation["Total_Pages"]) echo '  <a href="' . $PageNos_Navigation["Page_url"] . $PageNos_Navigation["Page_Navigator"] . '=' . ($next_but+1) .$bookmark.'"  class="prev">Next</a></div>';
			else echo '';		
		}			
	}
	
	function get_catg($catg,$catg_array = array()){
		global $obj_admin_db;	
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_id='".$catg."'";	
		$catg_row = $obj_admin_db->fetchRow($cquery);	
		if($catg_row) {	
			$catg_array[]=array($catg_row['catg_id'],$catg_row['catg_title']);		
			if($catg_row['catg_parent'])	
				$catg_array=get_catg($catg_row['catg_parent'],$catg_array);	
		}		
		return $catg_array;	
	}

	function get_catg2($catg,$catg_array = array()){	
		global $obj_admin_db;	
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_id='".$catg."'";	
		$catg_row = $obj_admin_db->fetchRow($cquery);	
		if($catg_row) {	
			$catg_array[]=$catg_row['catg_id'];	
			//$catg_array[0][]=$catg_row['catg_id'];	
			//$catg_array[1][]=$catg_row['catg_title'];	
			if($catg_row['catg_parent'])	
				$catg_array=get_catg2($catg_row['catg_parent'],$catg_array);	
		}		
		return $catg_array;	
	}



	function del_catg($catg){	
		global $obj_admin_db;	
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_id='".$catg."'";	
		$catg_num = $obj_admin_db->fetchNum($cquery);	
		if(!$catg_num) return;
	
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_parent='".$catg."'";	
		$catg_res=$obj_admin_db->get_qresult($cquery);	
		while($catg_row=$obj_admin_db->fetchArray($catg_res)) {	
			del_catg($catg_row['catg_id']);	
		}	
		del_products($catg);	
		$cquery="DELETE FROM ".TABLE_CATEGORIES." WHERE catg_id='".$catg."'";	
		$obj_admin_db->get_qresult($cquery);		
	}

	function del_products($catg){
		global $obj_admin_db;	
		$pquery="SELECT * FROM ".TABLE_VIDEOS." WHERE catgid='".$catg."'";	
		$prod_res=$obj_admin_db->get_qresult($pquery);	
		while($prod_row=$obj_admin_db->fetchArray($prod_res)) {	
			$prdid=(int)$prod_row['videoid'];
	
			$video_delete_query="DELETE FROM ".TABLE_VIDEOS." WHERE videoid=".$prdid;
			$obj_admin_db->get_qresult($video_delete_query);
			
			$img_url="../video_images/".$prdid  .".jpg";
			if(file_exists($img_url)) unlink($img_url);								
			$file_url="../video_files/".$prdid . ".flv" ;
			if(file_exists($file_url)) unlink($file_url);
		}	
	}

	function menu_catg($catg=0){
		global $obj_db;
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_parent='".$catg."'";
		$catg_num = $obj_db->fetchNum($cquery);
		if(!$catg_num) return;
		if($catg==0)
			echo '<ul id="qm0" class="qmmc">';
		else 
			echo '<ul>';	

		$catg_res=$obj_db->get_qresult($cquery);
		while($catg_row=$obj_db->fetchArray($catg_res)) {
			echo '<li>';
			$squery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_parent='".$catg_row['catg_id']."'";
			$scatg_num = $obj_db->fetchNum($squery);
			$cls = $scatg_num?'class="qmparent"':'';
			$clink = "index.php?p=catgp&id=".$catg_row['catg_id'];			
			echo '<a '.$cls.' href="'.$clink.'">'.stripslashes($catg_row['catg_title']).'</a>';	
			if($scatg_num) {
				menu_catg($catg_row['catg_id']);
			}	
			echo '</li>';
		}
		echo '</ul>';
	}

	function menu_catg2($catg=0 , $key = 0){
		global $obj_db, $acat;
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_status=1 and catg_parent='".$catg."' order by catg_order";
		$catg_num = $obj_db->fetchNum($cquery);
		if(!$catg_num) return;
		if($catg==0)
			echo '<ul class="nfMain nfPure" style="text-align:left;">';

		$catg_res=$obj_db->get_qresult($cquery);
		while($catg_row=$obj_db->fetchArray($catg_res)) {			
			$b1 = $b2 = '';
			$scatg_num = 0;
			$prefix = $key?'style="padding-left:'.(15*$key).'px;"':'';	
			$cls = $key?'nfLinkS':'nfLink';	
			$skey = array_search($catg_row['catg_id'], $acat);
			//echo in_array($catg_row['catg_id'],$acat);
			if(strlen($skey)) {
				$b1 = '<b>';
				$b2 = '</b>';
				$squery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_status=1 and catg_parent='".$catg_row['catg_id']."'";
				$scatg_num = $obj_db->fetchNum($squery);								
			}

			$clink = "index.php?p=catgp&id=".$catg_row['catg_id'];			
			echo '<li '.$prefix.'>';
			echo '<a class="'.$cls.'" href="'.$clink.'">'.$b1.stripslashes($catg_row['catg_title']).$b2.'</a>';
			echo '</li>';
			if(strlen($key)) {
				if($scatg_num) {
					menu_catg2($catg_row['catg_id'], $skey+1);
				}	
			}
		}

		if($catg==0)	
			echo '</ul>';
	}
	
	function left_menu_catg($catg=0){
		global $obj_db, $acat;
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_status=1 and catg_id=".$catg;
		$catg_srow = $obj_db->fetchRow($cquery);
		$c=0;
		$sc=0;
		if($catg_srow) {
			if($catg_srow['catg_parent']) {
				$c=$catg_srow['catg_parent'];
				$sc=$catg_srow['catg_id'];
			} else $c=$catg_srow['catg_id'];
		}
		
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_status=1 and catg_parent=0 order by catg_order, catg_title";
		$catg_num = $obj_db->fetchNum($cquery);
		if(!$catg_num) return;
		
		echo '<table border="0" cellpadding="3" cellspacing="5" width="100%">';
		$catg_res=$obj_db->get_qresult($cquery);
		while($catg_row=$obj_db->fetchArray($catg_res)) {						
			$b1 = $b2 = '';
			if($catg_row['catg_id']==$c) {
				$b1 = '<b>';
				$b2 = '</b>';
			}			
			$clink = "newvideo.php?c=".$catg_row['catg_id'];			
			echo '<tr>';
			echo '<td class="leftin2" align="left"><a class="link" href="'.$clink.'">'.$b1.stripslashes($catg_row['catg_title']).$b2.'</a></td>';
			echo '</tr>';
			if($catg_row['catg_id']==$c) {
				$scquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_status=1 and catg_parent=".$c." order by catg_order, catg_title";
				$scatg_res=$obj_db->get_qresult($scquery);
				while($scatg_row=$obj_db->fetchArray($scatg_res)) {						
					$b1 = $b2 = '';
					if($scatg_row['catg_id']==$sc) {
						$b1 = '<b>';
						$b2 = '</b>';
					}			
					$clink = "newvideo.php?c=".$scatg_row['catg_id'];			
					echo '<tr>';
					echo '<td  class="leftin2" align="left" ><a class="link" href="'.$clink.'" style="padding-left:15px;">'.$b1.stripslashes($scatg_row['catg_title']).$b2.'</a></td>';
					echo '</tr>';
				}
			}	
		}
		echo '</table>';
	}
	

	function catg_tree($catg=0 , $key = 0){
		global $obj_db, $acat;
		$cquery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_status=1 and catg_parent='".$catg."' order by catg_order";
		$catg_num = $obj_db->fetchNum($cquery);
		if(!$catg_num) return;
		$catg_res=$obj_db->get_qresult($cquery);
		while($catg_row=$obj_db->fetchArray($catg_res)) {			
			$scatg_num = 0;
			$prefix = $key?'style="padding-left:'.(15*$key).'px;"':'';	
			//$cls = $key?'nfLinkS':'nfLink';	
			$squery="SELECT * FROM ".TABLE_CATEGORIES." WHERE catg_status=1 and catg_parent='".$catg_row['catg_id']."'";
			$scatg_num = $obj_db->fetchNum($squery);
			echo '<option '.$prefix.' value="'.$catg_row['catg_id'].'">';
			//echo '<a class="'.$cls.'" href="'.$clink.'">'.$b1.stripslashes($catg_row['catg_title']).$b2.'</a>';
			echo stripslashes($catg_row['catg_title']);
			echo '</option>';
			if($scatg_num) {
				catg_tree($catg_row['catg_id'], $key+1);
			}	
		}
	}		
	function get_username($user_id){
		global $obj_db, $acat;
		$username=$obj_db->fetchRow("select user_name from ".TABLE_USERS." where user_id=".(int)$user_id);
		return $username['user_name'];
	}
	//user login
	function user_auth() {
		if(!isset($_SESSION['user'])) {
			redirect_url("login.php");
		}
	}
	
	function checkactivity() {
				if($_SESSION['user_log_id']) {
				 $user_login="SELECT * FROM ".TABLE_USERS." WHERE id=".(int)$_SESSION['user_log_id'];
				 $user_loginrow=mysql_fetch_array(mysql_query($user_login));
				 
				 $oldtime=$user_loginrow['log_time'];
				 $newtime = date("Y-m-d H:i:s");
				 $timediff=strtotime($newtime)- strtotime($oldtime); 
				 if($_SESSION['user_log_rand']==$user_loginrow['log_status']) {
				 
					 if($timediff < 600) {
					 
						$log_status_query="Update ".TABLE_USERS." SET log_time='".$newtime."' WHERE id=".(int)$_SESSION['user_log_id'];
						$log_status=mysql_query($log_status_query);
					 } else {
						$log_status_query="Update ".TABLE_USERS." SET log_status='0'  WHERE id=".(int)$_SESSION['user_log_id'];
						$log_status=mysql_query($log_status_query);
					 }
					 
				 
				 } elseif(!$_SESSION['user_log_id']) {
						session_destroy();
						redirect_page("login.php");
				}
			}
	}
	
	
	$typename= array("1"=>"Residential : Single Family","2"=>"Residential : Condo / Co-op","3"=>"Residential : Income","4"=>"Residential : Land","5"=>"Residential : Lease","6"=>"Residential : Multi-Family","7"=>"Residential : Development","8"=>"Commercial : Offic","9"=>"Commercial : Retail","10"=>"Commercial : Industrial","11"=>"Commercial : Land","12"=>"Commercial : Special Use","13"=>"Commercial / Business Opport","14"=>"Commercial : Development");
	$stylenames = array("1"=>"Architectural / Modern","2"=>"Cape Cod","3"=>"Contemporary","4"=>"Contemporary Mediterranean","5"=>"Country English","6"=>"Craftsman","7"=>"French","8"=>"Mediterranean","9"=>"Mid-Century","10"=>"Post & Beam","11"=>"Ranch","12"=>"Spanish","13"=>"Traditional","14"=>"Tudor");
?>