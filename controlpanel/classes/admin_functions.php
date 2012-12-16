<?php

//Next Page  moving

function admin_move_page($page){

	echo "<script>";

	echo "location.replace('$page')";

	echo "</script>";		

	exit;

}



//Next Page  moving

function move_page($page){

	echo "<script>";

	echo "location.replace('$page')";

	echo "</script>";		

	exit;

}



	//add days to given date not 

	function plusdays_date($bdate,$days)

	{

		//$cdate			=	convertDate($arrayDate['str_departtime']);

		$miamiTime 		=	strtotime($bdate);

		$miamiDay		=	date("D", $miamiTime);

		//cutoff date fot miami

		$cutoffTime 	=	date($miamiTime)+ ($days)*24*60*60;

		$cutoffDay		=	date("D", $cutoffTime);

		$cutoffDay = date("Y-m-d",$cutoffTime);		

		return $cutoffDay;

	}

	//echo cutoffdate(date("Y-m-d"),22);

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

	

	

	function make_image_thumb($img_name,$filename,$new_w,$new_h,$ext)

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

		$ratio1=$old_x/$new_w;

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

		}

		/*$thumb_w=$new_w;

		$thumb_h=$new_h;*/

		

		

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

	function getExtension($str)

	{

		$i = strrpos($str,".");

		if (!$i) { return ""; }

		$l = strlen($str) - $i;

		$ext = substr($str,$i+1,$l);

		return $ext;

	}

	

	






function contact_formsent($data) {





global $obj_db;



$admin_select_query="SELECT * FROM partner_admin ";

$admin_select_srows=$obj_db->fetchRow($admin_select_query);

 

if(strlen(trim($data['address'])))

{							

$dvd=explode("\n",$data['address']);

$data['address']="";	

foreach($dvd as $dval)

	if(strlen(trim($dval))) $data['address'].=stripslashes($dval).'<br>';

}



$msge='<table border="0" cellpadding="0" cellspacing="0" width="800px;" style="font-family:Arial; font-size:13px; border:1px solid gray;" align="center">				

				<tr>

					<td bgcolor="#0099FF" height="30px"  style="color:#FFFFFF; font-weight:bold;" width="800px">Contact Form</td>

				</tr>

				<tr>

					<td>&nbsp;</td>

				</tr>

				<tr>

					<td style="padding-left:10px;">

						Name : '.$data['cname'].'

					</td>

				</tr>

				<tr>

					<td>&nbsp;</td>

				</tr>

				<tr>

					<td style="padding-left:10px;">

						E-mail : '.$data['email'].'

					</td>

				</tr>

				<tr>

					<td>&nbsp;</td>

				</tr>

				<tr>

					<td style="padding-left:10px;">

						Phone number : '.$data['phone'].'

					</td>

				</tr>

				<tr>

					<td>&nbsp;</td>

				</tr>

				<tr>

					<td style="padding-left:10px;">

						Address : <br>'.$data['address'].'

					</td>

				</tr>

				<tr>

					<td>&nbsp;</td>

				</tr>

					<tr>

					<td style="padding-left:10px;">Sincerely,</td>

				</tr>

					<tr>

					<td style="padding-left:10px;">Partners For A Better World Team</td>

				</tr>

					<tr>

					<td>&nbsp;</td>

				</tr>

					<tr>

						<td  bgcolor="#0099FF" height="1px" width="800px">&nbsp; </td>

					</tr>

			</table>';		

		//add information to mail



		$From_Display = "Partners For A Better World";

		$From_Email = $data['email'];

		$To_Email =$admin_select_srows['contact_email'];//'kveerababu_zonup@yahoo.in';

		$CC = "";

		$BCC = "";

		$Sub = "Partners For A Better World : Contact form";

		$Message = $msge;

		$Format = 1;

		$msg=SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);		

				

		//echo '<br>'.$To_Email.'<br>';

		//echo $msg.'<br>';

		//echo $msge;

		return $msg;	

}






?>