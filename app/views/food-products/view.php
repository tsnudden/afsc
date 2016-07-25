<h3><?php echo $data['title']; ?> 
<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("food", 2, 0)) {
	?>
	<a href="/food-products/edit?id=<?php echo $data['product']->food_product_id ?>"><button class="btn btn-primary">Edit Product</button></a>
	<?php
}
?>
</h3>
<h5>Ingredients</h5>
<table class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<td>Name</td>
			<?php
			if(AccessHelper::checkAccess("food", 2, 0)) {
				?>
				<td>Actions</td>
				<?php
			}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($data['product']->ingredients as $ingredient) {
			// echo "<pre>";
			// print_r($ingredient);
			// exit();
			?>
			<tr>
				<td><?php echo $ingredient->ingredient_name; ?></td>
				<?php
				echo "</td>";
				if(AccessHelper::checkAccess("food", 2, 0)) {
					echo "<td>";
						echo "<a href='/food-products/deleteIngredient?id=" . $data['product']->food_product_id . "&ingredient_id=" . $ingredient->id . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
						echo "<a href='/food-products/editIngredient?id=" . $ingredient->id . "'><button class='action-button btn btn-info'>Edit</button></a>";
					echo "</td>";
				}
				?>
			</tr>
			<?php
			
		}
		if(AccessHelper::checkAccess("food", 2, 0)) {
			?>		
			<tr>
				<td colspan="2">
					<form method="post" action="/food-products/addIngredient">
						<label for="ingredient-name">New Ingredient</label><br />
						<input id="ingredient-name" name="ingredient-name" type="text" />
						<input type="hidden" name="product-id" value="<?php echo $data['product']->food_product_id; ?>" />
						<button class="btn btn-primary" type="submit">Add</button>
					</form>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>