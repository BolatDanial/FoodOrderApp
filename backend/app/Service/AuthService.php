<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function register(array $data): User
    {
        $user = new User;
        $user->name =  $data['name'];
        $user->email =  $data['email'];
        $user->password =   Hash::make($data['password']);

        return $user;
    }
}
