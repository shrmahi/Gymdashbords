<?php
session_start();
include('includes/config.php');

$loginSuccess = false;
$loginError = false;

$registerSuccess = false;
$registerError = "";

// Prevent back button after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

if (isset($_POST['login'])) {

    $email = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement (SECURE)
    $stmt = $con->prepare("
        SELECT id, Email, Password, userType 
        FROM login 
        WHERE Email = ?
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // ⚠️ For production use password_verify()
        if ($password === $user['Password']) {

            $_SESSION['login']   = $user['Email'];
            $_SESSION['uid']     = $user['id'];
            $_SESSION['utype']   = $user['userType'];

            // Role-based redirect
            switch ($user['userType']) {

                case 'admin':
                    header("Location: dashboard.php");
                    exit;

                case 'owner':
                    header("Location: OwnerDashboard.php");
                    exit;

                case 'manager':
                    header("Location: ManagerDashboard.php");
                    exit;

                case 'staff':
                    header("Location: TrainerDashboard.php");
                    exit;

                default:
                    $loginError = true;
            }

        } else {
            $loginError = true;
        }
    } else {
        $loginError = true;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Dashboard | Login & Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f9ff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .auth-card {
            width: 420px;
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #2196f3, #7c4dff);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            color: #fff;
            font-size: 28px;
        }

        .toggle-box {
            background: #f1f5f9;
            border-radius: 12px;
            display: flex;
            position: relative;
            margin: 25px 0;
        }

        .toggle-btn {
            flex: 1;
            padding: 10px;
            border: none;
            background: transparent;
            font-weight: 600;
            z-index: 1;
        }

        .slider {
            position: absolute;
            width: 50%;
            height: 100%;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: 0.4s;
        }

        .slider.signup {
            left: 50%;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
        }

        .btn-gradient {
            /* background-color: #CD0C2B; */
            background: linear-gradient(135deg, #e30613, #e30613);;
            border: none;
            color: #fff;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .password-eye {
            position: absolute;
            right: 15px;
            top: 38px;
            cursor: pointer;
            color: #888;
        }

        .d-none {
            display: none;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="text-center">
        <!-- <div class="logo mb-3">
            <i class="fas fa-dumbbell"></i>
        </div>
        <h4 class="fw-bold"></h4> -->
        <img src="assets/images/logo.jpg" alt="Logo" class="mb-3" style="width: 100px;">
    </div>

    <!-- Toggle -->
    <div class="toggle-box">
        <div class="slider" id="slider"></div>
        <button class="toggle-btn" onclick="showLogin()">Login</button>
        <button class="toggle-btn" onclick="showSignup()">Sign Up</button>
    </div>

    <!-- Login Form -->
    <form id="loginForm" method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="username" class="form-control" placeholder="you@example.com">
        </div>

        <div class="mb-3 position-relative">
            <label>Password</label>
            <input type="password" class="form-control" name="password" id="loginPassword">
            <i class="fa fa-eye password-eye" onclick="togglePassword('loginPassword')"></i>
        </div>
		<?php if ($loginError) { ?>
        <div class="alert alert-danger">
            Invalid Email or Password
        </div>
   		 <?php } ?>

         <button type="submit" name="login"
            class="btn btn-gradient w-100">
        Sign In
    	</button>
    </form>

    <!-- Signup Form -->
    <form id="signupForm" class="d-none" method="POST" action="register.php">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="you@example.com">
        </div>

        <div class="mb-3 position-relative">
            <label>Password</label>
            <input type="password" name="password"
               id="signupPassword" class="form-control" required>
            <i class="fa fa-eye password-eye" onclick="togglePassword('signupPassword')"></i>
        </div>
		<div class="mb-3">
        <label>Select Role</label>
        <select name="userType" class="form-control" required>
            <option value="">-- Select Role --</option>
            <option value="owner">Gym Owner</option>
            <option value="manager">Manager</option>
            <option value="staff">Staff</option>
        </select>
    	</div>

		<?php if ($registerError != "") { ?>
        <div class="alert alert-danger">
            <?= htmlentities($registerError); ?>
        </div>
		<?php } ?>

		<?php if ($registerSuccess) { ?>
			<div class="alert alert-success">
				Registration successful! You can now login.
			</div>
		<?php } ?>


        <button type="submit" name="register" class="btn btn-gradient w-100">Create Account</button>
    </form>
</div>

<!-- JS -->
<script>
    function showSignup() {
        document.getElementById("loginForm").classList.add("d-none");
        document.getElementById("signupForm").classList.remove("d-none");
        document.getElementById("slider").classList.add("signup");
    }

    function showLogin() {
        document.getElementById("signupForm").classList.add("d-none");
        document.getElementById("loginForm").classList.remove("d-none");
        document.getElementById("slider").classList.remove("signup");
    }

    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }
</script>

</body>
</html>
