<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verifyEmail(User $user){
        $user->update([
            'email_verified_at' => Carbon::now()
        ]);
        return redirect()->route('login');
    }
}
