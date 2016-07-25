<h3>Edit New Start Item</h3>

<form method="post" action="">
	<div class="row edit-panel">
		<div class="col-md-6">
			<label for="item_name">Item Name</label><br />
			<input name="item_name" value="<?php echo $data['new_start']->item_name; ?>" />
		</div>
		<div class="col-md-6">
			<button type="submit" class="btn btn-success">Edit Item</button>
		</div>
	</div>
</form>