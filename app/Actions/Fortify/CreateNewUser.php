<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Carbon\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        Invitation::where('token', $input['token_hidden'])
                        ->where('invitation_code', $input['invitationcode_hidden'])
                        ->update(['use' => 1]);

        return User::create([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'name' => $input['firstname'] . ' ' . $input['lastname'],
            'email' => $input['email'],
            'role_id' => 7,
            'email_verified_at' => Carbon::now()->toDate(),
            'password' => Hash::make($input['password']),
        ]);
    }
}
