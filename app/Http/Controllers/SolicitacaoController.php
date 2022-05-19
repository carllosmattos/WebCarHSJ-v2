<?php

namespace App\Http\Controllers;

use App\Solicitacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class SolicitacaoController extends Controller
{
    // Função para mostrar view de formulário de solicitação
    public function viewRequestAdd(Request $field)
    {
        // Retorna os usuários
        $usuarios = DB::table('users')
            ->select(
                DB::raw('id as id'),
                DB::raw('sector_id as cc'),
                DB::raw('name as name')
            )->get();


        // Retorna os endereços
        $adress = DB::table('adress')
            ->select(
                DB::raw('id as id'),
                DB::raw('slug_adress as slug_adress'),
                DB::raw('acronym as acronym'),
                DB::raw('lat as lat'),
                DB::raw('lng as lng'),
            )->get();

        $allAdress = DB::table('adress')->orderBy('acronym', 'ASC')->get();

        return view('solicitacao/solicitacao-add', compact('allAdress'))
            ->with('adress', json_encode($adress))
            ->with('usuarios', json_encode($usuarios));
    }

    // Função para gravar dados
    public function store(Request $field)
    {

        $authUserID = Auth::user()->id;
        $role_id = DB::table('role_user')->where('user_id', $authUserID)->get('role_id');
        $role = DB::table('roles')->where('id', $role_id[0]->role_id)->get();

        $arrayForm = count($field['solicitante']);
        $solicitante = $field['solicitante'];
        $setorsolicitante = $field['setorsolicitante'];
        $origem = $field['origem'];
        $destino = $field['destino'];
        $unidade = $field['unidade'];
        $leito = $field['leito'];
        $sltmotivo = $field['sltmotivo'];
        $estadopaciente = $field['estadopaciente'];
        $materiaisfin = $field['materiaisfin'];
        $admfin = $field['admfin'];
        $datasaida = $field['datasaida'];
        $horasaida = $field['horasaida'];
        $dataretorno = empty($field['dataretorno']) ? null : $field['dataretorno'];
        $horaretorno = empty($field['horaretorno']) ? null : $field['horaretorno'];

        for ($i = 0; $i < $arrayForm; $i++) {
            $vehiclerequests[$i] = new Solicitacao();
            $vehiclerequests[$i]->user_id = Auth::user()->id;

            // Identificador de roteiro
            $vehiclerequests[$i]->grouprequest = null;

            $vehiclerequests[$i]->solicitante = $solicitante[$i];
            $vehiclerequests[$i]->setorsolicitante = $setorsolicitante[$i];
            $vehiclerequests[$i]->origem = $origem[$i];
            $vehiclerequests[$i]->destino = $destino[$i];

            // Identifica a finalidade para salvar
            if (!empty($unidade[$i])) {
                if (array_key_exists($i, $unidade)) {
                    $vehiclerequests[$i]->unidade = $unidade[$i];
                    $vehiclerequests[$i]->leito = $leito[$i];
                    $vehiclerequests[$i]->sltmotivo = $sltmotivo[$i];
                    $vehiclerequests[$i]->estadopaciente = $estadopaciente[$i];
                } else {
                    $vehiclerequests[$i]->unidade = null;
                    $vehiclerequests[$i]->leito = null;
                    $vehiclerequests[$i]->sltmotivo = null;
                    $vehiclerequests[$i]->estadopaciente = null;
                };
            };
            if (!empty($materiaisfin[$i])) {
                if (array_key_exists($i, $materiaisfin)) {
                    $vehiclerequests[$i]->materiaisfin = $materiaisfin[$i];
                } else {
                    $vehiclerequests[$i]->materiaisfin = null;
                };
            };
            if (!empty($admfin[$i])) {
                if (array_key_exists($i, $admfin)) {
                    $vehiclerequests[$i]->admfin = $admfin[$i];
                } else {
                    $vehiclerequests[$i]->admfin = null;
                };
            }
            ///////////////////////////////////////////////////

            $vehiclerequests[$i]->datasaida = $datasaida[$i];
            $vehiclerequests[$i]->horasaida = $horasaida[$i];
            $vehiclerequests[$i]->dataretorno = $dataretorno[$i];
            $vehiclerequests[$i]->horaretorno = $horaretorno[$i];
            $vehiclerequests[$i]->statussolicitacao = 'PENDENTE';

            $vehiclerequests[$i]->save();
        }
        return redirect()->route('solicitacoes')->with('msg', 'Solicitacão registrada com sucesso!');
    }

    // Função para listar solicitações
    public function list_solicitacoes()
    {

        $users = DB::table('users')->select(
            DB::raw('id as id'),
            DB::raw('sector_id as sector_id'),
            DB::raw('name as name')
        )->get();

        // Retorna os setores
        $sectors = DB::table('sectors')
            ->select(
                DB::raw('id as id'),
                DB::raw('cc as cc'),
                DB::raw('sector as sector'),
            )->get();

        // Retorna as solicitações em ordem decrescente
        $requests = DB::table('vehiclerequests')->where('user_id', auth()->user()->id)->orderBy('id', 'desc')
            ->select(
                DB::raw('id as id'),
                DB::raw('grouprequest as grouprequest'),
                DB::raw('solicitante as solicitante'),
                DB::raw('setorsolicitante as setorsolicitante'),
                DB::raw('origem as origem'),
                DB::raw('destino as destino'),
                DB::raw('datasaida as datasaida'),
                DB::raw('horasaida as horasaida'),
                DB::raw('statussolicitacao as statussolicitacao'),
            )->get();

        $requestsAll = DB::table('vehiclerequests')->orderBy('id', 'desc')
            ->select(
                DB::raw('id as id'),
                DB::raw('grouprequest as grouprequest'),
                DB::raw('solicitante as solicitante'),
                DB::raw('setorsolicitante as setorsolicitante'),
                DB::raw('origem as origem'),
                DB::raw('destino as destino'),
                DB::raw('datasaida as datasaida'),
                DB::raw('horasaida as horasaida'),
                DB::raw('statussolicitacao as statussolicitacao'),
            )->get();

        $role_id = DB::table('role_user')->where('user_id', auth()->user()->id)->get();

        if (Solicitacao::first()) {
            $vehiclerequests = true;
        } else {
            $vehiclerequests = false;
        }

        if ($role_id[0]->role_id == 1 || $role_id[0]->role_id == 2) {
            return view('solicitacao/solicitacao-list', compact('vehiclerequests'))
                ->with('requests', json_encode($requestsAll))
                ->with('sectors', json_encode($sectors))
                ->with('users', json_encode($users));
        } else {
            return view('solicitacao/solicitacao-list', compact('vehiclerequests'))
                ->with('requests', json_encode($requests))
                ->with('sectors', json_encode($sectors))
                ->with('users', json_encode($users));
        }
    }

    // Função para exbir view de edição de formulário
    public function get_edit_solicitacao($id)
    {
        // Retorna os endereços
        $allAdress = DB::table('adress')
            ->select(
                DB::raw('id as id'),
                DB::raw('slug_adress as slug_adress'),
                DB::raw('acronym as acronym'),
                DB::raw('lat as lat'),
                DB::raw('lng as lng'),
            )->get();

        $addressOrigemRequested = DB::table('vehiclerequests')->where('id', $id)->get('origem');
        $addressDestinoRequested = DB::table('vehiclerequests')->where('id', $id)->get('destino');

        if ($allAdress ->contains("slug_adress", $addressOrigemRequested[0]->origem)) {
            $addressOrigem = false;
        } else {
            $addressOrigem = $addressOrigemRequested[0]->origem;
        }

        
        if ($allAdress ->contains("slug_adress", $addressDestinoRequested[0]->destino)) {
            $addressDestino = false;
        } else {
            $addressDestino = $addressDestinoRequested[0]->destino;
        }

        $vehiclerequest = Solicitacao::find($id);

        return view(
            'solicitacao/solicitacao-edit',
            compact('vehiclerequest', 'allAdress', 'addressOrigem', 'addressDestino')
        );
    }

    // Função para editar informações
    public function post_edit_solicitacao(Request $info, $id)
    {
        $vehiclerequest = Solicitacao::find($id);
        $vehiclerequest->solicitante = $info["solicitante"];
        $vehiclerequest->setorsolicitante = $info["setorsolicitante"];
        $vehiclerequest->origem = $info["origem"];
        $vehiclerequest->destino = $info["destino"];

        $vehiclerequest->unidade = $info["unidade"];
        $vehiclerequest->leito = $info["leito"];
        $vehiclerequest->sltmotivo = $info["sltmotivo"];
        $vehiclerequest->estadopaciente = $info["estadopaciente"];
        $vehiclerequest->materiaisfin = $info["materiaisfin"];
        $vehiclerequest->admfin = $info["admfin"];
        $vehiclerequest->datasaida = $info["datasaida"];
        $vehiclerequest->horasaida = $info["horasaida"];
        $vehiclerequest->dataretorno = $info["dataretorno"];
        $vehiclerequest->horaretorno = $info["horaretorno"];
        $vehiclerequest->save();

        return redirect()->route('solicitacoes')->with('msg', 'Solicitacão alterada com sucesso!');
    }

    // Função deletar Autorização
    public function delete_solicitacao($id)
    {
        $vehiclerequest = Solicitacao::find($id);
        $vehiclerequest->delete();
        return redirect()->back()->with('msg', 'Solicitacão removida com sucesso!');
    }

    // Filtro do Dashboard
    // Suas solicitações pendentes
    public function your_pending_requests(Request $field)
    {

        $users = DB::table('users')->select(
            DB::raw('id as id'),
            DB::raw('sector_id as sector_id'),
            DB::raw('name as name')
        )->get();

        // Retorna os setores
        $sectors = DB::table('sectors')
            ->select(
                DB::raw('id as id'),
                DB::raw('cc as cc'),
                DB::raw('sector as sector'),
            )->get();

        $requests = Solicitacao::where('solicitante', auth()->user()->id)
            ->where('statussolicitacao', 'PENDENTE')
            ->orderBy('id', 'DESC')->get();


        if (Solicitacao::first()) {
            $vehiclerequests = true;
        } else {
            $vehiclerequests = false;
        }
        return view('solicitacao/solicitacao-list', compact('vehiclerequests'))
            ->with('requests', json_encode($requests))
            ->with('sectors', json_encode($sectors))
            ->with('users', json_encode($users));
    }

    // Suas viagens solicitadas
    public function your_trips_made(Request $field)
    {

        $users = DB::table('users')->select(
            DB::raw('id as id'),
            DB::raw('sector_id as sector_id'),
            DB::raw('name as name')
        )->get();
        // Retorna os setores
        $sectors = DB::table('sectors')
            ->select(
                DB::raw('id as id'),
                DB::raw('cc as cc'),
                DB::raw('sector as sector'),
            )->get();

        $requests = Solicitacao::where('solicitante', auth()->user()->id)
            ->where('statussolicitacao', 'REALIZADO')
            ->orderBy('id', 'DESC')->get();


        if (Solicitacao::first()) {
            $vehiclerequests = true;
        } else {
            $vehiclerequests = false;
        }
        return view('solicitacao/solicitacao-list', compact('vehiclerequests'))
            ->with('requests', json_encode($requests))
            ->with('sectors', json_encode($sectors))
            ->with('users', json_encode($users));
    }
}
