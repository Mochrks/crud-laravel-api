<?php

namespace App\Utils;

use Illuminate\Support\Facades\Validator;

class ValidationUtils
{
    public static function validateSignUpData($data)
    {
        return Validator::make($data, [
            'Username' => 'required|string|min:1|max:255',
            'Fullname' => 'required|string|min:1|max:55',
            'Password' => ['required', 'string', 'min:6', 'max:50', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/'],
        ], [
            'Username.required' => 'Kolom Username tidak boleh kosong',
            'Username.min' => 'Username minimal 1 karakter',
            'Username.max' => 'Username maksimum 255 karakter',
            'Fullname.required' => 'Kolom Fullname tidak boleh kosong',
            'Fullname.min' => 'Fullname minimal 1 karakter',
            'Fullname.max' => 'Fullname maksimum 55 karakter',
            'Password.required' => 'Kolom Password tidak boleh kosong',
            'Password.min' => 'Password minimal 6 karakter',
            'Password.max' => 'Password maksimum 50 karakter',
            'Password.regex' => 'Password harus mengandung minimal satu huruf dan satu angka',
        ])->validate();
    }


    public static function validateSignInData($data)
    {
        return Validator::make($data, [
            'Username' => 'required|string|min:1|max:255',
            'Password' => ['required', 'string', 'min:6', 'max:50', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/'],
        ], [
            'Username.required' => 'Kolom Username tidak boleh kosong',
            'Username.min' => 'Username minimal 1 karakter',
            'Username.max' => 'Username maksimum 255 karakter',
            'Password.required' => 'Kolom Password tidak boleh kosong',
            'Password.min' => 'Password minimal 6 karakter',
            'Password.max' => 'Password maksimum 50 karakter',
            'Password.regex' => 'Password harus mengandung minimal satu huruf dan satu angka',
        ])->validate();
    }
}
