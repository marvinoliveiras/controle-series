<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        /*echo $request->url."<br>";
        echo "<pre>".var_dump($request->query());exit();*/

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

    public function store(SeriesFormRequest $request)
    {
        $nome = $request->nome;

        $serie = Serie::create(['nome' => $request->nome]);

        $qtdTemporadas = $request->qtd_temporadas;
        $epPorTemporada = $request->ep_por_temporada;
        for($i = 1; $i <= $qtdTemporadas; $qtdTemporadas++){
            $temporada = $serie->temporadas()->create(['numero' => $i]);

            for($j = 1; $j <= $epPorTemporada; $j++){
                $temporada->episodios()->create(['numero' => $j]);
            }
        }

        
        $request->session()
            ->flash('mensagem',
            "Série {$serie->id} {$serie->nome} e suas temporadas e episodios criados com sucesso");


        return redirect()->route('listar_series');
    }
    public function destroy(Request $request)
    {
        $serie = Serie::destroy($request->id);
        $request->session()
            ->flash('mensagem',
            "Série deletada com sucesso");

        return redirect()->route('listar_series');
    }
}