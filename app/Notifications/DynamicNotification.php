<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class DynamicNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;
    protected $type;

    public function __construct($type, $data = [])
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $config = config('notifications.' . $this->type);

        $message = strtr($config['message'], $this->data);
        $url = route($config['route']);

        return [
            'title' => $config['title'],
            'message' => $message,
            'url' => $url,
        ];
    }
}
