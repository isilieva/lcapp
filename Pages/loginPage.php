<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
        }
        .input-field {
            display: block;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }
        .login-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="/Public/logo.jpg" alt="Logo" width="100">
        <h1>WELCOME</h1>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" class="input-field" required>
            <input type="password" name="password" placeholder="Password" class="input-field" required>
            <button type="submit" class="login-btn">LOG IN</button>
        </form>
    </div>
</body>
</html>

