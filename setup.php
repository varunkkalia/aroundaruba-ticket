<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Csrf;
use App\Core\Session;
use App\Models\Admin;

$adminModel = new Admin();

if ($adminModel->count() > 0) {
    echo 'An admin user already exists. Delete setup.php after initial setup.';
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::validate($_POST['_token'] ?? null)) {
        $errors[] = 'Invalid request token.';
    }

    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

    if ($username === '') {
        $errors[] = 'Username is required.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (!$errors) {
        $adminModel->create($username, $password);
        Session::flash('success', 'Admin account created. You can now log in.');
        header('Location: index.php?route=login');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initial Admin Setup</title>
    <link rel="stylesheet" href="assets/app.css">
</head>
<body>
    <div class="page-shell">
        <main class="auth-panel">
            <div class="section-heading">
                <h2>Initial Admin Setup</h2>
                <p>Create the first admin account, then remove or lock down <code>setup.php</code>.</p>
            </div>

            <?php foreach ($errors as $error): ?>
                <div class="alert alert-error"><?= e($error) ?></div>
            <?php endforeach; ?>

            <form method="POST" class="form-grid compact-form">
                <input type="hidden" name="_token" value="<?= e(Csrf::token()) ?>">

                <label>
                    <span>Username</span>
                    <input type="text" name="username" required>
                </label>

                <label>
                    <span>Password</span>
                    <input type="password" name="password" required>
                </label>

                <label>
                    <span>Confirm Password</span>
                    <input type="password" name="confirm_password" required>
                </label>

                <button type="submit" class="button button-primary">Create Admin</button>
            </form>
        </main>
    </div>
</body>
</html>
