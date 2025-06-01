<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification;

class KitchenOrderCreationNovaNotification extends NovaNotification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiable
     * @return string
     */
    public function via($notifiable): string
    {
        return NovaChannel::class;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toNova(): NovaNotification
    {
        return (new NovaNotification)
            ->message('Kitchen Order creation finished successfully.')
            ->icon('check-circle')
            ->type('info');
    }
}
