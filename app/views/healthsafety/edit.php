<h3>Edit Health and Safety Item</h3>

<?php
if($data['item']->remind == 1) {
	$remind = "checked";
} else {
	$remind = "";
}
?>

<form method="POST" action="">
	<div class="row edit-panel">
		<div class="col-md-6">
			<div>
				<label for="item_name">Item Name</label><br />
				<input type="text" name="item_name" id="item_name" value="<?php echo $data['item']->item_name; ?>" />
			</div>
			
			<div>
				<label for="item_category">Category</label><br />
				<select name="item_category" id="item_category">
					<option>Select a category..</option>
					<?php
					foreach($data['categories'] as $category) {
						if($data['item']->item_category == $category->category_id) {
							$selected = "selected";
						} else {
							$selected = "";
						}
						?>
						<option <?php echo $selected; ?> value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
						<?php
					}
					?>
				</select>
				<div>
					<a href="/health-and-safety/categories/manage">Manage Categories</a>
				</div>
				<br />
			</div>

			<div>
				<label for="item_last_inspected">Expiry Date</label><br />
				<input class="datepicker-input" type="text" name="item_last_inspected" id="item_last_inspected" value="<?php echo date("d/m/Y", strtotime($data['item']->item_last_inspected)); ?>" />
			</div>

			<div>
				<label for="item_expiry_date">Expiry Date</label><br />
				<input class="datepicker-input" type="text" name="item_expiry_date" id="item_expiry_date" value="<?php echo date("d/m/Y", strtotime($data['item']->item_expiry_date)); ?>" />
			</div>

			<div>
				<label for="remind">Send reminder (1 month before expiry)</label>
				<input type="checkbox" name="remind" id="remind" <?php echo $remind; ?> />
			</div>
		</div>
		<div class="col-md-6">
			<div>
				<label for="item_notes">Notes</label><br />
				<textarea name="item_notes" id="item_notes"><?php echo $data['item']->item_notes; ?></textarea>
			</div>
			
			<div>
				<button  class="btn btn-success" type="submit">Edit Item</button>
			</div>
		</div>
	</div>
</form>