<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Personnel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'personnel_id' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $personnel = Personnel::where('id', $input['personnel_id'])->first();

        if ($personnel) {
            $is_admin = $personnel->is_admin;
        }


        return User::create([
            'personnel_id' => $input['personnel_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'is_admin' => $is_admin,
        ]);
    }
}
