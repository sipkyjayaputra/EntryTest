<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    public function validatePasswordRequest(Request $request)
    {
        //You can add validation login here
        $user = DB::table('users')->where('email', '=', $request->email)->get();

        //Check if the user exists
        if (count($user) < 1) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        //Get the token just created above
        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

        $link = $this->sendResetEmail($request->email, $tokenData->token);

        return redirect($link);
        // if ($this->sendResetEmail($request->email, $tokenData->token)) {
        //     return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        // } else {
        //     return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        // }
    }

    public function resetPassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required' ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('auth.passwords.email');
        $user = User::where('email', $tokenData->email)->first();

        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);

        //Hash and update the new password
        $user->password = Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();

        //Send Email Reset Success Email
        //if ($this->sendSuccessEmail($tokenData->email)) {
            return redirect()->route('login');
        //} else {
        //    return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        //}

    }

    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = '/password/reset/' . $token . '?email=' . urlencode($user->email);

        try {
            return $link;
            //Here send the link with CURL with an external email API
            //return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
