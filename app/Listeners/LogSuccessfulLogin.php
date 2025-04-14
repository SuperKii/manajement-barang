<?php

namespace App\Listeners;

use App\Models\LogActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Carbon;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        LogActivity::create([
            'user_id' => $event->user->id_user,
            'aksi' => 'Login',
            'deskripsi' => 'Autentikasi',
            'created_at' => Carbon::now()->format('d-m-Y H:i')
        ]);
    }
}
