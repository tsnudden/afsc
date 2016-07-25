<h3><?php echo $data['title']; ?> 
<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("operatingprocedures", 2, 0)) {
	?>
	<a href="/operating-procedures/edit?id=<?php echo $data['operatingprocedure']->operating_procedure_id; ?>"><button class="btn btn-primary">Edit Operating Procedure</button></a>
	<?php
}
?>
</h3>

<?php
echo nl2br($data['operatingprocedure']->operating_procedure_text);
?>