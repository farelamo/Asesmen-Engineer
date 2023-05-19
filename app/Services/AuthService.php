<?php
namespace App\Services;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Exception;
use JWTAuth;

class AuthService
{

    public function returnCondition($condition, $errorCode, $message)
    {
        return response()->json([
            'success' => $condition,
            'message' => $message,
        ], $errorCode);
    }

    public function handleToken($request, $isLogin = true)
    {
        try {

            if (!$token = auth()->attempt([
                'username' => $request->username,
                'password' => $request->password,
            ])) {

                if ($isLogin)
                    return $this->returnCondition(false, 401, 'incorrect password');

                return $this->returnCondition(false, 500, 'Internal Server Error');
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ],
            ], 200);
        } catch (Exception $e) {
            return $this->returnCondition(false, 500, 'Internal Server Error');
        }
    }

    public function login(AuthRequest $request)
    {
        try {

            $check = User::where('username', $request->username)->first();
            if (!$check)
                return $this->register($request);

            return $this->handleToken($request);

        } catch (Exception $e) {
            return $this->returnCondition(false, 500, 'Internal Server Error');
        }
    }

    public function register(AuthRequest $request)
    {
        try {

            $check = User::where('username', $request->username)->first();
            if ($check)
                return $this->returnCondition(false, 409, 'User already exist');

            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);

            return $this->handleToken($request, false);

        } catch (Exception $e) {
            return $this->returnCondition(false, 500, 'Internal Server Error');
        }

    }

    public function logout()
    {
        try {
            auth()->logout();

            JWTAuth::getToken();
            JWTAuth::invalidate(true);

            return $this->returnCondition(true, 200, 'Successfully logged out');
        } catch (Exception $e) {
            return $this->returnCondition(false, 500, 'Internal Server Error');
        }
    }
}
