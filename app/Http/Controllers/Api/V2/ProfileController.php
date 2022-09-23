<?php

namespace App\Http\Controllers\Api\V2;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => 'max:191',
        ]);
        if ($data) {
            $user->update($data);
        }
        return new UserResource($user);
    }

    public function passwordUpdate(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8',
        ]);
        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
        return response()->json([
            'message' => __('Password has been updated'),
        ]);
    }

    public function imageUpdate(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        if ($user->avatar) {
            Helper::deleteImage($user, 'avatar', User::$imgSizes);
        }
        Helper::storeImage($user, 'image', 'users', User::$imgSizes, 'avatar');

        return response()->json([
            'message' => __('Image has been updated'),
        ]);
    }

    public function phoneNumberUpdate(Request $request)
    {
        $user = auth()->user();
        $data = $this->validate($request, [
            'phone_number' => 'required|regex:/' . Helper::phoneNumberRegex() . '/|unique:users,phone_number,' . $user->id,
            'otp' => 'required',
        ]);

        $user = auth()->user();

        $checkOTP = Helper::checkOTPByPhoneNumber($data['phone_number'], $data['otp']);
        if (!$checkOTP['success']) {
            return response()->json([
                'message' => __('main.error'),
                'errors' => [
                    'otp' => [
                        $checkOTP['error'],
                    ],
                ],
            ], 422);
        }

        $user->update(['phone_number' => $data['phone_number']]);
        $user->phone_number_verified_at = now();
        $user->save();

        // delete user info
        Otp::where('phone_number', $data['phone_number'])->delete();
        $user->otps()->delete();

        return response()->json([
            'message' => __('Phone number has been saved'),
        ]);
    }

    public function destroy(Request $request)
    {
        $data = $this->validate($request, [
            'otp' => ['required'],
        ]);

        $user = auth()->user();

        $checkOTP = Helper::checkOTPByPhoneNumber($user->phone_number, $data['otp']);
        if (!$checkOTP['success']) {
            return response()->json([
                'message' => __('main.error'),
                'errors' => [
                    'otp' => [
                        $checkOTP['error'],
                    ],
                ],
            ], 422);
        }

        // delete user info
        Otp::where('phone_number', $user->phone_number)->delete();
        $user->otps()->delete();
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => __('Account has been deleted'),
        ]);
    }
}

