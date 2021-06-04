<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
  protected $table = "expenses";
  protected $fillable = ['description'];
  public function getExpense($field)
  {
    if (!is_null($field['description'])) {
      $expense = Expense::where('description', 'LIKE', '%' . $field['description'] . '%')
        ->orderBy('id', 'DESC')->get();
    } elseif (!is_null($field['data'])) {
      $expense = Expense::where('data', 'LIKE', '%' . $field['data'] . '%')
        ->orderBy('id', 'DESC')->get();
    }

    return $expense;
  }

  public function getExpenses()
  {
    $expenses = Expense::all();
    return $expenses;
  }

  public function addExpense($field)
  {
    $expense = new Expense();
    $expense->vehicle_id = $field['vehicle_id'];
    $expense->category_id = $field['category_id'];

    $expense->total_value_supply = floatval($field['total_value_supply']);

    if ($field['category_id'] == 1) {
      $expense->supply_in_liters = floatval($field['supply_in_liters']);
      $expense->previous_mileage = $field['previous_mileage'];
      $expense->current_mileage = $field['current_mileage'];

      // Calculos 
      $quantity_km_whels = (intval($field['current_mileage']) - intval($field['previous_mileage']));
      $cost_per_liter = (floatval($field['total_value_supply']) / floatval($field['supply_in_liters']));
      $kilometers_per_liter = $quantity_km_whels / floatval($field['supply_in_liters']);
      $expense->quantity_km_whells = $quantity_km_whels;
      $expense->cost_per_liter = $cost_per_liter;
      $expense->kilometers_per_liter = $kilometers_per_liter;
    } else {
      $expense->supply_in_liters = null;
      $expense->previous_mileage = null;
      $expense->current_mileage = null;
      $quantity_km_whels = null;
      $cost_per_liter = null;
      $kilometers_per_liter = null;
    }

    $expense->date = $field['date'];
    $expense->time = $field['time'];
    $expense->description = $field['description'];

    $expense->save();
  }

  // Custo pertence a veículo
  public function vehicle()
  {
    return $this->belongsTo(Vehicle::class);
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }
}
