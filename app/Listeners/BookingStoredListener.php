<?php

namespace App\Listeners;

use App\Events\BookingStored;
use App\Models\Vacancy;
use App\Notifications\BookingStoredNotification;
use Illuminate\Support\Facades\Notification;

class BookingStoredListener
{
    public function handle(BookingStored $event): void
    {
        Vacancy::whereBetween('when', [$event->booking->starts_at, $event->booking->ends_at])->decrement('amount', 1);

        Notification::send($event->booking->user, new BookingStoredNotification($event->booking));
    }
}
