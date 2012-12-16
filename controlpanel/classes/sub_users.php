<?php		
     $id=$_GET['id'];
	//categories
	class press {
	
		//delete product
		function delete_press($id) {
			global $obj_db, $page_url;
			$catg_delete_qry="DELETE FROM ".TABLE_ADMINISTRATOR." WHERE id =".$id;
			mysql_query($catg_delete_qry);								
			redirect_page($page_url);
		}
		
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".TABLE_ADMINISTRATOR." WHERE id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_url($page_url);
			$catg_row['registered_users']=explode(',',$catg_row['tasks']);
			return $catg_row;
		}
		
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['admin_user']))) $msg[]="Enter User Name.";
			if(!strlen(trim($data['admin_opword'])) ) $msg[]="Enter Password.";
			if(!count($data['registered_users'])) $msg[]="Select atleast one tab.";
			if(count($msg)==0){
				$tasks=implode(',',$data['registered_users']);
				if($id)
					$insert_query="UPDATE ".TABLE_ADMINISTRATOR." SET  admin_user='".mysql_real_escape_string($data['admin_user'])."',
																  admin_opword='".mysql_real_escape_string($data['admin_opword'])."',
																  tasks='".mysql_real_escape_string($tasks)."'
																  WHERE id=".$id;
				else 
					$insert_query="INSERT INTO ".TABLE_ADMINISTRATOR." SET admin_user='".mysql_real_escape_string($data['admin_user'])."',
																       admin_opword='".mysql_real_escape_string($data['admin_opword'])."',
																	   tasks='".mysql_real_escape_string($tasks)."'
																	";															 	 
															
					$result=$obj_db->get_qresult($insert_query);
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
		}
	}
?>