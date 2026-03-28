<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Core\Validator;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }

        $this->view('auth/login', [
            'title' => 'Admin Login',
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
        ]);
    }

    public function login(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? null)) {
            Session::flash('error', 'Invalid request token. Please try again.');
            $this->redirect('login');
        }

        $input = [
            'username' => trim((string) ($_POST['username'] ?? '')),
            'password' => (string) ($_POST['password'] ?? ''),
        ];

        $errors = Validator::login($input);

        if ($errors) {
            Session::flash('errors', $errors);
            Session::flash('old', ['username' => $input['username']]);
            $this->redirect('login');
        }

        if (!Auth::attempt($input['username'], $input['password'])) {
            Session::flash('error', 'Invalid username or password.');
            Session::flash('old', ['username' => $input['username']]);
            $this->redirect('login');
        }

        Session::flash('success', 'Welcome back.');
        $this->redirect('dashboard');
    }

    public function logout(): void
    {
        Auth::logout();
        Session::flash('success', 'You have been logged out.');
        $this->redirect('login');
    }
}

