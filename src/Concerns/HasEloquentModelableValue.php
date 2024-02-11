<?php

namespace Envor\Platform\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasEloquentModelableValue
{
    /**
     * Create a model with the given attributes.
     */
    public function createModel(array $attributes): Model
    {
        $model = $this->value;

        return $model::create($attributes);
    }

    /**
     * Get a new instance of the model.
     */
    public function newModel(): Model
    {
        $model = $this->value;

        return new $model;
    }
}
