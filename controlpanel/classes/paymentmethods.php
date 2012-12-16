<?php		
	//categories
	class press {
	
		//delete product
		function delete_press($id) {
			global $obj_db, $page_url;
			$catg_delete_qry="DELETE FROM ".TABLE_PAYMENT_METHODS." WHERE id =".$id;
			mysql_query($catg_delete_qry);								
			redirect_page($page_url);
		}
		
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".TABLE_PAYMENT_METHODS." WHERE id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_page($page_url);
			return $catg_row;
		}
		
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['payment_method']))) $msg[]="Enter Payment Method.";
			if(!strlen(trim($_FILES["card_logo"]["name"])) ) $msg[]="Upload Card Logo.";
			
			if(count($msg)==0){
				if($id)
					$insert_query="UPDATE ".TABLE_PAYMENT_METHODS." SET  payment_method='".mysql_real_escape_string($data['payment_method'])."'
																 WHERE id=".$id;
				else 
					$insert_query="INSERT INTO ".TABLE_PAYMENT_METHODS." SET payment_method='".mysql_real_escape_string($data['payment_method'])."'";
					$result=$obj_db->get_qresult($insert_query);
					
					if(!$id) $id=mysql_insert_id();
					 move_uploaded_file($_FILES["card_logo"]["tmp_name"], "../payment_methods/" . $id .'.jpg');
					
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
			
		}
		
		
	}
?>