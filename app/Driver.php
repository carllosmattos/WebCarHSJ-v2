<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{

    protected $fillable = ['name_driver'];


    public function getDriver($field)
    {
        if (!is_null($field['name_driver'])) {
            $driver = Driver::where('name_driver', 'LIKE', '%' . $field['name_driver'] . '%')
                ->get();
        }
        return $driver;
    }
    public function getDrivers()
    {
        $drivers = Driver::all();
        return $drivers;
    }

    public function addDriver($field)
    {
        $driver = new Driver();
        $driver->name_driver = $field['name_driver'];
        $driver->cpf = $field['cpf'];
        $driver->hab = implode(",", $field['hab']);

        $driver->save();
    }

    // Um motorista Pode ter um veículo
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }
}
