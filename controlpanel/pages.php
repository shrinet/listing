<?php defined('ACCESS_SUBFILES') or die('Restricted access');
		switch($_GET['p']) 
		{
			case "config"  			: include("chpword.php"); break; //	
			case "users"   			: include("users.php"); break;		
			case "user"   			: include("users_view.php"); break;							
			case "ads"     			: include("ads.php"); break;	
			case "mem"     			: include("managememberships.php"); break;
			case "giftcoupons" 		: include("giftcoupons.php"); break;	
			case "giftcards" 		: include("giftcards.php"); break;	
			case "discountcoupons"  : include("discountcoupons.php"); break;
			case "emails"  : include("emails.php"); break;	
			case "edit"  : include("edit_list.php"); break;		
			case "emails_content"  : include("emails_content.php"); break;		
			case "roomate_adds"  : include("roomate_adds.php"); break;		
			case "flag_adds"  : include("flag_adds.php"); break;		
			case "user_inbox"  : include("user_inbox.php"); break;	
			case "user_credit"  : include("user_credit.php"); break;	
			case "sub_users"  : include("sub_users.php"); break;	
			case "invoices"  : include("invoices.php"); break;	
			case "daily_password"  : include("dialy_password.php"); break;		
			case "payment_methods"  : include("payment_methods.php"); break;	
			case "expiration"  : include("expiration.php"); break;		
			case "zip_codes"  : include("zip_codes.php"); break;							
	
			default 		: include("ads.php"); break;
	
		}
	
?>