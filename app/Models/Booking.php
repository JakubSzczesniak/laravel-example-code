<?php

namespace App\Models;

use App\Enums\Booking\Status;
use App\StateMachines\StatusStateMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JakubSzczesniak\EloquentStateMachineWorkflowPro\Traits\HasStateMachines;

class Booking extends Model
{
    Use HasStateMachines;
    use HasFactory;

    protected $table = 'bookings';
    public $timestamps = true;

    protected $fillable = [
        'starts_at',
        'ends_at',
        'status',
        'user_id'//todo
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'status' => Status::class,
    ];

    public $stateMachines = [
        'status' => StatusStateMachine::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
