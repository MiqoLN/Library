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

    public static function filter(string $query){
        return match ($query){
          'mysql' => self::get(),
          default => '404',
        };
    }

    public static function id(int $id){
        return self::where('id', '=', $id)->get();
    }

}
