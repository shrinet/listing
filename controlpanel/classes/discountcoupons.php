<?php		
	//categories
	class press {
	
		//delete product
		function delete_press($id) {
			global $obj_db, $page_url;
			$catg_delete_qry="DELETE FROM ".TABLE_DISCOUNTCOUPONS." WHERE discount_id =".$id;
			mysql_query($catg_delete_qry);								
			redirect_page($page_url);
		}
		
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".TABLE_DISCOUNTCOUPONS." WHERE discount_id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_url($page_url);
			return $catg_row;
		}
		
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['discount_coupon']))) $msg[]="Enter Discount Coupon code.";
			if(!strlen(trim($data['discount_name'])) ) $msg[]="Enter Discount Coupon Name.";
			if(!strlen(trim($data['discount_value'])) || !is_numeric($data['discount_value'])) $msg[]="Enter Discount Coupon value.";
			if(count($msg)==0){
				if($id)
					$insert_query="UPDATE ".TABLE_DISCOUNTCOUPONS." SET  discount_coupon='".mysql_real_escape_string($data['discount_coupon'])."',
																 discount_name='".mysql_real_escape_string($data['discount_name'])."',
																 discount_value='".(int)$data['discount_value']."',
																 discount_created_date='".date("Y-m-d")."',
																 coupan_type='".$_POST['coupan_type']."'
																 WHERE discount_id=".$id;
				else 
					$insert_query="INSERT INTO ".TABLE_DISCOUNTCOUPONS." SET discount_coupon='".mysql_real_escape_string($data['discount_coupon'])."',
																discount_name='".mysql_real_escape_string($data['discount_name'])."',
															 	 discount_value='".(int)$data['discount_value']."',
																 discount_created_date='".date("Y-m-d")."',
																 coupan_type='".$_POST['coupan_type']."'
															";
					$result=$obj_db->get_qresult($insert_query);
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
			
		}
		
		
	}
?>