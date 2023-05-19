<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(AuthRequest $request)
    {
        return $this->service->login($request);
    }

    public function register(AuthRequest $request)
    {
        return $this->service->register($request);
    }

    public function logout()
    {
        return $this->service->logout();
    }
}
