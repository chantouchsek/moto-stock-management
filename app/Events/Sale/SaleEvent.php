<?php

namespace App\Events\Sale;

use App\Events\BaseEvent as Event;
use App\Models\Sale;
use App\Transformers\SaleTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;

abstract class SaleEvent extends Event
{

    /**
     * @var Model The model that has been updated.
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param Sale $sale The album that has been updated.
     */
    public function __construct(Sale $sale)
    {
        $this->model = $sale;
        $this->transformer = new SaleTransformer();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['sale'];
    }
}
