<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    private $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
        $this->drivers = $driver;
        $this->middleware('auth');
    }

    //-------------------- Adicionar Motorista--------------------//
    public function get_add_driver(Request $field)
    {
        return view('driver/add_driver');
    }
    public function post_add_driver(Request $info)
    {
        $driver = $this->driver->addDriver($info);
        return redirect()->route('drivers')->with('message', 'Motorista adicionado com sucesso!');;
    }
    //------------------------------------------------------------//

    //---------------- Listar Motorista Específica -----------------//
    public function get_list_driver()
    {
        return view('driver/list_driver');
    }

    public function post_list_driver(Request $field)
    {

        if (is_null($field['name_driver'])) {
            $drivers = $this->drivers->getDriers();
        } else {
            $drivers = $this->drive->getDrive($field);
        }

        return view('driver/list_driver', compact('vehicles'));
    }

    //--------------------- Listar Motoristas ----------------------//
    public function list_drivers()
    {
        $drivers = $this->drivers->orderBy('created_at', 'desc')->get();
        return view('driver/list_driver', compact('drivers'));
    }

    //-------------------- Editar Motorista --------------------//
    public function get_edit_driver($id)
    {
        $driver = $this->driver->find($id);
        return view('driver/edit_driver', compact('driver'));
    }

    public function post_edit_driver(Request $info, $id)
    {
        $driver = $this->driver->find($id);
        $driver->name_driver  = $info['name_driver'];
        $driver->cpf  = $info['cpf'];
        $driver->hab = implode(",", $info['hab']);
        $driver->save();
        return redirect()->route('drivers')->with('message', 'Veiculo alterado com sucesso!');;
    }

    //-------------------- Deletar Motorista --------------------//

    public function delete_driver($id)
    {
        $driver = $this->driver->find($id);
        $driver->delete();
        return redirect()->route('drivers')->with('message', 'Motorista excluído com sucesso!');
    }
}
