<h3>Edit User</h3>

<?php
$levels = array("0" => "No Access",
				"1" => "Can View",
				"2" => "Can Edit");
$user_food_access 					= $data['user']->user_food_access;
$user_employees_access 				= $data['user']->user_employees_access;
$user_healthsafety_access 			= $data['user']->user_healthsafety_access;
$user_operatingprocedures_access 	= $data['user']->user_operatingprocedures_access;
?>

<form method="POST" action="">
	<div class="row edit-panel">
		<div class="col-md-6">
			<div>
				<label for="user_username">Username</label><br />
				<input value="<?php echo $data['user']->user_username; ?>" type="text" name="user_username" id="user_username" />
			</div>
			
			<div>
				<label for="user_password">New Password</label><br />
				<input type="password" name="user_password" id="user_username" />
			</div>
			
			<?php
			if($_SESSION['user']['user_admin'] == 1) {
				if($data['user']->user_admin == 1) {
					$checked = "checked";
				} else {
					$checked = "";
				}
				?>
				<div>
					<label for="user_admin">Admin (this user will be able to add and edit users)</label><br />
					<input <?php echo $checked; ?> type="checkbox" name="user_admin" id="user_admin" />
				</div>
				<?php
			}
			?>
			
		</div>
		<div class="col-md-6">
			<div>
				<label for="user_level">Access Levels</label><br />
				<div>
					<label for="user_food_access">Food Products</label><br />
					<select name="user_food_access" id="user_food_access">
						<?php
						foreach($levels as $key=>$value) {
							if($user_food_access == $key) {
								$selected = "selected";
							} else {
								$selected = "";
							}
							echo "<option " . $selected . " value='" . $key . "'>" . $value . "</option>";
						}
						?>
					</select>
				</div>
				
				<div>
					<label for="user_employees_access">Employees</label><br />
					<select name="user_employees_access" id="user_employee_access">
						<?php
						foreach($levels as $key=>$value) {
							if($user_employees_access == $key) {
								$selected = "selected";
							} else {
								$selected = "";
							}
							echo "<option " . $selected . " value='" . $key . "'>" . $value . "</option>";
						}
						?>
					</select>
				</div>
				
				<div>
					<label for="user_healthsafety_access">Health &amp; Safety</label><br />
					<select name="user_healthsafety_access" id="user_healthsafety_access">
						<?php
						foreach($levels as $key=>$value) {
							if($user_healthsafety_access == $key) {
								$selected = "selected";
							} else {
								$selected = "";
							}
							echo "<option " . $selected . " value='" . $key . "'>" . $value . "</option>";
						}
						?>
					</select>
				</div>
				
				<div>
					<label for="user_operatingprocedures_access">Operating Procedures</label><br />
					<select name="user_operatingprocedures_access" id="user_operatingprocedures_access">
						<?php
						foreach($levels as $key=>$value) {
							if($user_operatingprocedures_access == $key) {
								$selected = "selected";
							} else {
								$selected = "";
							}
							echo "<option " . $selected . " value='" . $key . "'>" . $value . "</option>";
						}
						?>
					</select>
				</div>
			</div>

			<div>
				<button  class="btn btn-success" type="submit">Edit User</button>
			</div>
		</div>
	</div>
</form>