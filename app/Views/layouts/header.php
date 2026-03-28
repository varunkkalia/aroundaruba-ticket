<?php

use App\Core\Auth;
use App\Core\Session;

$title = $title ?? 'Around Aruba Ticket Manager';
$successMessage = Session::getFlash('success');
$errorMessage = Session::getFlash('error');
$currentUser = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="assets/app.css">
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <div>
                <h1>Around Aruba Tickets</h1>
                <p>Secure admin ticket generator for UTV tours.</p>
            </div>
            <?php if ($currentUser): ?>
                <div class="topbar-actions">
                    <span class="badge">Signed in as <?= e($currentUser['username']) ?></span>
                    <nav class="nav-links">
                        <a href="index.php?route=dashboard">Create Ticket</a>
                        <a href="index.php?route=tickets">Manage Tickets</a>
                        <a href="index.php?route=logout">Logout</a>
                    </nav>
                </div>
            <?php endif; ?>
        </header>

        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= e($successMessage) ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-error"><?= e($errorMessage) ?></div>
        <?php endif; ?>

        <main class="content-card">
