<?php
session_start();
include('includes/config.php');

$loginSuccess = false;
$loginError = false;
// Prevent back button access after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

if (isset($_POST['login'])) {
	$uname = $_POST['username'];
	$password = $_POST['password']; // Use password_hash in production

	// Prepared statement to prevent SQL injection
	$stmt = $con->prepare("SELECT Email, Password, userType FROM tblstaff WHERE Email = ? AND Password = ?");
	$stmt->bind_param("ss", $uname, $password);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$user = $result->fetch_assoc();
		$_SESSION['login'] = $user['Email'];
		$_SESSION['utype'] = $user['userType'];
		$loginSuccess = true;
	} else {
		$loginError = true;
	}

	$stmt->close();
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Gym Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="assets/css/login.css">
	<style>
		.form-wrapper {
			position: relative;
		}

		#togglePassword {
			position: absolute;
			right: 15px;
			top: 69%;
			transform: translateY(-50%);
			cursor: pointer;
			color: #888;
		}
	</style>
</head>

<body>

	<div class="wrapper"
		style="background-image: url('assets/images/bg.png'); background-size: cover; background-repeat: no-repeat;">
		<div class="inner">
			<form method="post">
				<img src="assets/images/black.png" alt="" />
				<h2>Login</h2>
				<div class="form-wrapper">
					<label for="">Email</label>
					<input name="username" type="text" class="form-control" required>
				</div>
				<div class="form-wrapper">
					<label for="">Password</label>
					<input id="password" name="password" type="password" class="form-control" required>
					<i id="togglePassword" class="fa-solid fa-eye"></i>
				</div>
				<button class="btn" type="submit" name="login">Login</button>
			</form>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://kit.fontawesome.com/ae115648d7.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		// Toggle password visibility
		const togglePassword = document.getElementById('togglePassword');
		const password = document.getElementById('password');

		togglePassword.addEventListener('click', function () {
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			this.classList.toggle('fa-eye');
			this.classList.toggle('fa-eye-slash');
		});
	</script>

	<?php if ($loginSuccess): ?>
		<script>
			const Toast = Swal.mixin({
				toast: true,
				position: 'bottom-end',
				showConfirmButton: false,
				showCloseButton: true,
				timer: 1000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});

			Toast.fire({
				icon: 'success',
				title: 'Login successful!'
			});

			setTimeout(() => {
				window.location.href = 'dashboard.php';
			}, 1000);
		</script>
	<?php endif; ?>

	<?php if ($loginError): ?>
		<script>
			Swal.fire({
				toast: true,
				icon: 'error',
				title: 'Invalid Email or Password',
				position: 'bottom-end',
				showCloseButton: true,
				showConfirmButton: false,
				timer: 1000,
				timerProgressBar: true
			});
		</script>
	<?php endif; ?>

	<!-- Logout on browser back button -->
	<script>
		// Prevent going back to this page after logout
		history.pushState(null, null, location.href);
		window.onpopstate = function () {
			// When user presses back, send them to login page or prevent back
			location.replace("logout.php");
		};
	</script>

</body>

</html>