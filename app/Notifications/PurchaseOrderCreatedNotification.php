<?php

namespace App\Notifications;

use App\Models\Workpermit\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PurchaseOrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $po;
    protected $permissionName;

    public function __construct(PurchaseOrder $po, $permissionName)
    {
        $this->po = $po;
        $this->permissionName = $permissionName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $route = route($this->permissionName, [], false);
        return [
            'title' => 'PO Baru Diterbitkan',
            'message' => 'PO No. ' . $this->po->no_po . ' telah diterbitkan.',
            'url' => $route,
        ];
    }
}
