<h3>Edit Category</h3>

<form method="POST" action="">
	<div class="row">
		<div class="col-md-6">
			<div>
				<label for="category_name">Category Name</label><br />
				<input type="text" name="category_name" id="category_name" value="<?php echo $data['category']->category_name; ?>" />
			</div>
			
			<div>
				<button  class="btn btn-success" type="submit">Edit Category</button>
			</div>
		</div>
	</div>
</form>