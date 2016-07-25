<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="login-box">
				<h3>Login:</h3>
				<form method="post" action="">
					<input type="text" name="username" /><br />
					<input type="password" name="password" /><br />
					<button class="btn btn-success" type="submit">Login</button>
				</form>
				<?php
				if($data['failed_attempt']) {
					?>
					<span class="login-error">Incorrect username/password combination</span>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>