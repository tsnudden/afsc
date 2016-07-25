<?php
	
	namespace Helpers;
	
	class NotificationHelper {
		
		public function note($message, $type) {
			$_SESSION['notifications'][] = array("message" => $message, "type" => $type);
		}
		
		public function display() {
			if(isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
				?>
				<div class="notifications">
					<?php
					foreach($_SESSION['notifications'] as $notification) {
						?>
						<div class="notification <?php echo $notification['type']; ?>">
							<?php echo $notification['message']; ?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
				unset($_SESSION['notifications']);
			}
			
		}
		
	}
	
?>