<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct(Articles $article)
    {
       $this->article=$article; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles=array();
        $article=$this->article->select('id','title','url','imageUrl','newsSite','summary','publishedAt','updatedAt', 'featured', 'launches', 'events')->get();
        foreach($article as $data){
            $id=$data['id'];
            $title=$data['title'];
            $url=$data['url'];
            $imageUrl=$data['imageUrl'];
            $newsSite=$data['newsSite'];
            $summary=$data['summary'];
            $publishedAt=$data['publishedAt'];
            $updatedAt=$data['updatedAt'];
            $featured=$data['featured'];
            $launches=json_decode($data['launches']);
            $events=json_decode($data['events']);
            $id_launches='';
            $providers_launches='';
            $id_events='';
            $providers_events='';
            if($launches){
                foreach($launches as $key => $value){
                    $id_launches=$value->id;
                    $providers_launches=$value->provider;
                }
            }
            if($events){
                foreach($events as $key => $value){
                    $id_events=$value->id;
                    $providers_events=$value->provider;
                }
            }
            
            
            

            $articles[]=['id' => $id, 'title' => $title, 'url'=> $url, 'imageUrl'=> $imageUrl,
            'newsSite' => $newsSite, 'summary' => $summary, 'publishedAt' => $publishedAt,
            'updatedAt' => $updatedAt, 'featured' => $featured, 'launches' => [ 'id'=> $id_launches,
             'provider' => $providers_launches ] , 'events' => [ 'id' => $id_events, 'provider' => $providers_events]];
           //print_r($data['id']);     
        }
        return response()->json($articles, 200);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validations
        // id
        // title      
        // url        
        // imageUrl   
        // newsSite   
        // summary     
        // publishedAt
        // updatedAt 
        $data=$request->all();
        //echo $data['id'];
        $launches=json_encode($data['launches']);
        $events=json_encode($data['events']);
        $request->validate($this->article->rules(), $this->article->feedback());

        $article=$this->article->create(['id' => $data['id'], 'title' => $data['title'],
        'url' => $data['url'], 'imageUrl' => $data['imageUrl'], 'newsSite' => $data['newsSite'], 
        'summary' => $data['summary'], 'publishedAt' => $data['publishedAt'], 'updatedAt' => $data['updatedAt'],
         'featured' => $data['featured'], 'launches' => $launches, 'events' => $events]);
        
        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articles=[];
        $article=$this->article->find($id);
        if($article === null){
            return response()->json(['error' => 'O registro não existe'], 404);
        } 
        //echo $article['id'];
        
            $id=$article['id'];
            $title=$article['title'];
            $url=$article['url'];
            $imageUrl=$article['imageUrl'];
            $newsSite=$article['newsSite'];
            $summary=$article['summary'];
            $publishedAt=$article['publishedAt'];
            $updatedAt=$article['updatedAt'];
            $featured=$article['featured'];
            $launches=json_decode($article['launches']);
            $events=json_decode($article['events']);
            $id_launches='';
            $providers_launches='';
            $id_events='';
            $providers_events='';
            if($launches){
                foreach($launches as $key => $value){
                    $id_launches=$value->id;
                    $providers_launches=$value->provider;
                }
            }
            if($events){
                foreach($events as $key => $value){
                    $id_events=$value->id;
                    $providers_events=$value->provider;
                }
            }
            $articles=['id' => $id, 'title' => $title, 'url'=> $url, 'imageUrl'=> $imageUrl,
            'newsSite' => $newsSite, 'summary' => $summary, 'publishedAt' => $publishedAt,
            'updatedAt' => $updatedAt, 'featured' => $featured, 'launches' => [ 'id'=> $id_launches,
             'provider' => $providers_launches ] , 'events' => [ 'id' => $id_events, 'provider' => $providers_events]];

        
        return response()->json($articles, 200);
        
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //print_r($request->all());
        //echo '<hr>';
        //print_r($article->getAttributes());
        
        $article=$this->article->find($id);
        $rules=[
            'id'    => '',
            'title' => 'required',
            'url'   => 'required',
            'imageUrl' => 'required',
            'newsSite' => 'required',
            'summary'  => 'required',
            'publishedAt' => 'required',
            'updatedAt' => 'required'
        ];

        if($article === null){
            return response()->json(['error' => 'Impossível realizar o update. O registro não existe.'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas=array();
            //percorrendo todas as regras definidas na Model
            foreach($this->article->$rules() as $input => $regra){
                //coletar apenas as regras aplicáveis aos parâmetros parciais de requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input]=$regra;
                }
                $request->validate($regrasDinamicas, $this->article->feedback());
            }

        }else{
            $request->validate($rules, $this->article->feedback());
        }

        
        $article->update($request->all());
        return response()->json($article, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //print_r($article->getAttributes());
        $article=$this->article->find($id);
        if($article === null){
            return response()->json(['error' => 'Impossível efetuar o delete. O registro não existe.'], 404);
        }
        $article->delete();
        return response()->json(['msg' => 'O artigo foi deletado!'], 200);
    }
}
