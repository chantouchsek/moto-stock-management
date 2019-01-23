<?php

namespace App\Events\Category;

use App\Events\BaseEvent as Event;
use App\Models\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;

abstract class CategoryEvent extends Event
{

    /**
     * @var Model The model that has been updated.
     */
    public $model;

    /**
     * Create a new event instance.
     *
     * @param Category $category The album that has been updated.
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
        $this->transformer = new CategoryTransformer();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['category'];
    }
}
