<?php

namespace App\Events\Expense;

use App\Events\BaseEvent as Event;
use App\Models\Expense;
use App\Transformers\ExpenseTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;

abstract class ExpenseEvent extends Event
{
    /**
     * @var Model The model that has been updated.
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param Expense $expense The expense that has been updated.
     */
    public function __construct(Expense $expense)
    {
        $this->model = $expense;
        $this->transformer = new ExpenseTransformer();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['expense'];
    }
}
