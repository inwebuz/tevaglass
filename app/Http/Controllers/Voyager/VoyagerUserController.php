<?php

namespace App\Http\Controllers\Voyager;

use App\Models\User;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerUserController as BaseVoyagerUserController;

class VoyagerUserController extends BaseVoyagerUserController
{
    public function apiTokens(Request $request, User $user)
    {
        $this->checkPermissions();
        $tokens = $user->tokens;
        return Voyager::view('voyager::users.api_tokens.index', compact('user', 'tokens'));
    }

    public function apiTokensStore(Request $request, User $user)
    {
        $this->checkPermissions();
        $user->tokens()->delete();
        $token = $user->createToken('site');
        return redirect()->route('voyager.users.api_tokens', ['user' => $user->id])->with([
            'message'    => 'Токен создан',
            'alert-type' => 'success',
            'token' => $token->plainTextToken,
        ]);
    }

    private function checkPermissions()
    {
        if (!auth()->user()->hasPermission('browse_users')) {
            abort(403);
        }
    }
}
