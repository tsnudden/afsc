<h3>Email Operating Procedure: "<?php echo $data['title']; ?>"
<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("operatingprocedures", 1, 0)) {
	?>
	<!--<a href="/operating-procedures/edit?id=<?php echo $data['operatingprocedure']->operating_procedure_id; ?>"><button class="btn btn-primary">Edit Operating Procedure</button></a>-->
	<?php
}
?>
</h3>
<form method="POST" action="">
	<label for="operating_procedure_name">Send To (comma separated list)</label><br />
	<input style="width: 70%;" type="text" id="operating_procedure_email_send_to" name="operating_procedure_email_send_to" /><br /><br />
	
	<label for="operating_procedure_message">Message Body</label><br />
	<textarea id="operating_procedure_email_message" name="operating_procedure_email_message" class=""></textarea>
	<br />
	PDF will be attached to the email
	<br />
	<button type="submit" class="pull-right btn btn-primary">Send</button>
</form>