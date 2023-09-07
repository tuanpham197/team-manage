<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Messages\MessageInterface;
use App\Repositories\Messages\MessageRepository;
use App\Repositories\RoomMembers\RoomMemberInterface;
use App\Repositories\RoomMembers\RoomMemberRepository;
use App\Repositories\Rooms\RoomInterface;
use App\Repositories\Rooms\RoomRepository;
use App\Repositories\Tags\TagInterface;
use App\Repositories\Tags\TagRepository;
use App\Repositories\Tasks\TaskInterface;
use App\Repositories\Tasks\TaskRepository;
use App\Repositories\TaskStatuses\TaskStatusInterface;
use App\Repositories\TaskStatuses\TaskStatusRepository;
use App\Repositories\Users\UserInterface;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(TaskInterface::class, TaskRepository::class);
        $this->app->singleton(TaskStatusInterface::class, TaskStatusRepository::class);
        $this->app->singleton(TagInterface::class, TagRepository::class);
        $this->app->singleton(RoomInterface::class, RoomRepository::class);
        $this->app->singleton(MessageInterface::class, MessageRepository::class);
        $this->app->singleton(RoomMemberInterface::class, RoomMemberRepository::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
