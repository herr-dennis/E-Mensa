<?php

class Gerichte extends Illuminate\Database\Eloquent\Model{
    protected $table='gericht';
    protected $primaryKey='id';

    // Accessor für preis_intern
    public function getPreisInternAttribute($value)
    {
        return number_format($value, 2);
    }

    // Accessor für preis_extern
    public function getPreisExternAttribute($value)
    {
        return number_format($value, 2);
    }

    // Mutator für preis_intern
    public function setPreisInternAttribute($value)
    {
        $this->attributes['preisintern'] = number_format($value, 2);
    }

    // Mutator für preis_extern
    public function setPreisExternAttribute($value)
    {
        $this->attributes['preisextern'] = number_format($value, 2);
    }
    protected $casts = [
        'vegetarisch' => 'boolean',
        'vegan' => 'boolean',
    ];

    public function getVegetarischAttribute($value)
    {
        return strtolower(trim($value)) === 'yes' || strtolower(trim($value)) === 'ja';
    }

    public function setVegetarischAttribute($value)
    {
        $this->attributes['vegetarisch'] = strtolower(trim($value)) === 'yes' || strtolower(trim($value)) === 'ja';
    }

    public function getVeganAttribute($value)
    {
        return strtolower(trim($value)) === 'yes' || strtolower(trim($value)) === 'ja';
    }

    public function setVeganAttribute($value)
    {
        $this->attributes['vegan'] = strtolower(trim($value)) === 'yes' || strtolower(trim($value)) === 'ja';
    }

}
