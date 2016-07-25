<h3>Food Products 
<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("food", 2, 0)) {
	?>
	<a href="/food-products/add"><button class="btn btn-primary">Add Food Product</button></a>
	<?php
}
?>
</h3>
<div class="search">
	<div class="search-title">
		SEARCH
	</div>
	<label for="keyword">Product or Ingredient</label><br />
	<input id="keyword" name="keyword" type="text" />
</div>
<table id="food-products-table" class="table search-table table-hover table-striped table-bordered">
	<thead>
		<td>Name</td>
		<td>Ingredients</td>
		<?php
		if(AccessHelper::checkAccess("food", 2, 0)) {
			?>
			<td>Actions</td>
			<?php
		}
		?>
	</thead>
	<tbody id="food-products-body">
		<?php
		foreach($data['food_products'] as $food_product) {
			// echo "<pre>";
			// print_r($food_product);
			// exit();
			$ingredient_count = 0;
			$ingredient_string = "";
			foreach($food_product->ingredients as $ingredient) {
				$ingredient_string .= $ingredient->ingredient_name;
				if($ingredient_count < count($food_product->ingredients)-1) {
					$ingredient_string .= ", ";
				}
				$ingredient_count++;
			}
			echo "<tr data-product-name='" . $food_product->food_product_name . "' data-ingredients='" . str_replace(", ", " ", strtolower($ingredient_string)) . "'>";
				echo "<td><a href='/food-products/view?id=" . $food_product->food_product_id . "'>" . $food_product->food_product_name . "</a></td>";
				echo "<td>";
					echo $ingredient_string;
				echo "</td>";
				if(AccessHelper::checkAccess("food", 2, 0)) {
					echo "<td>";
						echo "<a href='/food-products/delete?id=" . $food_product->food_product_id . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
						echo "<a href='/food-products/edit?id=" . $food_product->food_product_id . "'><button class='action-button btn btn-info'>Edit</button></a>";
					echo "</td>";
				}
			echo "</tr>";
		}
		?>
	</tbody>
</table>