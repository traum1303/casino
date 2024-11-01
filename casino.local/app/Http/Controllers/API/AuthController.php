<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $request->validated();

        $hash = hash('sha256', uniqid($request->phone_number.$request->user_name));
        $user = User::query()->firstOrCreate(['phone' => $request->phone_number],
            [
                'phone' => $request->phone_number,
                'name' => $request->user_name,
                'hash' => $hash,
                'expired_at' => Carbon::now()->addWeek()
            ]);

        if(is_null($user->hash)) {
            $user->hash = $hash;
        }

        if ($user->isExpired()) {
            $user->expired_at = Carbon::now()->addWeek();
        }

        $user->save();

        return response()->json(['hash' => $user->hash]);
    }

    public function resetHash(string $hash)
    {
        /** @var User $user */
        $user = Auth::user();
        $newHash = $user->generateNewHash();
        $user->hash = $newHash;
        $user->expired_at = Carbon::now()->addWeek();
        $user->save();
        return response()->json(['msg' => 'Link was refreshed' ,'hash' => $newHash]);
    }

    public function removeHash(string $hash)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->hash = null;
        $user->save();
        return response()->json(['msg' => 'Link was deactivated']);
    }
}
