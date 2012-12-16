<?php		
     $id=$_GET['id'];
	//categories
	class press {
	
		//delete product
		function delete_press($id) {
			global $obj_db, $page_url;
			$catg_delete_qry="DELETE FROM ".POCKETS_FLAG." WHERE id =".$id;
			mysql_query($catg_delete_qry);
									
			redirect_page($page_url);
		}
		
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".POCKETS_FLAG." WHERE id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_url($page_url);
			return $catg_row;
		}
		
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['user_id']))) $msg[]="Enter User ID.";
			if(!strlen(trim($data['property_id'])) ) $msg[]="Enter Property ID.";
			if(!strlen(trim($data['flag_message']))) $msg[]="Enter Flag Message.";
			if(count($msg)==0){
				if($id)
					$insert_query="UPDATE ".POCKETS_FLAG." SET  user_id='".mysql_real_escape_string($data['user_id'])."',
																 property_id='".mysql_real_escape_string($data['property_id'])."',
																 flag_message='".mysql_real_escape_string($data['flag_message'])."'
																 WHERE id=".$id;
				else 
					$insert_query="INSERT INTO ".POCKETS_FLAG." SET user_id='".mysql_real_escape_string($data['user_id'])."',
																 property_id='".mysql_real_escape_string($data['property_id'])."',
															 	 flag_message='".mysql_real_escape_string($data['flag_message'])."'
															";
					$result=$obj_db->get_qresult($insert_query);
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
		}
	}
?>