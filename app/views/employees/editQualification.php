<h3>Edit Qualification: "<?php echo $data['qualification']->qualification_name; ?>"</h3>

<?php
if($data['qualification']->remind == 1) {
	$remind_value = "checked";
} else {
	$remind_value = "";
}
$info = array(	"Name" 			=> array("field" => "qualification_name", 		"type" => "text", "value" => $data['qualification']->qualification_name),
				"Expiry Date" 	=> array("field" => "qualification_expiry_date","type" => "date", "value" => date("j.m.Y", strtotime($data['qualification']->qualification_expiry_date))),
				"Send Reminder <small>(1 month before expiry)<small>" => array("field" => "remind","type" => "checkbox", "value" => $remind_value)
				
			);
// $info2 = array(	"Address" 		=> array("field" => "employee_address", "type" => "textarea", "value" => $data['employee']->employee_address)
			// );
?>
<form method="post" action="">
	<input type="hidden" name="employee-id" value="<?php echo $data['qualification']->employee_id; ?>" />
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
						case "checkbox":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input type="checkbox" <?php echo $value['value']; ?> id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" />
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
			if(is_array($info2)) {
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
			}
			?>
			<button type="submit" class="btn btn-success">Edit Qualification</button>
		</div>
	</div>
</form>