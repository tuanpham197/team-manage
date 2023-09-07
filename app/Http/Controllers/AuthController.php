<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\HttpCodeEnum;
use App\Helpers\Helper;
use App\Helpers\ResponseApi;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ResponseApi::responseFail([
                    'code' => 'E0055',
                    'params' => [],
                ], HttpCodeEnum::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return ResponseApi::responseFail([
                'code' => 'E0055',
                'params' => [],
                'params' => [],
            ], HttpCodeEnum::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user = auth()->user();

        //save token
        $refreshToken = $user->createToken('refresh_token')->plainTextToken;
        DB::table('oauth_refresh_tokens')->updateOrInsert([
            'user_id' => $user->id,
        ], [
            'refresh_token' => $refreshToken,
            'expires_at' => Carbon::now()->addDay(1),
        ]);

        return ResponseApi::responseSuccess([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => Carbon::now()->addMinute(auth()->factory()->getTTL()),
            'user_info' => $user,
        ]);
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = $request->only('refresh_token');

        if (empty($refreshToken)) {
            return ResponseApi::responseFail([], HttpCodeEnum::HTTP_UNAUTHORIZED, '401 Unauthorized');
        }

        // verify refresh token
        $userRefreshToken = Helper::getUserByRefreshToken($refreshToken['refresh_token']);


        if (!$userRefreshToken) {
            return ResponseApi::responseFail([], HttpCodeEnum::HTTP_UNAUTHORIZED, '401 Unauthorized');
        }

        // find user and create new token
        $user = User::find($userRefreshToken->user_id);
        $token = JWTAuth::fromUser($user);
        $newRefreshToken = $user->createToken('refresh_token')->plainTextToken;

        // update refresh token
        Helper::updateRefreshToken($user->id, $newRefreshToken);

        return ResponseApi::responseSuccess([
            'access_token' => $token,
            'refresh_token' => $newRefreshToken,
            'expires_in' => Carbon::now()->addMinute(auth()->factory()->getTTL()),
        ], HttpCodeEnum::HTTP_OK);
    }

    public function getInfo()
    {
        return ResponseApi::responseSuccess([
            'user_info' => auth()->user(),
        ]);
    }
}
