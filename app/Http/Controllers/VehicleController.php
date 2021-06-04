<?php

namespace App\Http\Controllers;

use DB;
use \App\Vehicle;
use Illuminate\Http\Request;

use App\Http\Requests\VehicleRequest;

class VehicleController extends Controller
{
  private $vehicle;

  public function __construct(Vehicle $vehicle)
  {
    $this->vehicle = $vehicle;
    $this->vehicles = $vehicle;
    $this->middleware('auth');
  }


  //-------------------- Adicionar veiculos --------------------//
  public function get_add_vehicle(Request $field)
  {
    $drivers = \App\Driver::all(['id', 'name_driver']);
    return view('vehicle/add_vehicle', compact('drivers'));
  }

  public function post_add_vehicle(VehicleRequest $info)
  {
    
    $vehicle = $this->vehicle->addVehicle($info);
    return redirect()->route('vehicles')->with('message', 'Veiculo adicionado com sucesso!');;
  }
  
  //---------------- Listar veiculo Específico -----------------//
  public function get_list_vehicle()
  {
    $drivers = \App\Driver::all(['id', 'name_driver']);
    return view('vehicle/list_vehicle', compact('vehicles', 'drivers'));
  }

  public function post_list_vehicle(Request $field)
  {
    
    if (is_null($field['situacao'])) {
      $vehicles = $this->vehicles->getVehicles();
    } else {
      $vehicles = $this->vehicle->getVehicle($field);
    }
    $drivers = \App\Driver::all(['id', 'name_driver']);

    return view('vehicle/list_vehicle', compact('vehicles', 'drivers'));
  }

  //--------------------- Listar Veiculos ----------------------//
  public function list_vehicles()
  {
    $drivers = \App\Driver::all(['id', 'name_driver']);
    $vehicles = $this->vehicles->orderBy('created_at','desc')->get();
    return view('vehicle/list_vehicle')
    ->with('vehicles', json_encode($vehicles))
    ->with('drivers', json_encode($drivers));
  }


  //-------------------- Editar Veiculos --------------------//
  public function get_edit_vehicle($id)
  {
    $drivers = \App\Driver::all(['id', 'name_driver']);
    $vehicle = $this->vehicle->find($id);
    return view('vehicle/edit_vehicle', compact('vehicle', 'drivers'));
  }

  public function post_edit_vehicle(VehicleRequest $info, $id)
  {
    $vehicle = $this->vehicle->find($id);
    $vehicle->driver_id  = $info['driver_id'];
    $vehicle->brand  = $info['brand'];
    $vehicle->model = $info['model'];
    $vehicle->placa = $info['placa'];
    $vehicle->year  = $info['year'];
    $vehicle->situacao = $info['situacao'];
    $vehicle->kilometers_per_liter = $info['kilometers_per_liter'];
    $vehicle->save();
    return redirect()->route('vehicles')->with('message', 'Veiculo alterado com sucesso!');;
  }

  //-------------------- Deletar Veiculos --------------------//

  public function delete_vehicle($id)
  {
    $vehicle = $this->vehicle->find($id);
    $vehicle->delete();
    return redirect()->route('vehicles')->with('message', 'Veiculo excluído com sucesso!');
  }
}
