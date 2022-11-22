<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
// Importa o model articles
use App\Models\Articles;
use Exception;

class UpArticles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Articles $update)
    {
        $this->update=$update; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(date("H:i")=='09:00'){
            $articles=Http::get('https://api.spaceflightnewsapi.net/v3/articles'); 

        // recebe todos os artigos e Json
        $articles=Http::get('https://api.spaceflightnewsapi.net/v3/articles');
        // Transforma a lista de artigos em array
        $articlesArray=$articles->json();
        $x=1;
        $i=count($articlesArray);
        for($y=0 ; $y < $i; $y++){
            $id=$articlesArray[$y]['id'];
            // Verifica se existe no banco
            $article=$this->update->find($id);
            // Atribui o restante das variáveis
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
            // Se o registro existe no banco não faz nada
            if($article){

            }else{
                // Se o registro não existe insere no banco
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
                        
                       
                } 
                catch (Exception $e) {
                    return response()->json(['msg' => 'Erro ao inserir registros! Exception: '.$e]);
                } 
            }


        }    



        }
    }
}
