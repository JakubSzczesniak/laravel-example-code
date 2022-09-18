<?php

namespace App\StateMachines;

use App\Enums\Booking\Status;
use JakubSzczesniak\EloquentStateMachineWorkflowPro\StateMachines\StateMachine;

class StatusStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    public function transitions(): array
    {
        return [
            Status::CREATED->value => [Status::CONFIRMED->value, Status::CANCELED->value],
            Status::CONFIRMED->value => [Status::CANCELED->value],
            Status::CANCELED->value => [],
        ];
    }

    public function defaultState(): ?string
    {
        return Status::CREATED->value;
    }
}
