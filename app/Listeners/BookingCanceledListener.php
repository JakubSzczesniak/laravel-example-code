<?php

namespace App\Listeners;

use App\Events\BookingCanceled;
use App\Models\Vacancy;
use App\Notifications\BookingCanceledNotification;
use Illuminate\Support\Facades\Notification;

class BookingCanceledListener
{
    public function handle(BookingCanceled $event): void
    {
        Vacancy::whereBetween('when', [$event->booking->starts_at, $event->booking->ends_at])->increment('amount', 1);

        Notification::send($event->booking->user, new BookingCanceledNotification($event->booking));
    }
}
