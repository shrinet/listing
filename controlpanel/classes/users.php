<?php		
	//categories
	class press {
	
		//delete product
		function delete_press($id) {
			global $obj_db, $page_url;
			$catg_delete_qry="DELETE FROM ".TABLE_GIFTCOUPONS." WHERE gift_id =".$id;
			mysql_query($catg_delete_qry);								
			redirect_page($page_url);
		}
		
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".TABLE_GIFTCOUPONS." WHERE gift_id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_url($page_url);
			return $catg_row;
		}
		
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['gift_coupon']))) $msg[]="Enter Gift Coupon code.";
			if(!strlen(trim($data['gift_name'])) ) $msg[]="Enter Gift Name.";
			if(!strlen(trim($data['gift_value'])) || !is_numeric($data['gift_value'])) $msg[]="Enter Gift Coupon value.";
			if(count($msg)==0){
				if($id)
					$insert_query="UPDATE ".TABLE_GIFTCOUPONS." SET  gift_coupon='".mysql_real_escape_string($data['gift_coupon'])."',
																 gift_name='".mysql_real_escape_string($data['gift_name'])."',
																 gift_value='".(int)$data['gift_value']."',
																 gift_created_date='".date("Y-m-d")."'
																 WHERE gift_id=".$id;
				else 
					$insert_query="INSERT INTO ".TABLE_GIFTCOUPONS." SET gift_coupon='".mysql_real_escape_string($data['gift_coupon'])."',
																gift_name='".mysql_real_escape_string($data['gift_name'])."',
															 	 gift_value='".(int)$data['gift_value']."',
																 gift_created_date='".date("Y-m-d")."'
															";
					$result=$obj_db->get_qresult($insert_query);
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
			
		}
		
		
	}
?>