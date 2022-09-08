<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function filter(string $query)
    {
        return match ($query){
          'mysql' => $this->get(),
          default => '404',
        };
    }

    public function id(int $id){
        return $this->where('id', $id)->get();
    }

}
