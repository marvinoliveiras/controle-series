<?php

namespace Tests\Unit;

use App\Serie;
use App\Services\CriadorDeSerie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CriadorDeSerieTest extends TestCase
{
    use RefreshDatabase;
    public function testCriarSerie()
    {
        $criadorDeSerie = new CriadorDeSerie();
        $nome = 'Nome de teste';
        $serieCriada = $criadorDeSerie->criarSerie($nome, 1, 1);

        $this->assertInstanceOf(Serie::class, $serieCriada);
        $this->assertDatabaseHas('temporadas', ['serie_id' => $serieCriada->id, 'numero' => 1]);
        $this->assertDatabaseHas('episodios', ['numero' => 1]);
    }
}
