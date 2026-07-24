<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\Validator;
use App\Models\User;

class UserController
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function index(Request $request): void
    {
        $users = User::all();
        $this->response->render('users.index', ['users' => $users]);
    }

    public function create(Request $request): void
    {
        $this->response->render('users.create');
    }

    public function store(Request $request): void
    {
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF validation failed.');
            $this->response->redirect('/users/create');
        }

        $data = [
            'name' => trim($request->input('name', '')),
            'email' => trim($request->input('email', '')),
            'password' => $request->input('password', ''),
            'role' => $request->input('role', 'MEMBER')
        ];

        $validator = new Validator($data);
        if (!$validator->validate([
            'name' => 'required|min:2|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:ADMIN,MEMBER'
        ])) {
            Session::setOldInput($data);
            flash('errors', $validator->errors());
            $this->response->redirect('/users/create');
        }

        User::create($data);
        flash('success', 'User account created successfully!');
        $this->response->redirect('/users');
    }

    public function edit(Request $request, string $id): void
    {
        $user = User::find((int) $id);
        if (!$user) {
            flash('error', 'User not found.');
            $this->response->redirect('/users');
        }

        $this->response->render('users.edit', ['user' => $user]);
    }

    public function update(Request $request, string $id): void
    {
        $userId = (int) $id;
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF validation failed.');
            $this->response->redirect("/users/{$userId}/edit");
        }

        $data = [
            'name' => trim($request->input('name', '')),
            'email' => trim($request->input('email', '')),
            'password' => $request->input('password', ''),
            'role' => $request->input('role', 'MEMBER')
        ];

        $validator = new Validator($data);
        if (!$validator->validate([
            'name' => 'required|min:2|max:191',
            'email' => "required|email|unique:users,email,{$userId}",
            'password' => 'min:6',
            'role' => 'required|in:ADMIN,MEMBER'
        ])) {
            Session::setOldInput($data);
            flash('errors', $validator->errors());
            $this->response->redirect("/users/{$userId}/edit");
        }

        User::update($userId, $data);
        flash('success', 'User account updated!');
        $this->response->redirect('/users');
    }

    public function destroy(Request $request, string $id): void
    {
        $userId = (int) $id;
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF validation failed.');
            $this->response->redirect('/users');
        }

        if ($userId === \App\Core\Auth::id()) {
            flash('error', 'You cannot delete your own active admin account.');
            $this->response->redirect('/users');
        }

        User::delete($userId);
        flash('success', 'User account deleted.');
        $this->response->redirect('/users');
    }
}
