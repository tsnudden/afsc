<h3>Edit Employee: "<?php echo $data['employee']->employee_name; ?>"</h3>

<?php
$info = array(	"Full Name" 	=> array("field" => "employee_name", 	"type" => "text", "value" => $data['employee']->employee_name),
				"Date of Birth" => array("field" => "employee_dob", 	"type" => "date", "value" => date("j.m.Y", strtotime($data['employee']->employee_dob))),
				"Email Address" => array("field" => "employee_email", 	"type" => "text", "value" => $data['employee']->employee_email),
				"Phone Number" 	=> array("field" => "employee_phone", 	"type" => "text", "value" => $data['employee']->employee_phone),
				"Mobile Number" => array("field" => "employee_mobile", 	"type" => "text", "value" => $data['employee']->employee_mobile)
				
			);
$info2 = array(	"Address" 		=> array("field" => "employee_address", "type" => "textarea", "value" => $data['employee']->employee_address)
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
							<input type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" value="<?php echo $value['value']; ?>" />
							<?php
							break;
						case "textarea":
							?>
							
								<strong><?php echo $key; ?> </strong><br />
								<textarea id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>"><?php echo $value['value']; ?></textarea>
							
							<?php
							break;
						case "date":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input class="datepicker-input" type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" value="<?php echo date("d/m/Y", strtotime($value['value'])); ?>" />
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
							<input type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" value="<?php echo $value['value']; ?>" />
							<?php
							break;
						case "textarea":
							?>
							
								<strong><?php echo $key; ?> </strong><br />
								<textarea id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>"><?php echo $value['value']; ?></textarea>
							
							<?php
							break;
						case "date":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input class="datepicker-input" type="text" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" value="<?php echo date("d/m/Y", strtotime($value['value'])); ?>" />
							<?php
							break;
						
					}
					?>
				</div>
				<?php
			}
			?>
			<button type="submit" class="btn btn-success">Edit Employee</button>
		</div>
	</div>
</form>