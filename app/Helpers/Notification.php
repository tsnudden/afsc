<?php
	
	namespace Helpers;
	
	class NotificationHelper {
		
		public function note($message, $type) {
			echo "Adding to session: " . $message . " with type " . $type;
			exit();
			$_SESSION['notifications'][] = array("message" => $message, "type" => $type);
		}
		
		public function display() {
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
			session_start();
			if($_SESSION['notifications']) {
				?>
				<div class="notifications">
					<?php
					foreach($_SESSION['notifications'] as $notification) {
						?>
						<div class="notification <?php echo $notification['type']; ?>">
							<?php echo $notifiaction['message']; ?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
				// unset($_SESSION['notifications']);
			}
			
		}
		
	}
	
?>