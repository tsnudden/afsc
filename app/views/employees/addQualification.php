<h3>Add Qualification: "<?php echo $data['qualification']->qualification_name; ?>"</h3>

<?php
$info = array(	"Name" 			=> array("field" => "qualification_name", 		"type" => "text"),
				"Expiry Date" 	=> array("field" => "qualification_expiry_date","type" => "date"),
				"Send Reminder <small>(1 month before expiry)<small>" => array("field" => "remind","type" => "checkbox")
				
			);
// $info2 = array(	"Address" 		=> array("field" => "employee_address", "type" => "textarea", "value" => $data['employee']->employee_address)
			// );
?>
<form method="post" action="">
	<input type="hidden" name="employee_id" value="<?php echo $_GET['id']; ?>" />
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
						case "checkbox":
							?>
							<strong><?php echo $key; ?> </strong><br />
							<input type="checkbox" id="<?php echo $value['field']; ?>" name="<?php echo $value['field']; ?>" />
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
			}
			?>
			<button type="submit" class="btn btn-success">Add Qualification</button>
		</div>
	</div>
</form>