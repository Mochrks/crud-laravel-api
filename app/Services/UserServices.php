<?php

namespace App\Services;

use App\Models\User;
use App\Utils\ValidationUtils;
use App\Utils\ResponseUtils;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class UserServices
{
    public function signUp($data)
    {
        try {
            $validatedData = ValidationUtils::validateSignUpData($data);

            $username = $validatedData['Username'];
            $fullname = $validatedData['Fullname'];
            $password = $validatedData['Password'];

            $existingUser = User::where('username', $username)->first();
            if ($existingUser) {
                Log::warning("WARNING Username telah digunakan oleh user yang telah mendaftar sebelumnya ");
                return ResponseUtils::errorResponse('Username telah digunakan oleh user yang telah mendaftar sebelumnya', 422);
            }
            $user = new User();
            $user->username = $username;
            $user->fullname = $fullname;
            $user->password = Hash::make($password);
            $user->is_deleted = false;
            $user->created_by = $username;
            $user->created_time = now();
            $user->modified_time = now();
            $user->save();


            Log::info('INFO Berhasil menambahkan user : {username} !!', ['username' => $username]);
            return ResponseUtils::successResponse('Berhasil menambahkan ' . $username, 200);
        } catch (ValidationException $e) {

            Log::warning("WARNING " . $e->validator->errors()->first());
            return ResponseUtils::errorResponse($e->validator->errors()->first(), 422, $e->getMessage());
        } catch (QueryException $e) {

            Log::error("ERROR Terjadi kesalahan pada server");
            return ResponseUtils::errorResponse('Terjadi kesalahan pada server, silahkan coba lagi!', 500, $e->getMessage());
        }
    }


    public function signIn($data)
    {
        try {
            $validatedData = ValidationUtils::validateSignInData($data);

            $username = $validatedData['Username'];
            $password = $validatedData['Password'];

            $user = User::where('username', $username)->first();
            if (!$user || !Hash::check($password, $user->password)) {
                Log::warning("WARNING Username atau password salah");
                return ResponseUtils::errorResponse('Username atau password salah', 401);
            }

            $token = $this->generateToken($username, $password);

            Log::info('INFO user : {username} , Berhasil login', ['username' => $user->username]);
            return ResponseUtils::successResponseData([
                'id' => $user->user_id,
                'token' => $token,
                'type' => 'Bearer',
                'username' => $user->username,
                'role' => 'users'
            ], 'User ' . $user->username . ' Berhasil login !!', 200);
        } catch (ValidationException $e) {

            Log::warning("WARNING " . $e->validator->errors()->first());
            return ResponseUtils::errorResponse($e->validator->errors()->first(), 422, $e->getMessage());
        } catch (QueryException $e) {

            Log::error("ERROR Terjadi kesalahan pada server");
            return ResponseUtils::errorResponse('Terjadi kesalahan pada server, silahkan coba lagi!', 500, $e->getMessage());
        }
    }

    private function generateToken($username, $password)
    {
        return JWTAuth::attempt(['username' => $username, 'password' => $password]);
    }
}
