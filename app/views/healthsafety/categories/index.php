<h3>Health &amp; Safety Categories <a href="/health-and-safety/categories/add""><button class="btn btn-primary">Add Category</button></a></h3>
<table id="health-and-safety-table" class="table search-table table-hover table-striped table-bordered">
	<thead>
		<td>Name</td>
		<td>Actions</td>
	</thead>
	<tbody id="health-and-safety-body">
		<?php
		foreach($data['categories'] as $item) {
			?>
			<tr>
				<td><?php echo $item->category_name; ?></td>
				<td>
					<?php
					echo "<a href='/health-and-safety/categories/delete?id=" . $item->category_id . "' onclick='return confirm(\"Are you sure you want to delete this Qualification?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
					echo "<a href='/health-and-safety/categories/edit?id=" . $item->category_id . "'><button class='action-button btn btn-info'>Edit</button></a>";
					?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>