<h3>Health &amp; Safety 
	<?php
	use \Helpers\AccessHelper;
	if(AccessHelper::checkAccess("healthsafety", 2, 0)) {
		?>
		<a href="/health-and-safety/add""><button class="btn btn-primary">Add Health &amp; Safety Item</button></a> 
		<a href="/health-and-safety/categories/manage""><button class="btn btn-primary">Manage Categories</button></a>
		<?php
	}
	?>
</h3>
<div class="search">
	<div class="search-title">
		SEARCH
	</div>
	<label for="keyword">Keyword</label><br />
	<input id="keyword" name="keyword" type="text" />
</div>
<table id="health-and-safety-table" class="table search-table table-hover table-striped table-bordered">
	<thead>
		<td>Name</td>
		<td width="120">Category</td>
		<td width="250">Notes</td>
		<td>Last Inspected</td>
		<td>Expiry Date</td>
		<td width="110">Remind One Month Before</td>
		<?php
		if(AccessHelper::checkAccess("healthsafety", 2, 0)) {
			?>
			<td>Actions</td>
			<?php
		}
		?>
	</thead>
	<tbody id="health-and-safety-body">
		<?php
		foreach($data['items'] as $item) {
			?>
			<tr data-expiry-date="<?php echo date("jS F Y", strtotime($item->item_expiry_date)); ?>" data-last-inspected="<?php echo date("jS F Y", strtotime($item->item_last_inspected)); ?>" data-item-name="<?php echo $item->item_name; ?>" data-category-name="<?php echo $item->category_name; ?>" data-notes="<?php echo $item->item_notes; ?>">
				<td><?php echo $item->item_name; ?></td>
				<td>
					<strong><?php echo $item->category_name; ?></strong>
				</td>
				<td><?php echo $item->item_notes; ?></td>
				<td>
					<?php 
					if($item->item_last_inspected != "0000-00-00")
						echo date("jS F Y", strtotime($item->item_last_inspected)); 
					?>
				</td>
				<td>
					<?php 
					if($item->item_expiry_date != "0000-00-00")
						echo date("jS F Y", strtotime($item->item_expiry_date)); 
					?>
				</td>
				<td>
					<?php 
					if($item->remind) {
						echo "Yes";
					} else {
						echo "No";
					}
					?>
				</td>
				<?php
				if(AccessHelper::checkAccess("healthsafety", 2, 0)) {
					?>
					<td>
						<?php
						echo "<a href='/health-and-safety/delete?id=" . $item->item_id . "' onclick='return confirm(\"Are you sure you want to delete this Qualification?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
						echo "<a href='/health-and-safety/edit?id=" . $item->item_id . "'><button class='action-button btn btn-info'>Edit</button></a>";
						echo "<a href='/health-and-safety/viewdocs?id=" . $item->item_id . "'><button class='action-button btn btn-success'>Documents</button></a>";
						?>
					</td>
					<?php
				}
				?>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>