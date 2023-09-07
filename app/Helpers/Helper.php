<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Helper
{
    /**
     * Update refresh token for user
     */
    public static function updateRefreshToken(int $userId, string $refreshToken): void
    {
        DB::table('oauth_refresh_tokens')->updateOrInsert([
            'user_id' => $userId,
        ], [
            'refresh_token' => $refreshToken,
            'expires_at' => Carbon::now()->addDay(1),
        ]);
    }

    /**
     * Get user by refresh token
     *
     * @return object
     */
    public static function getUserByRefreshToken(string $refreshToken)
    {
        return DB::table('oauth_refresh_tokens')->where('refresh_token', $refreshToken)
            ->whereDate('expires_at', '>', Carbon::now())
            ->first();
    }

    public static function getCustomMessageErr()
    {
        return [
            'accepted' => 'E0001::attribute',
            'accepted_if' => 'E0002::attribute,:other,:value',
            'active_url' => 'E0003::attribute',
            'after' => 'E0004::attribute,:date',
            'after_or_equal' => 'E0005::attribute,:date',
            'alpha' => 'E0006::attribute',
            'alpha_dash' => 'E0007::attribute',
            'alpha_num' => 'E0008::attribute',
            'array' => 'E0009::attribute',
            'before' => 'E0010::attribute,:date',
            'before_or_equal' => 'E0011::attribute,:date',
            'boolean' => 'E0012::attribute',
            'confirmed' => 'E0013::attribute',
            'current_password' => 'E0014::attribute',
            'date' => 'E0015::attribute',
            'date_equals' => 'E0016::attribute,:date',
            'date_format' => 'E0017::attribute,:format',
            'declined' => 'E0018::attribute',
            'declined_if' => 'E0019::attribute,:other,:value',
            'different' => 'E0020::attribute,:other',
            'digits' => 'E0021::attribute,:digits',
            'email' => 'E0022::attribute',
            'ends_with' => 'E0023::attribute,:value',
            'enum' => 'E0024::attribute',
            'file' => 'E0025::attribute',
            'filled' => 'E0026::attribute',
            'image' => 'E0027::attribute',
            'in' => 'E0028::attribute',
            'in_array' => 'E0029::attribute,:other',
            'integer' => 'E0030::attribute',
            'json' => 'E0031::attribute',
            'mimes' => 'E0032::attribute,:values',
            'mimetypes' => 'E0033::attribute,:values',
            'min' => 'E0034::attribute,:min',
            'not_in' => 'E0035::attribute',
            'not_regex' => 'E0036::attribute',
            'numeric' => 'E0037::attribute',
            'password' => 'E0038::attribute',
            'regex' => 'E0039::attribute',
            'required' => 'E0040::attribute',
            'required_if' => 'E0041::attribute,:other,:value',
            'size' => 'E0042::attribute,:size',
            'starts_with' => 'E0043::attribute,:values',
            'string' => 'E0044::attribute',
            'unique' => 'E0045::attribute',
            'uploaded' => 'E0046::attribute',
            'url' => 'E0047::attribute',
            'uuid' => 'E0048::attribute',
            'max' => 'E0049::attribute,:max',
            'exists' => 'E0050::attribute',
        ];
    }

    public static function getListAvatar(array $tasks): array
    {
        $result = [];
        foreach ($tasks as $task) {
            if (isset($task['assign']) && ! empty($task['assign']['avatar'])) {
                $result[] = [
                    'id' => $task['assign']['id'],
                    'avatar' => $task['assign']['avatar'],
                ];
            }
        }

        return collect($result)->unique('id')->pluck('avatar')->toArray();
    }
}
