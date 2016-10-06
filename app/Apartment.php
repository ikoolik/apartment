<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['queue', 'building', 'floor', 'door', 'state', 'price'];

    public function getUrlAttribute()
    {
        return "https://sevdol.ru/planirovki-i-ceny/{$this->queue}-ochered-{$this->building}-korpus/{$this->floor}-floor/1-section/{$this->door}/";
    }

    public function updateFromArray(array $model)
    {
        $this->state = $model['state'];
        if(isset ($model['price'])) {
            $this->price = intval(str_replace(['руб.', ' '], ['',''], $model['price']));
        }
        $dirty = $this->getDirty();
        $this->save();

        return $dirty;
    }
}
