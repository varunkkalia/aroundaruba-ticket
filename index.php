<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\TicketController;
use App\Core\Auth;

$route = $_GET['route'] ?? 'dashboard';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$authController = new AuthController();
$ticketController = new TicketController();

switch ($route) {
    case 'login':
        if ($method === 'POST') {
            $authController->login();
            break;
        }

        $authController->showLogin();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'dashboard':
        Auth::ensureAuthenticated();
        $ticketController->dashboard();
        break;

    case 'tickets':
        Auth::ensureAuthenticated();
        $ticketController->index();
        break;

    case 'tickets/store':
        Auth::ensureAuthenticated();
        $ticketController->store();
        break;

    case 'tickets/edit':
        Auth::ensureAuthenticated();
        $ticketController->edit();
        break;

    case 'tickets/update':
        Auth::ensureAuthenticated();
        $ticketController->update();
        break;

    case 'tickets/delete':
        Auth::ensureAuthenticated();
        $ticketController->delete();
        break;

    case 'tickets/download':
        Auth::ensureAuthenticated();
        $ticketController->download();
        break;

    case 'tickets/email':
        Auth::ensureAuthenticated();
        $ticketController->email();
        break;

    default:
        if (Auth::check()) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        header('Location: index.php?route=login');
        exit;
}
