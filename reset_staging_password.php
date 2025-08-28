<?php
// Password reset script for staging server
// Upload this file to /home/alphains/public_html/ and run via browser

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Security - only allow from specific IP or remove this script after use
// if (!in_array($_SERVER['REMOTE_ADDR'], ['your.ip.here'])) {
//     die('Access denied');
// }

$success = '';
$error = '';

if ($_POST['action'] ?? '' === 'reset') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        $user = App\Models\User::where('email', $email)->first();
        
        if ($user) {
            $user->password = Illuminate\Support\Facades\Hash::make($password);
            $user->save();
            $success = "Password updated for {$user->name} ({$user->email})";
        } else {
            $error = "User with email {$email} not found.";
        }
    } else {
        $error = "Please provide both email and password.";
    }
}

// Get all users
$users = App\Models\User::all(['id', 'name', 'email', 'role']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Tool</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .success { color: green; padding: 10px; background: #e8f5e8; }
        .error { color: red; padding: 10px; background: #f5e8e8; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form { background: #f9f9f9; padding: 20px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Password Reset Tool</h1>
    
    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <h2>Current Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= htmlspecialchars($user->name) ?></td>
            <td><?= htmlspecialchars($user->email) ?></td>
            <td><?= htmlspecialchars($user->role) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <div class="form">
        <h2>Reset Password</h2>
        <form method="POST">
            <input type="hidden" name="action" value="reset">
            <p>
                <label>Email:</label><br>
                <input type="email" name="email" required style="width: 300px; padding: 5px;">
            </p>
            <p>
                <label>New Password:</label><br>
                <input type="text" name="password" required style="width: 300px; padding: 5px;">
            </p>
            <p>
                <button type="submit" style="padding: 10px 20px; background: #007cba; color: white; border: none;">Reset Password</button>
            </p>
        </form>
    </div>
    
    <p style="color: red; font-weight: bold;">SECURITY WARNING: Delete this file after use!</p>
</body>
</html>