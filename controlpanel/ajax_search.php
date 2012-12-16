<?php		
			
			require_once("../includes/DbConfig.php");
			require_once("../includes/general.php");
			
			
			$sub_query='';
			if(strlen(trim($_REQUEST['subscription']))) if($_REQUEST['subscription']==6) $sub_query=''; else $sub_query=" and subscription=".(int)$_REQUEST['subscription'];
			$user_query="SELECT * FROM ".TABLE_USERS." WHERE (first_name like '%".$_POST['search_name']."%' OR last_name like '%".$_POST['search_name']."%') AND subscription!=4 ".$sub_query;
			$user_row = $obj_db->get_qresult($user_query);
			$val='<table>';
			while($user_srow = $obj_db->fetchArray($user_row))
			{
			   $val.='<tr><td><input type="checkbox" name="users_popup_mail[]" value="'.$user_srow['email'].'" /></td><td>'.$user_srow['first_name'].'&nbsp;'.$user_srow['last_name'].'</td><td>';
			   if($user_srow['subscription']==1) $member_type='FULL MEMBER';
			   elseif($user_srow['subscription']==2) $member_type='DUAL MEMBERS';
			   elseif($user_srow['subscription']==3) $member_type='AGENTS/BROKERS';
			   elseif($user_srow['subscription']==5) $member_type='INVESTOR /BANKS';
			   $val.=$member_type.'</td><td>'.$user_srow['city'].'</td><td>'.$user_srow['address'].'</td></tr>';			   
			}
			$val.='</table>';
			echo "jQuery('#search_values').html('".$val."');";
?>