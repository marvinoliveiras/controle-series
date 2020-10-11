<?php
namespace App\Services;
use App\Serie;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    public function criarSerie(string $nome,
        int $qtdTemporadas,int $epPorTemporada):Serie
    {
        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nome]);
        $this->criarTemporadas($qtdTemporadas, $epPorTemporada, $serie);
        DB::commit();
        return $serie;
    }
    public function criarTemporadas(
        $qtdTemporadas, $epPorTemporada, $serie
        ){
        for($i = 1;$i <= $qtdTemporadas; $i++){
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criarEpisodios($epPorTemporada, $temporada);
        }
    }

    public function criarEpisodios($epPorTemporada, $temporada)
    {
        
        for($j = 1; $j <= $epPorTemporada; $j++){
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}