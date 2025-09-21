
<?php
require_once __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $rawPass  = $_POST['password'] ?? '';

    if (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*]).{7,}$/', $rawPass)) {
        echo "<p style='color:red; text-align:center;'>❌ Password must be at least 7 characters long and include at least one number and one special character.</p>";
        echo "<p style='text-align:center;'><a href='registration.php'>Go back to Registration</a></p>";
        exit;
    }

    $password = password_hash($rawPass, PASSWORD_BCRYPT);
    $consent  = isset($_POST['consent']) ? 1 : 0;

    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM accounts WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo "<p style='color:red; text-align:center;'>❌ This email is already registered. Please log in or use another email.</p>";
            echo "<p style='text-align:center;'><a href='index.php'>Go to Login</a></p>";
            exit;
        }

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO accounts (name, email, phone, password, consent) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $password, $consent]);

        echo "<p style='color:green; text-align:center;'>✅ Registration successful! <a href='index.php'>Login here</a></p>";

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
