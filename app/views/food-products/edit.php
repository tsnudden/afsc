<h3>Edit Food Product: "<?php echo $data['title']; ?>"</h3>
<form method="post" action="">
	<label for="food-product-name">Product Name</label><br />
	<input id="food-product-name" name="food-product-name" value="<?php echo $data['product']->food_product_name ?>" type="text" />
	
	<br />
	
	<button type="submit" class="btn btn-success">Edit Product</button>
</form>