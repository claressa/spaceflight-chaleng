<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// Importa o model articles
use App\Models\Articles;
use Exception;

class UpdateController extends Controller
{
    // insere a instância articles
    public function __construct(Articles $update)
    {
        $this->update=$update; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // Faz uma requisição GET ao spacefligtht API e retorna todos e preenche todos os artigos na base de dados
        // recebe todos os artigos e Json
        $articles=Http::get('https://api.spaceflightnewsapi.net/v3/articles');
        // Transforma a lista de artigos em array
        $articlesArray=$articles->json();
        $x=1;
        $i=count($articlesArray);

        //percorre o array e faz a inserção de registros de um por um no banco de dados na tabela home
        
        for($y=0 ; $y < $i; $y++){
            $id=$articlesArray[$y]['id'];
            $title=$articlesArray[$y]['title'];
            $url=$articlesArray[$y]['url'];
            $imageUrl=$articlesArray[$y]['imageUrl'];
            $newsSite=$articlesArray[$y]['newsSite'];
            $summary=$articlesArray[$y]['summary'];
            $publishedAt=$articlesArray[$y]['publishedAt'];
            $updatedAt=$articlesArray[$y]['updatedAt'];
            $featured=$articlesArray[$y]['featured'];
            $launches=json_encode($articlesArray[$y]['launches']);
            $events=json_encode($articlesArray[$y]['events']);
            
            try{
                $this->update->create([
                    
                    'id' => $id, 
                    'title' => $title, 
                    'url' => $url,
                    'imageUrl' => $imageUrl,
                    'newsSite' => $newsSite,
                    'summary' => $summary,
                    'publishedAt' => $publishedAt,
                    'updatedAt' => $updatedAt,
                    'featured' => $featured,
                    'launches' => $launches,
                    'events' => $events

            
                    ]);
                    //echo 'Registro de id='.$articlesArray[$y]['id'].' inserido';
                    $x++;
            } 
            catch (Exception $e) {
                return response()->json(['msg' => 'Erro ao inserir registros! Exception: '.$e]);
            }                                                 
            //return response()->json(['error' => 'Unable to perform the delete. The requested record does not exist.'], 404)  
        }
        
        return response()->json(['msg' => 'Total de '.$x.' registros inseridos ' , 'registros' => $articlesArray ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        
        //
        //
     
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function show(Update $update)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function edit(Update $update)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Update $update)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Update  $update
     * @return \Illuminate\Http\Response
     */
    public function destroy(Update $update)
    {
        //
    }
}
