<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie as ServicesCriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Temporada;
use CriadorDeSerie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::query()
            ->orderBy('nome')
            ->get();

        $mensagem = $request->session()->get('mensagem');
        return view('series.index',
            compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request,
    ServicesCriadorDeSerie $criadorDeSerie)
    {
        $serie = $criadorDeSerie->criarSerie(
            $request->nome, $request->qtd_temporadas,
            $request->ep_por_temporada);
        
        $request->session()
            ->flash('mensagem',
            "Série {$serie->id} {$serie->nome} e suas temporadas e episodios criados com sucesso");


        return redirect()->route('listar_series');
    }
    public function destroy(Request $request,
    RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        $request->session()
            ->flash('mensagem',
            "Série {$nomeSerie} deletada com sucesso");

        return redirect()->route('listar_series');
    }

    public function editaNome($id, Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }
}