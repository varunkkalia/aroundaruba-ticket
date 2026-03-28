<?php

use App\Core\Csrf;

$old = $old ?? [];
$errors = $errors ?? [];
?>
<section class="auth-panel">
    <div class="section-heading">
        <h2>Admin Login</h2>
        <p>Only authorized administrators can access ticket operations.</p>
    </div>

    <form method="POST" action="index.php?route=login" class="form-grid compact-form">
        <input type="hidden" name="_token" value="<?= e(Csrf::token()) ?>">

        <label>
            <span>Username</span>
            <input type="text" name="username" value="<?= e($old['username'] ?? '') ?>" required>
            <?php if (isset($errors['username'])): ?>
                <small class="field-error"><?= e($errors['username']) ?></small>
            <?php endif; ?>
        </label>

        <label>
            <span>Password</span>
            <input type="password" name="password" required>
            <?php if (isset($errors['password'])): ?>
                <small class="field-error"><?= e($errors['password']) ?></small>
            <?php endif; ?>
        </label>

        <button type="submit" class="button button-primary">Sign In</button>
    </form>
</section>
