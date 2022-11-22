<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $fillable=['id', 'title', 'url', 'imageUrl', 
    'newsSite', 'summary', 'publishedAt', 'updatedAt', 'featured', 'launches', 'events' ];
    //função de validação regras
    public function rules(){
        return [
            'id'    => 'required|unique:articles',
            'title' => 'required',
            'url'   => 'required',
            'imageUrl' => 'required',
            'newsSite' => 'required',
            'summary'  => 'required',
            'publishedAt' => 'required',
            'updatedAt' => 'required'
        ];
    }
    //função de validação do feedback
    public function feedback(){
        return [
            'required' => ' :attibute field is required',
            'id.unique' => 'The field "id" already exists',
        ];
    }

    public function events(){
        return $this->hasMany('App\Models\Events');
    }
    public function launches(){
        return $this->hasMany('App\Models\Launches');
    }
}
