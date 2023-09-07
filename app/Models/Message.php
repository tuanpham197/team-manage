<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'room_id',
        'type',
        'send_at',
        'creator_id',
        'seen_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['time_send_at'];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getTimeSendAtAttribute()
    {
        $now = Carbon::now();
        $weekStartDate = Carbon::now()->startOfWeek();
        $weekEndDate = Carbon::now()->endOfWeek();

        $sendAt = Carbon::parse($this->send_at);

        if ($sendAt->isSameDay($now)) {
            return $sendAt->format('h:m A');
        }

        if ($sendAt->isSameWeek($weekStartDate) || $sendAt->isSameWeek($weekEndDate)) {
            return $sendAt->format('D, h:m A');
        }

        return $sendAt->format('d M Y, h:m A');
    }
}
