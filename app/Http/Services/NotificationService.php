<?php
namespace App\Http\Services;

use App\Notifications\DynamicNotification;
use Spatie\Permission\Models\Permission;

class NotificationService
{
    public static function notifyUsersByPermission(string $notificationType, array $data, string $permissionName)
    {
        $permission = Permission::where('name', $permissionName)->first();
        if (!$permission) return;

        $users = $permission->users()->get();

        foreach ($users as $user) {
            $user->notify(new DynamicNotification($notificationType, $data));
        }
    }
}
