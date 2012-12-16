		<ul class="items">
			<?php if($_SESSION['logger_id']==1) { ?>			
            <li class="active"><a href="index.php" title="Dashboard">Administrator</a></li>
			<li><a href="index.php?p=users" title="Registered Users">Registered Users</a></li>
			<li><a href="index.php?p=sub_users" title="Control Panel UN & PW">Control Panel UN & PW</a></li>
			<li><a href="index.php?p=ads" title="Listings">Listings</a></li>			
			<li><a href="index.php?p=mem" title="Listings">Manage Memberships</a></li>
			<?php /*?><li><a href="index.php?p=giftcoupons" title="gift coupons">Gift Coupons</a></li><?php */?>
			<li><a href="index.php?p=giftcards" title="Gift Cards">Gift Cards</a></li>
			<li><a href="index.php?p=discountcoupons" title="Discount coupons">Discount Coupons</a></li>
			<li><a href="index.php?p=emails" title="Send Emails">Send Emails</a></li>
			<li class="active"><a href="javascript:void(0);" title="General">General</a></li>			
			<li class="subitems"><a href="index.php?p=config" title="Settings">Settings</a></li>
			<li><a href="../" target="_blank" >Visit Site</a></li>
			<li><a href="index.php?p=flag_adds" title="Flag Adds">Flag Adds</a></li>
			<?php /*?><li><a href="index.php?p=user_inbox" title="User Inbox">Users Inbox</a></li><?php */?>
			<li><a href="index.php?p=user_credit" title="User Credits">Users Credits</a></li><br />
			<li><a href="index.php?p=invoices" title="Invoices">Invoices</a></li><br />
			<li><a href="index.php?p=daily_password" title="Daily Password">Daily Password</a></li><br />
			<li><a href="index.php?p=payment_methods" title="Payment Methods">Payment Methods</a></li><br />
			<li><a href="index.php?p=expiration" title="Expiration">Expiration</a></li><br />
			<li><a href="index.php?p=zip_codes" title="Advertising Zip Codes">Advertising Zip Codes</a></li><br />
			<?php } else { 
				foreach($_SESSION['logger_tasks'] as $task) { 
					if($task==1) echo '<li><a href="index.php?p=users" title="Registered Users">Registered Users</a></li>';
					elseif($task==2) echo '<li><a href="index.php?p=ads" title="Listings">Listings</a></li>';
					//elseif($task==3) echo '<li><a href="index.php?p=ads" title="Listings">Listings</a></li>';
					elseif($task==3) echo '<li><a href="index.php?p=mem" title="Listings">Manage Memberships</a></li>';
					elseif($task==4) echo '<li><a href="index.php?p=giftcoupons" title="gift coupons">Gift Coupons</a></li>';
					elseif($task==5) echo '<li><a href="index.php?p=discountcoupons" title="Discount coupons">Discount Coupons</a></li>';
					elseif($task==6) echo '<li><a href="index.php?p=emails" title="Send Emails">Send Emails</a></li>';
					elseif($task==7) echo '<li><a href="index.php?p=flag_adds" title="Flag Adds">Flag Adds</a></li>';
					elseif($task==9) echo '<li><a href="index.php?p=user_credit" title="User Credits">Users Credits</a></li>';
					elseif($task==10) echo '<li><a href="index.php?p=invoices" title="Invoices">Invoices</a></li>';
					elseif($task==11) echo '<li><a href="index.php?p=payment_methods" title="Payment Methods">Payment Methods</a></li>';
					elseif($task==12) echo '<li><a href="index.php?p=expiration" title="Expiration">Expiration</a></li>';
					elseif($task==13) echo '<li><a href="index.php?p=zip_codes" title="Advertising Zip Codes">Advertising Zip Codes</a></li>';
			} } ?>
		</ul>
		<span class="clear"></span>