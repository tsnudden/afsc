<h3><?php echo $data['title']; ?>
	<?php
	use \Helpers\AccessHelper;
	if(AccessHelper::checkAccess("healthsafety", 2, 0)) {
		?>
		<a href="/health-and-safety/uploadDocument?id=<?php echo $_GET['id']; ?>"><button class="btn btn-primary">Upload Document</button></a> 
		<?php
	}
	?>
</h3>
<?php
if(!empty($data['items'])) {
	?>
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
			<td>Filename</td>
			<td>Date Added</td>
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
				<tr data-expiry-date="<?php echo date("jS F Y", strtotime($item->item_expiry_date)); ?>" data-item-name="<?php echo $item->doc_name; ?>" data-filename="<?php echo $item->filename; ?>" data-added="<?php echo $item->added; ?>">
					<td><?php echo $item->doc_name; ?></td>
					<td><?php echo $item->filename; ?></td>
					<td><?php echo date("jS F Y H:i:s", strtotime($item->added)); ?></td>
					<?php
					if(AccessHelper::checkAccess("healthsafety", 2, 0)) {
						?>
						<td>
							<?php
							echo "<a target='_blank' href='/docs/" . $_GET['id'] . "/" . $item->filename . "'><button class='action-button btn btn-success'>View</button></a>";
							echo "<a download href='/docs/" . $_GET['id'] . "/" . $item->filename . "'><button class='action-button btn btn-info'>Download</button></a>";
							echo "<a href='/health-and-safety/deleteDocument?id=" . $item->item_id . "&docId=" . $item->doc_id . "' onclick='return confirm(\"Are you sure you want to delete this document?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
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
	<?php
} else {
	echo "There are currently no documents for this health and safety item.";
}
?>