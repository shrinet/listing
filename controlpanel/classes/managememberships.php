<?php 	//categories
	class press {
	
		//product record existance
		function get_press($id) {
			global $obj_db, $page_url;
			$catg_query="SELECT * FROM ".TABLE_PLANS." WHERE plan_id=".$id;
			$catg_row = $obj_db->fetchRow($catg_query);
			if(!$catg_row) redirect_page($page_url);
			return $catg_row;
		}
		// Product validations & submition
		function action_press($data, $id) {
			global $obj_db, $page_url;
			$msg=array();
			if(!strlen(trim($data['plan_name']))) $msg[]="Enter  name.";
			if(!strlen(trim($data['plan_price'])) || !is_numeric($data['plan_price'])) $msg[]="Enter Price.";
			//if(!strlen(trim($data['plan_days'])) || !is_numeric($data['plan_days'])) $msg[]="Enter Number of days.";
			if(count($msg)==0){
					$insert_query="UPDATE ".TABLE_PLANS." SET 	 plan_name='".mysql_real_escape_string($data['plan_name'])."',
																 plan_price=".$data['plan_price'].",
																 plan_days=".(int)$data['plan_days']."
																 WHERE plan_id=".$id;
					$result=$obj_db->get_qresult($insert_query);
					echo '<script>location.replace("'.$page_url.'");</script>';
			}  else return $msg;
			
		}
		
		
	}
?>