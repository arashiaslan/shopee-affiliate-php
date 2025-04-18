<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 400px; margin: auto; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>Login Admin</h2>
    <form method="POST">
        <div style="display: flex; flex-direction: column; gap: 20px; width: 375px;">
            <input type="text" name="username" placeholder="Username" required autofocus style="padding: 10px; border: 1px solid #ccc; box-sizing: border-box;">
            <input type="password" name="password" placeholder="Password" required style="padding: 10px; border: 1px solid #ccc; box-sizing: border-box;">
            <button type="submit" style="background-color: #EE4D2D; color: white; padding: 10px; border: none; cursor: pointer; box-sizing: border-box;">Masuk</button>
            <?php if ($error): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
        </div>
    </form>

</body>
</html>
