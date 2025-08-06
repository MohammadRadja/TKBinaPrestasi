<?php

namespace App\Services;

use App\Notifications\GeneralNotification;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Session;

class NotificationService
{
    private function send($user, string $title, string $message, string $type): void
    {
        $user->notify(new GeneralNotification($title, $message, $type));
    }

    public function toUser(Pengguna $user, string $title, string $message, string $type = 'success'): void
    {
        $this->send($user, $title, $message, $type);
    }

    public function toRole(string $role, string $title, string $message, string $type = 'success'): void
    {
        Pengguna::where('role', $role)->get()->each(fn($user) => $this->send($user, $title, $message, $type));
    }

    public function toRoles(array $roleMessages, string $type = 'success'): void
    {
        foreach ($roleMessages as $role => $data) {
            Pengguna::where('role', $role)->get()->each(fn($user) => $this->send($user, $data['title'], $data['message'], $type));
        }
    }
}
