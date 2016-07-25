<h3>Add Operating Procedure
<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("operatingprocedures", 2, 0)) {
	?>
	<!--<a href="/operating-procedures/edit?id=<?php echo $data['operatingprocedure']->operating_procedure_id; ?>"><button class="btn btn-primary">Edit Operating Procedure</button></a>-->
	<?php
}
?>
</h3>
<form method="POST" action="">
	<label for="operating_procedure_name">Name</label><br />
	<input type="text" id="operating_procedure_name" name="operating_procedure_name" /><br /><br />
	
	<label for="operating_procedure_text">Text</label><br />
	<textarea id="operating_procedure_text" name="operating_procedure_text" class="large-edit-textarea"></textarea>
	<button type="submit" class="pull-right btn btn-primary">Save</button>
</form>