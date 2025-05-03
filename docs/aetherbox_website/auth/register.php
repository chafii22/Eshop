<?php
// Start session
session_start();

// Database connection parameters
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Replace with your db username
define('DB_PASS', 'kurosensei2468#KURO'); // Replace with your db password
define('DB_NAME', 'aetherbox'); // Replace with your db name

// Initialize variables
$username = $email = $password = $confirm_password = '';
$errors = [];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate username
    if (!isset($_POST['username']) || empty(trim($_POST['username']))) {
        $errors[] = "User name is required";
    } else {
        $username = trim($_POST['username']);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $errors[] = "User name can only contain letters and numbers";
        }
    }
    
    // Validate email
    if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
        $errors[] = "Email is required";
    } else {
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        } else {
            // Check if email already exists
            try {
                $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn->prepare("SELECT id FROM clients WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $errors[] = "Email already exists";
                }
            } catch(PDOException $e) {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
    
    // Validate password
    if (!isset($_POST['password']) || empty(trim($_POST['password']))) {
        $errors[] = "Password is required";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $errors[] = "Password must be at least 6 characters";
    } else {
        $password = trim($_POST['password']);
    }
    
    // Confirm password
    if (!isset($_POST['confirm_password']) || empty(trim($_POST['confirm_password']))) {
        $errors[] = "Please confirm password";
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $errors[] = "Passwords do not match";
        }
    }
    
    // If no errors, insert user into database
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO clients (username, email, password, created_at) VALUES (:username,:email, :password, NOW())";
            $stmt = $conn->prepare($sql);
            
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Bind parameters
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "Registration successful! Please login.";
                header("Location: login.php");
                exit();
            }
        } catch(PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
        
        $conn = null;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.5/dist/tailwind.min.css" rel="stylesheet">
    <script src="../js/register.js"></script>
</head>
<body>
    <div class="container">
        <h2>Create an Account</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <?php foreach($errors as $error): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">User Name</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password">
            </div>
            
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>