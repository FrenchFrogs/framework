<?php namespace FrenchFrogs\Laravel\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Desactivate gard
     *
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * primary key generation
     *
     * @var bool
     */
    public $uuid = false;


    /**
     * Insert the given attributes and set the ID on the model.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $attributes
     * @return void
     */
    protected function insertAndSetId(Builder $query, $attributes)
    {
        $keyName = $this->getKeyName();

        // uuid management
        if ($this->uuid) {
            $id = uuid();
            $attributes[$keyName] = $id;
            $query->insert($attributes);

        // auto increment
        } else {
            $id = $query->insertGetId($attributes,$keyName);
        }

        $this->setAttribute($keyName, $id);
    }


    /**
     * Get the casts array.
     *
     * @return array
     */
    protected function getCasts()
    {
        if ($this->incrementing && !$this->uuid){
            return array_merge([
                $this->getKeyName() => 'int',
            ], $this->casts);
        }

        return $this->casts;
    }
}