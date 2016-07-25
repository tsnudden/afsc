<h3>Edit Ingredient: <?php echo $data['title']; ?></h3>
<form method="post" action="">
	<label for="ingredient-name">Ingredient Name</label><br />
	<input id="ingredient-name" name="ingredient-name" value="<?php echo $data['ingredient']->ingredient_name ?>" type="text" />
	<input type="hidden" name="ingredient-id" value="<?php echo $data['ingredient']->id; ?>" />
	<input type="hidden" name="product-id" value="<?php echo $data['ingredient']->food_product_id; ?>" />
	
	<br />
	
	<button type="submit" class="btn btn-success">Edit Ingredient</button>
</form>