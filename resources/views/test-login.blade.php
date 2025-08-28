<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Login Form</h1>
    <p>CSRF Token: {{ csrf_token() }}</p>
    <p>Session ID: {{ session()->getId() }}</p>
    
    <form method="POST" action="/login">
        {{ csrf_field() }}
        
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="admin@alphainspections.co.za" required>
        </div>
        
        <div>
            <label>Password:</label>
            <input type="password" name="password" value="admin123" required>
        </div>
        
        <button type="submit">Login</button>
    </form>
    
    <hr>
    
    <h2>Test Accounts:</h2>
    <ul>
        <li>Admin: admin@alphainspections.co.za / admin123</li>
        <li>Inspector: inspector@alphainspections.co.za / inspector123</li>
        <li>User: user@alphainspections.co.za / user123</li>
    </ul>
</body>
</html>