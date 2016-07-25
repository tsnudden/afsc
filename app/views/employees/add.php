<h3>Add Employee</h3>

<?php
$info = array(	"Full Name" 	=> array("field" => "employee_name", 	"type" => "text"),
				"Date of Birth" => array("field" => "employee_dob", 	"type" => "date"),
				"Email Address" => array("field" => "employee_email", 	"type" => "text"),
				"Phone Number" 	=> array("field" => "employee_phone", 	"type" => "text"),
				"Mobile Number" => array("field" => "employee_mobile", 	"type" => "text")
				
			);
$info2 = array(	"Address" 		=> array("field" => "employee_address", "type" => "textarea")
			);
?>
<form method="post" action="">
	<div class="row edit-panel">
		<div class="col-md-6">
			<?php
			foreach($info as $key=>$value) {
				?>
				<div>
					<?php
					switch($value['type']) {
						case "text":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" />
							<?php
							break;
						case "textarea":
							?>
							
								<strong><?php echo $key; ?> </strong><br />
								<textarea id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>"></textarea>
							
							<?php
							break;
						case "date":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input class="datepicker-input" type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" />
							<?php
							break;
						
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<div class="col-md-6">
			<?php
			foreach($info2 as $key=>$value) {
				?>
				<div>
					<?php
					switch($value['type']) {
						case "text":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" />
							<?php
							break;
						case "textarea":
							?>
							
								<strong><?php echo $key; ?> </strong><br />
								<textarea id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>"></textarea>
							
							<?php
							break;
						case "date":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input class="datepicker-input" type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" />
							<?php
							break;
						
					}
					?>
				</div>
				<?php
			}
			?>
			<button type="submit" class="btn btn-success">Add Employee</button>
		</div>
	</div>
</form>