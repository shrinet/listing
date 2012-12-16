<?php

/// database mysql functions

// if db class not exists

if(!class_exists("db")) {

	class db 

	{ // class starting     

		

		 //Mysql connection start

		 public function open_connection()

		 {
				
					$hostname = "listingpockets1.db.7579755.hostedresource.com";
					$username = "listingpockets1";
					$password = "a123456A";
					$database = "listingpockets1";

					

					

					$connect = mysql_connect($hostname,$username,$password);

					$select_db = mysql_select_db($database);

			  

		 }

		 

		 //Mysql connection close

		 public function close_connection()

		 {

				mysql_close();

		 }

		 

		//Multiple rows fetching

		function fetchArray($query_result){		

			$array = mysql_fetch_array($query_result,MYSQL_ASSOC);

			return $array;

		}

		

		//Get query result

		function get_qresult($get_query){

			$get_result = mysql_query($get_query)or die($get_query.mysql_query());

			return $get_result;

		}

		

		//getting single record

		function fetchRow($select_query){

			$select_result=mysql_query($select_query)or die($select_query.mysql_query());

			$select_row = mysql_fetch_array($select_result);

			return $select_row;

		}	

		

		//getting selected field in a record

		function fetch_field($select_query){

			$select_result=mysql_query($select_query);

			$select_row = mysql_fetch_array($select_result);

			if($select_row) return $select_row[0]; else return 0;

		}	

			

		//count records

		function fetchNum($select_query){

			$select_result=mysql_query($select_query) or die(mysql_error());

			$get_num = mysql_num_rows($select_result);

			return $get_num;

		}

	} // class ending

}	

/// 

// database tables

	define('TABLE_ADMINISTRATOR','pockets_admin');
	define('BASE_URL','/pockets/');
	define('SITE_NAME','Pockets');
	define('POCKETS_FLAG','pockets_flag');
	define("TABLE_USERS","pockets_users");
	define("TABLE_POST","pockets_listing");
	define("TABLE_ROOMATES","pockets_roomates");
	define("TABLE_PLANS","pockets_memership_plans");
	define("TABLE_GIFTCOUPONS","pockets_gift_coupons");
	define("TABLE_DISCOUNTCOUPONS","pockets_discount_coupons");
	define("TABLE_EMAIL_CONTENT","pockets_email_content");
	define("TABLE_INBOX","pockets_user_inbox");
	define("TABLE_CARDS","pockets_cards");
	define("TABLE_ORDERS","pockets_orders");
	define("TABLE_NOTES","pockets_notes");
	define("TABLE_GIFT_COUPONS","pockets_gift_cards");
	define("TABLE_PAYMENT_METHODS","pockets_payment_methods");
	define("TABLE_ATTEMPTS","pockets_login_attempts");
	define("TABLE_ZIP_CODES","pockets_zip_codes");
	
	
	
	$obj_db = new db();
	$obj_db->open_connection();
	$obj_admin_db = new db();
	$obj_admin_db->open_connection();
	
	$admin_select_query="SELECT contact_email, paypal_email FROM ".TABLE_ADMINISTRATOR;
	$admin_select_row= $obj_db->fetchRow($admin_select_query);
	define('ADMIN_EMAIL',$admin_select_row['contact_email']);
?>