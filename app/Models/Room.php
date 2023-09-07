<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    use HasEvents;

    protected $fillable = [
        'custom_name',
        'last_message',
        'last_message_at',
        'last_message_type',
        'custom_avatar',
        'type',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['messages', 'members'];

    public function members(): HasMany
    {
        return $this->hasMany(RoomMember::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('send_at', 'asc');
    }

    /**
     * Message of room
     */
    public function getMessagesAttribute(): array
    {
        return $this->attributes['messages'] = [];
    }

    /**
     * Member of room
     */
    public function getMembersAttribute(): array
    {
        return $this->attributes['members'] = [];
    }
}
