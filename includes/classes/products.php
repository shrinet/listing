<?php		

	//products

	class products {

	

		//delete product

		function delete_product($id) {

			global $obj_db, $page_url;

			$catg_id=$obj_db->fetchRow("select * from ".TABLE_PRODUCTS." where product_id=".(int)$id);

			$product_delete_qry="DELETE FROM ".TABLE_PRODUCTS." WHERE product_id =".$id;

			mysql_query($product_delete_qry);		

			$img_gal="../images/products/".$id.".jpg";

			if(file_exists($img_gal)) unlink($img_gal);

			/*$img_gal="../images/products/".$id."s.jpg";

			if(file_exists($img_gal)) unlink($img_gal);

			$img_gal="../images/products/".$id."m.jpg";

			if(file_exists($img_gal)) unlink($img_gal);*/

			redirect_url("index.php?p=prod");

		}

		

		//product record existance

		function get_product($id) {

			global $obj_db, $page_url;

			$product_query="SELECT * FROM ".TABLE_PRODUCTS." WHERE product_id=".$id;

			$product_row = $obj_db->fetchRow($product_query);

			if(!$product_row) redirect_page($page_url);

			return $product_row;

		}

		

		// Product validations & submition

		function action_product($data, $id) {

			global $obj_db, $page_url;

			$msg=array();

			if(!strlen(trim($data['product_title']))) $msg[]="Enter product title";

			if(!strlen(trim($data['product_sub_title']))) $msg[]="Enter product subtitle";

			if(!is_numeric($data['product_price'])) $msg[]="Enter product price";
			
			if(!count($data['product_available'])) $msg[]="Select atleast one";			

			if(!strlen(trim($_FILES['product_image']['name'])) && $_GET['action'] == "Add") $msg[]="Browse product image";

			if($_FILES['image']['name']) {

				$ext=substr(strrchr($_FILES['product_image']['name'],"."),1);

				$ext=strtolower($ext);

				if($ext=="jpg" || $ext=="jpeg" || $ext=="gif" || $ext=="png") {

					//do next steps

				} else $msg[]="Image must be JPG or GIF or PNG";

			}

			if(count($msg)==0){
					$available=implode(',',$data['product_available']);
				if($id)
					$insert_query="UPDATE ".TABLE_PRODUCTS." SET 

							product_title='".mysql_real_escape_string($data['product_title'])."',
							
							product_sub_title='".mysql_real_escape_string($data['product_sub_title'])."', 

							product_price='".(float)$data['product_price']."', 

							product_short_description='".mysql_real_escape_string($data['product_short_description'])."',
							
							product_description='".mysql_real_escape_string($data['product_description'])."', 
							
							product_available='".mysql_real_escape_string($available)."',
							
							product_sorder='".mysql_real_escape_string($data['product_sorder'])."' 

							WHERE product_id=".$id;

				else 
					$insert_query="INSERT INTO ".TABLE_PRODUCTS." SET 

							product_title='".mysql_real_escape_string($data['product_title'])."',
							
							product_sub_title='".mysql_real_escape_string($data['product_sub_title'])."', 

							product_price='".(float)$data['product_price']."', 

							product_short_description='".mysql_real_escape_string($data['product_short_description'])."',
							
							product_description='".mysql_real_escape_string($data['product_description'])."', 
							
							product_available='".mysql_real_escape_string($available)."',
							
							product_sorder='".mysql_real_escape_string($data['product_sorder'])."'";

				$result=$obj_db->get_qresult($insert_query);

				if(!$id) $id=mysql_insert_id();

				$path_1="../".USER_MP3.$id."_.mp3";
				
				if($_FILES['product_mp3']['name']) {
				
					if(move_uploaded_file($_FILES['product_mp3']['tmp_name'],$path_1)) {
						$xml_output = '<?xml version="1.0" encoding="UTF-8"?>'; 
						$xml_output .= '<songs>';
						$xml_output .= '<song url="audiofiles/'.$id.'_" artist="'.htmlentities($data['product_title']).'" track="'.htmlentities($data['product_title']).'" />';
						$xml_output .= '</songs>';
						$fh = fopen('../audio/xml/'.$id.'_.xml', 'w');
						fwrite($fh, $xml_output);
					 }
				  }
				
				if($_FILES['product_image']['name']) {

					$ext=substr(strrchr($_FILES['product_image']['name'],"."),1);

					$ext=strtolower($ext);

					$img_gal="../images/products/".$id.".jpg";

					//$img_gal1="../images/products/".$id."s.jpg";

					//$img_gal2="../images/products/".$id."m.jpg";

					move_uploaded_file($_FILES['product_image']['tmp_name'], $img_gal);/*) {

						//$thumb=make_thumb($img_gal,$img_gal1,150,120,$ext);

						//$thumb=make_thumb($img_gal,$img_gal2,500,372,$ext);

						//chmod($img_gal, 0777);

						//chmod($img_gal1, 0777);

						//chmod($img_gal2, 0777);

					}					
*/
				}				

				redirect_url("index.php?p=prod");				

			}  else return $msg;

			

		}

		

		//data from subjects table

		function genRandomString() {

				$length = 6;

				$characters = '0123456789abcdefghijklmnopqrstuvwxyz';

				$string ='';    

				for ($p = 0; $p < $length; $p++) {

					$string .= $characters[mt_rand(0, strlen($characters))];

				}

				return $string;

			}



	}

?>