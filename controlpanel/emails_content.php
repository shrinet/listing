<?php defined('ACCESS_SUBFILES') or die('Restricted access');

$parent_show="SENT EMAILS CONTENT";					
?>
<h2><?php echo $parent_show; ?></h2>
<?PHP 
$email_sent="select * from ".TABLE_EMAIL_CONTENT." order by id desc";
$email_sent_row=$obj_db->get_qresult($email_sent);
?>
<form>
<fieldset>
<?php
while($email_sent_rows=$obj_db->fetchArray($email_sent_row)) { ?>

	<label>Content :</label>
	<span class="small_input" style="height:160px;"><textarea name="content"><?php echo mysql_real_escape_string($email_sent_rows['content']); ?></textarea></span><br class="hid" />
	
<?php } ?>
</fieldset>
</form>