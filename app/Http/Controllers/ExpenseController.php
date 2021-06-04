<?php

namespace App\Http\Controllers;

use App\Expense;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    private $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
        $this->expenses = $expense;
        $this->middleware('auth');
    }

    //-------------------- Adicionar Despesa --------------------//
    // Cadastrar despesa livre
    public function get_add_expense_livre(Request $field)
    {
        $vehicles = \App\Vehicle::all(['id', 'model', 'brand', 'placa']);
        return view('expense/add_free_expense', compact('vehicles'));
    }

    // Cadastrar despesa a partir de um veículo
    public function get_add_expense(Request $field)
    {
        $vehicles = \App\Vehicle::all(['id', 'model', 'brand', 'placa']);
        return view('expense/add_expense', compact('vehicles'));
    }

    public function post_add_expense(Request $request)
    {

        $expense = $this->expense->addExpense($request);
        return redirect()->route('expenses')->with('message', 'Despesa cadastrada com sucesso!');;
    }

    //---------------- Listar DESPESA específico -----------------//
    public function post_list_expense(Request $field)
    {
        if (!is_null($field['name_expense']) || !is_null($field['data'])) {
            $vehicles = \App\Vehicle::all(['id', 'model', 'brand', 'placa']);
            $expenses = $this->expenses->getExpense($field);
        } else {
            $vehicles = \App\Vehicle::all(['id', 'model', 'brand', 'placa']);
            $expenses = $this->expenses->getExpenses()->sortByDesc("id");
        }
        return view('expense/list_expense', compact('expenses', 'vehicles'));
    }

    //--------------------- Listar Despesas ----------------------//
    public function list_expenses()
    {
        $expenses = $this->expenses->orderBy('id', 'desc')->get();

        function returnVehicle($id)
        {
            $vehicles = \App\Vehicle::all(['id', 'model', 'brand', 'placa']);
            for ($i = 0; $i < count($vehicles); $i++) {
                if ($vehicles[$i]->id == $id) {
                    return $vehicles[$i]->brand . ' ' . $vehicles[$i]->model . ' - ' . $vehicles[$i]->placa;
                }
            }
        }

        function returnCategory($id)
        {
            $categories = DB::table('categories')->get();
            for ($i = 0; $i < count($categories); $i++) {
                if ($categories[$i]->id == $id) {
                    return $categories[$i]->name;
                }
            }
        }

        $list_expenses = [];
        for ($i = 0; $i < count($expenses); $i++) {
            array_push(
                $list_expenses,
                [
                    $expenses[$i]->id,
                    returnVehicle($expenses[$i]->vehicle_id),
                    returnCategory($expenses[$i]->category_id),
                    $expenses[$i]->supply_in_liters,
                    $expenses[$i]->total_value_supply,
                    $expenses[$i]->previous_mileage,
                    $expenses[$i]->current_mileage,
                    $expenses[$i]->quantity_km_whells,
                    $expenses[$i]->cost_per_liter,
                    $expenses[$i]->kilometers_per_liter,
                    $expenses[$i]->date,
                    $expenses[$i]->time,
                    $expenses[$i]->description
                ]
            );
        }

        return view('expense/list_expense', compact('list_expenses'));
    }

    //-------------------- Editar Despesas --------------------//
    public function get_edit_expense($id)
    {
        $vehicles = \App\Vehicle::all(['id', 'model', 'brand', 'placa']);
        $expense = $this->expense->find($id);
        $exp_edit = $this->expense->find($id);
        $permission = DB::table('role_user')->get();


        $dateNow = date('Y-m-d H:i:s'); // Data atual
        $dateDay = date('d'); // Dia atual
        $dateMonth = date('m'); // Mês atual
        $dateYear = date('Y'); // Ano atual
        $amountMonth = date("t"); //Ultimo dia do mês atual ou quantidade de dias do mês
        $sevenDay = $amountMonth - 7; // Data limite para edição ou exclusão de despesas()
        $allowedStartDateExpense = $dateYear . '-' . $dateMonth . '-' . $sevenDay . ' 23:59:59'; //2020-11-23 23:59:59 ultimo minuto do dia
        $firtsMonthDate = $dateYear . '-' . $dateMonth . '-01 00:00:00'; //2020-11-01 00:00:00 primeiro minuti do dia

        if (
            ($dateNow > $firtsMonthDate) && // data atual for maior primeiro dia do mês a partir de 00:00:00 (2021-04-20 12:29:31 > 2021-04-14) true
            ($dateNow <= $allowedStartDateExpense) && // data atual menor que a data limite (2021-04-20 12:29:31 < 20) true
            ($expense->date > $firtsMonthDate) && // data da despesa maior que  primeiro dia do mês a partir de 00:00:00 (2021-04-14 > 2021-04-01) true
            ($expense->date < $allowedStartDateExpense) // data da desepsa menor que data limite 23:59:59 false
        ) {
            return view('expense/edit_expense', compact('expense', 'vehicles'))->with('exp_edit', json_encode($exp_edit));
        } else {
            if (auth()->user()->roles[0]->name === 'SUPER ADM') {
                return view('expense/edit_expense', compact('expense', 'vehicles'))->with('exp_edit', json_encode($exp_edit));
            } else {
                return redirect()->back()->with('error', 'O prazo para editar esta despesa expirou! Entre em contato com o administrador do sistema caso seja realmente necessário editar.');
            }
        }
    }

    public function post_edit_expense(Request $info, $id)
    {
        $expense = $this->expense->find($id);
        $expense->vehicle_id = $info['vehicle_id'];
        $expense->category_id  = $info['category_id'];

        $expense->total_value_supply = $info['total_value_supply'];

        if ($info['category_id'] == 1) {
            $expense->supply_in_liters = floatval($info['supply_in_liters']);
            $expense->previous_mileage = $info['previous_mileage'];
            $expense->current_mileage = $info['current_mileage'];

            // Calculos 
            $quantity_km_whels = (intval($info['current_mileage']) - intval($info['previous_mileage']));
            $cost_per_liter = (floatval($info['total_value_supply']) / floatval($info['supply_in_liters']));
            $kilometers_per_liter = $quantity_km_whels / floatval($info['supply_in_liters']);
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

        $expense->date = $info['date'];
        $expense->time = $info['time'];
        $expense->description  = $info['description'];

        $expense->save();
        return redirect()->route('expenses')->with('message', 'Veiculo alterado com sucesso!');;
    }

    //-------------------- Deletar Despesas --------------------//
    public function delete_expense($id)
    {
        $expense = $this->expense->find($id);

        $dateNow = date('Y-m-d H:i:s'); // Data atual
        $dateDay = date('d'); // Dia atual
        $dateMonth = date('m'); // Mês atual
        $dateYear = date('Y'); // Ano atual
        $amountMonth = date("t"); //Ultimo dia do mês atual ou quantidade de dias do mês
        $sevenDay = $amountMonth - 7; // Data limite para edição ou exclusão de despesas()
        $allowedStartDateExpense = $dateYear . '-' . $dateMonth . '-' . $sevenDay . ' 23:59:59'; //2020-11-23 23:59:59 ultimo minuto do dia
        $firtsMonthDate = $dateYear . '-' . $dateMonth . '-01 00:00:00'; //2020-11-01 00:00:00 primeiro minuti do dia

        if (
            ($dateNow > $firtsMonthDate) && // data atual for maior primeiro dia do mês a partir de 00:00:00 (2021-04-20 12:29:31 > 2021-04-14) true
            ($dateNow <= $allowedStartDateExpense) && // data atual menor que a data limite (2021-04-20 12:29:31 < 20) true
            ($expense->date > $firtsMonthDate) && // data da despesa maior que  primeiro dia do mês a partir de 00:00:00 (2021-04-14 > 2021-04-01) true
            ($expense->date < $allowedStartDateExpense) // data da desepsa menor que data limite 23:59:59 false
        ) {
            $expense->delete();
            return redirect()->route('expenses');
        } else {
            if (auth()->user()->roles[0]->name === 'SUPER ADM') {
                $expense->delete();
                return redirect()->route('expenses');
            } else {
                return redirect()->back()->with('error', 'O prazo para excluir esta despesa expirou! Entre em contato com o administrador do sistema caso seja realmente necessário excluir.');
            }
        }
    }
}
