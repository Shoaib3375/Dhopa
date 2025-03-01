<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function userRegistration(Request $request) {
        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName'  => $request->input('lastName'),
                'email'     => $request->input('email'),
                'mobile'    => $request->input('mobile'),
                'password'  => Hash::make($request->input('password')),
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'User Registration Successfully',
            ], 200);
        } catch (Exception $e) {
            // return report($e);
            return response()->json([
                'status'  => 'Failed',
                'message' => $e->getMessage(),
            ], 200);
        }

    }

    function userLogin(Request $request) {
        $count = User::where('email', $request->input('email'))->first();

        if ($count !== null && Hash::check($request->input('password'), $count->password)) {
            // User login -> JWT Token issue
            $token = JWTToken::createToken($request->input('email'), $count->id);
            return response()->json([
                'status'  => 'success',
                'message' => 'User Login Successful',
                 'token'   => $token,
            ], 200)->cookie('token', $token, 60 * 24 * 30, ',');
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'unauthorized',
            ], 401);
        }
    }

    function sentOTPCode(Request $request) {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            // OTP email addr
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Otp send your mail',
            ], 200);
            // otp code table insert
        } else {
            return response()->json([
                'status'  => 'failed',
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    function verifyOtp(Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

        if ($count == 1) {
            // Database otp update
            User::where('email', '=', $email)->update(['otp' => '0']);
            // password reset token issue
            $token = JWTToken::createTokenForSetPassword($request->input('email'));
            return response()->json([
                'status'  => 'success',
                'message' => 'OTP verify successful',
                'token'   => $token,
            ], 200);
        } else {
            return response()->json([
                'status'  => 'Failed',
                'message' => 'unauthorized',
            ], 200);
        }
    }

    function resetPassword(Request $request) {
        try {
            $email = $request->header('email');
            $password = Hash::make($request->input('password'));
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Request Successful',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'Fail',
                'message' => 'Something went wrong ',
            ], 401);
        }
    }
    function userLogout(Request $request) {
        return redirect('/userLogin')->cookie('token', '', -1);
    }
    function userProfile(Request $request) {
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();
        return response()->json([
            'status'  => 'success',
            'message' => 'Request Successful',
            'data'    => $user,
        ], 200);
    }
    function updateProfile(Request $request) {
        try {
            $email = $request->header('email');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $mobile = $request->input('mobile');
            $password = $request->input('password');
            User::where('email', '=', $email)->update([
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'mobile'    => $mobile,
                'password'  => $password,
            ]);
            return response()->json([
                'status'  => 'success',
                'message' => 'Update Successful',
            ], 200);
        } catch (Exception $e) {
            return response([
                'status'  => 'failed',
                'message' => 'Something Went Wrong',
            ], 417);
        }
    }
}
