<?php		
	//categories
	class press {
	
		//delete product
		function delete_press($id) {
			global $obj_db, $page_url;
			$catg_delete_qry="DELETE FROM ".TABLE_GIFT_COUPONS." WHERE id =".$id;
			mysql_query($catg_delete_qry);								
			redirect_page($page_url);
		}
		
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".TABLE_GIFT_COUPONS." WHERE id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_url($page_url);
			return $catg_row;
		}
		
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['send_email']))) $msg[]="Enter Sender Email.";
			if(!strlen(trim($data['reciepient_email'])) ) $msg[]="Enter Reciever Email.";
			if(!strlen(trim($data['token']))) $msg[]="Enter Gift Coupon code.";
			if(!strlen(trim($data['membership_type']))) $msg[]="Enter Membership Amount.";
			if(count($msg)==0){
				if($id)
					$insert_query="UPDATE ".TABLE_GIFT_COUPONS." SET  send_email='".mysql_real_escape_string($data['send_email'])."',
																 reciepient_email='".mysql_real_escape_string($data['reciepient_email'])."',
																 token='".(int)$data['token']."',
																 payment_date='".date("Y-m-d")."',
																 membership_type='".$data['membership_type']."'
																 WHERE id=".$id;
				else 
					$insert_query="INSERT INTO ".TABLE_GIFT_COUPONS." SET send_email='".mysql_real_escape_string($data['send_email'])."',
																 reciepient_email='".mysql_real_escape_string($data['reciepient_email'])."',
																 token='".(int)$data['token']."',
																 payment_date='".date("Y-m-d")."',
																 membership_type='".$data['membership_type']."'";
					$result=$obj_db->get_qresult($insert_query);
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
			
		}
		
		
	}
?>