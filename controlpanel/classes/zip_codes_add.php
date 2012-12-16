<?php		
	//categories
	class press {
	
		//delete product
		function delete_press($id) {
			global $obj_db, $page_url;
			$catg_delete_qry="DELETE FROM ".TABLE_ZIP_CODES." WHERE id =".$id;
			mysql_query($catg_delete_qry);								
			redirect_page($page_url);
		}
		
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".TABLE_ZIP_CODES." WHERE id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_page($page_url);
			return $catg_row;
		}
		
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['zip_code']))) $msg[]="Enter zip code.";
			if(!strlen(trim($data['price']))) $msg[]="Enter price.";
			
			if(count($msg)==0){
				if($id)
					$insert_query="UPDATE ".TABLE_ZIP_CODES." SET  zip_code='".mysql_real_escape_string($data['zip_code'])."', price='".mysql_real_escape_string($data['price'])."' WHERE id=".$id;
				else 
					$insert_query="INSERT INTO ".TABLE_ZIP_CODES." SET zip_code='".mysql_real_escape_string($data['zip_code'])."', price='".mysql_real_escape_string($data['price'])."'";
					$result=$obj_db->get_qresult($insert_query);
					
					if(!$id) $id=mysql_insert_id();
					 
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
			
		}
		
	}
?>