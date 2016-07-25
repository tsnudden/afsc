<h3><?php echo $data['employee']->employee_name; ?> 

<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("employees", 2, 0)) {
	?>
	<a href="/employees/edit?id=<?php echo $data['employee']->employee_id ?>""><button class="btn btn-primary">Edit Employee</button></a> <a href="/employees/qualification/add?id=<?php echo $data['employee']->employee_id; ?>""><button class="btn btn-primary">Add Qualification</button></a>
	<?php
}
?>
</h3>

<?php
$info = array(	"Date of Birth" => date("d/m/Y", strtotime($data['employee']->employee_dob)),
				"Email Address" => $data['employee']->employee_email,
				"Phone Number" 	=> $data['employee']->employee_phone,
				"Mobile Number" => $data['employee']->employee_mobile,
				"Address" 		=> $data['employee']->employee_address
				
			);
?>

<table class="table table-bordered">
	<tr>
	<?php
	$count = 1;
	foreach($info as $key=>$value) {
		
		?>
		
		<td><strong><?php echo $key; ?>: </strong>
		<span><?php echo $value; ?> </span>
		
		<?php
		
		if($count % 2 == 0) {
			?>
			</tr>
			<tr>
			<?php
		}
		
		$count++;
		
	}
	?>
	</tr>
</table>

<?php
if(!empty($data['employee']->qualifications)) {
	?>

	<h4>Qualifications</h4>
	<div class="search qualification-search">
		<div class="search-title">
			SEARCH
		</div>
		<div class="search-element pull-left">
			<label for="keyword">Keyword</label><br />
			<input id="keyword" name="keyword" type="text" />
		</div>
		<div class="search-element pull-left">
			<label for="keyword">Type</label><br />
			<input class="data-search-term" data-term="active" checked type="checkbox" /> <span class="search-element">Active</span>
			<input class="data-search-term" data-term="expiring-soon" checked type="checkbox" /> <span class="search-element">Expiring Soon</span>
			<input class="data-search-term" data-term="expired" checked type="checkbox" /> <span class="search-element">Expired</span>
		</div>
		<div class="cf">
		</div>
	</div>
	<table class="table search-table table-hover table-striped table-bordered">
		<thead>
			<td>Name</td>
			<td>Expiry Date</td>
			<td>Status</td>
			<td>Remind One Month Before</td>
			<?php
			if(AccessHelper::checkAccess("employees", 2, 0)) {
				?>
				<td>Actions</td>
				<?php
			}
			?>
		</thead>
		<tbody id="qualification-body">
			<?php
			foreach($data['employee']->qualifications as $qualification) {
				
				$cdate = mktime(0, 0, 0, date("m", strtotime($qualification->qualification_expiry_date)), date("d", strtotime($qualification->qualification_expiry_date)), date("Y", strtotime($qualification->qualification_expiry_date)), 0);
				
				$today = time();
				
				$difference = (int)(($cdate - $today) / 86400);
				
				if($difference < 0) {
					$row_class = "danger";
					$status = "Expired";
				} elseif($difference <= 30 && $difference >= 0) {
					$row_class = "info";
					$status = "Expiring Soon";
				} else {
					$row_class = "success";
					$status = "Active";
				}
				
				?>
				
				<tr class="<?php echo $row_class; ?>" data-check-term="<?php echo strtolower(str_replace(" ", "-", $status)); ?>" data-qualification-name="<?php echo $qualification->qualification_name; ?>">
				
					<td><?php echo $qualification->qualification_name; ?></td>
					<td><?php echo date("jS F Y", strtotime($qualification->qualification_expiry_date)); ?></td>
					<td><?php echo $status; ?></td>
					<td>
						<?php 
						if($qualification->remind) {
							echo "Yes";
						} else {
							echo "No";
						}
						?>
					</td>
					<?php
					
					if(AccessHelper::checkAccess("employees", 2, 0)) {
						?>
						<td>
							<?php
							echo "<a href='/employees/qualification/delete?id=" . $qualification->qualification_id . "&e=" . $_GET['id'] . "' onclick='return confirm(\"Are you sure you want to delete this Qualification?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
							echo "<a href='/employees/qualification/edit?id=" . $qualification->qualification_id . "'><button class='action-button btn btn-info'>Edit</button></a>";
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
	
	echo "There are no qualifications for this user";
	
}

if(!empty($data['employee']->new_start_list)) {
	?>

	<h4>New Start List</h4>
	<table class="table search-table table-hover table-striped table-bordered">
		<thead>
			<td>Name</td>
			<td>Status</td>
			<?php
			if(AccessHelper::checkAccess("employees", 2, 0)) {
				?>
				<td>Actions</td>
				<?php
			}
			?>
		</thead>
		<tbody>
			<?php
			foreach($data['employee']->new_start_list as $item) {
				switch($item->item_status) {
					case 0:
						$row_class = "danger";
						$status = "Incomplete";
						break;
					case 1:
						$row_class = "success";
						$status = "Complete";
						break;
				}
				?>
				<tr class="<?php echo $row_class; ?>">
					<td><?php echo $item->item_name; ?></td>
					<td><?php echo $status; ?></td>
					<?php
					if(AccessHelper::checkAccess("employees", 2, 0)) {
						?>
						<td>
							<?php
							if($item->item_status == 0) {
								echo "<a href='/employees/new-start-item/complete?id=" . $item->item_id . "&e=" . $_GET['id'] . "'><button class='action-button btn btn-success'>Mark Complete</button></a>";
							} else {
								echo "<a href='/employees/new-start-item/incomplete?id=" . $item->item_id . "&e=" . $_GET['id'] . "'><button class='action-button btn btn-danger'>Mark Incomplete</button></a>";
							}
							
								echo "<a href='/employees/new-start-item/delete?id=" . $item->item_id . "&e=" . $_GET['id'] . "' onclick='return confirm(\"Are you sure you want to delete this Qualification?\");'><button class='action-button btn btn-danger'>Delete</button></a>";
								echo "<a href='/employees/new-start-item/edit?id=" . $item->item_id . "&e=" . $_GET['id'] . "'><button class='action-button btn btn-info'>Edit</button></a>";
							?>
						</td>
						<?php
					}
					?>
				</tr>
				<?php
				
			}
			if(AccessHelper::checkAccess("employees", 2, 0)) {
				?>
				<tr>
					<td colspan="2">
						<form method="post" action="">
							<label for="item-name">New Item</label><br />
							<input id="item-name" name="item-name" type="text" />
							<!--<input type="hidden" name="product-id" value="<?php echo $data['product']->food_product_id; ?>" />-->
							<button class="btn btn-primary" type="submit">Add</button>
						</form>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<?php
	
}
?>