<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['logged'])) {
    header("Location: dashboard.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "event") or die("DB Error");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // SECURITY: Use real_escape_string to prevent SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['email']); 
    $password = md5($_POST['password']); 

    $sql = "SELECT * FROM `user`
            WHERE username='$username'
            AND password='$password'";

    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count === 1) 
	{
        $row = mysqli_fetch_assoc($query);
        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPro Admin | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(135deg, rgba(67, 97, 238, 0.05) 0%, rgba(76, 201, 240, 0.05) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0.1;
            z-index: -1;
        }
        
        .bg-shape-1 { width: 600px; height: 600px; top: -300px; left: -200px; }
        .bg-shape-2 { width: 400px; height: 400px; bottom: -200px; right: -100px; }
        .bg-shape-3 { width: 200px; height: 200px; top: 50%; right: 20%; }
        
        .login-container { width: 100%; max-width: 420px; padding: 20px; }
        
        .login-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .login-header h1 { font-weight: 700; font-size: 1.8rem; margin-bottom: 5px; }
        .login-header p { opacity: 0.9; font-size: 0.9rem; }
        .login-header i { font-size: 2.5rem; margin-bottom: 15px; display: block; color: rgba(255, 255, 255, 0.9); }
        
        .login-body { padding: 30px; }
        
        .form-group { margin-bottom: 20px; position: relative; }
        .form-label { font-weight: 600; color: #495057; margin-bottom: 8px; font-size: 0.9rem; }
        
        .input-group-text { background-color: white; border-right: 0; color: var(--primary-color); }
        
        .form-control {
            border-left: 0; padding-left: 0; height: 50px; border-color: #ced4da; transition: all 0.3s;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15); border-color: var(--primary-color);
        }
        
        .password-toggle {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #6c757d; cursor: pointer; z-index: 10;
        }
        
        .login-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none; color: white; padding: 14px; font-weight: 600;
            border-radius: 8px; width: 100%; transition: all 0.3s; margin-bottom: 20px;
        }
        .login-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3); }
        
        /* Alert Styling */
        .alert { border-radius: 8px; padding: 12px 15px; margin-bottom: 20px; font-size: 0.9rem; display: none; }
        .alert-danger { background-color: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.2); color: #dc3545; }
        
        /* Shake animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake { animation: shake 0.5s ease-in-out; }
    </style>
</head>
<body>
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
    <div class="bg-shape bg-shape-3"></div>
    
    <div class="login-container">
        <div class="login-card" id="loginCard">
            <div class="login-header">
                <i class="bi bi-calendar-event"></i>
                <h1>EventPro Admin</h1>
                <p>Events Management System</p>
            </div>
            
            <div class="login-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" id="errorAlert" style="display: block;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form id="loginForm" action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="username" class="form-label">Username or Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" class="form-control" id="username" name="email" placeholder="Enter username" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="login-btn" id="loginButton">
                        <span class="btn-text">Sign In</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
	<script>
// Inside the document.ready function of index.php
const urlParams = new URLSearchParams(window.location.search);
const msg = urlParams.get('msg');

if (msg === 'signup_success') {
    Swal.fire({
        title: 'Welcome to Nestu!',
        text: 'Thank you for registering. Your account is now active!',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Start Exploring'
    }).then(() => {
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    });
}
</script>
    <script src="js/javascript.js"></script>
    
   
</body>
</html>