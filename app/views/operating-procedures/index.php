<h3>Operating Procedures 
<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("operatingprocedures", 2, 0)) {
	?>
	<a href="/operating-procedures/add"><button class="btn btn-primary">Add Operating Procedure</button></a>
	<?php
}
?>
</h3>
<?php
if(!empty($data['operatingprocedures'])) {
	?>
	<div class="search">
		<div class="search-title">
			SEARCH
		</div>
		<label for="keyword">Keyword</label><br />
		<input id="keyword" name="keyword" type="text" />
	</div>
	<table id="operating-procedures-table" class="table search-table table-hover table-striped table-bordered">
		<thead>
			<td>Name</td>
			<?php
			if(AccessHelper::checkAccess("operatingprocedures", 2, 0)) {
				?>
				<td>Actions</td>
				<?php
			}
			?>
		</thead>
		<tbody id="employees-body">
			<?php
			foreach($data['operatingprocedures'] as $operatingprocedure) {
				
				echo "<tr data-operating-procedure-name='" . $operatingprocedure->operating_procedure_name . "'>";
					echo "<td><a href='/operating-procedures/view?id=" . $operatingprocedure->operating_procedure_id . "'>" . $operatingprocedure->operating_procedure_name . "</a></td>";
					
					if(AccessHelper::checkAccess("operatingprocedures", 2, 0)) {
						echo "<td>";
							echo "<a href='/operating-procedures/delete?id=" . $operatingprocedure->operating_procedure_id . "' onclick='return confirm(\"Are you sure you want to delete this Operating Procedure?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
							echo "<a href='/operating-procedures/edit?id=" . $operatingprocedure->operating_procedure_id . "'><button class='action-button btn btn-info'>Edit</button></a>";
							echo "<a href='/operating-procedures/print?id=" . $operatingprocedure->operating_procedure_id . "'><button class='action-button btn btn-success'>Print</button></a>";
							echo "<a href='/operating-procedures/email?id=" . $operatingprocedure->operating_procedure_id . "'><button class='action-button btn btn-warning'>Email</button></a>";
						echo "</td>";
					}
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
	<?php
} else {
	echo "There are currently no operating procedures in the system.";
}
?>