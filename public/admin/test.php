<?php
require_once("../../includes/initialize.php");
if(!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php include_layout_template('admin_header.php'); ?>
			
<?php 
$user->username = "jawad";
$user->password = "jawad";
$user->first_name ="jawad";
$user->last_name="sadiq";
$user->create();
?>
		<?php include_layout_template('admin_footer.php'); ?>