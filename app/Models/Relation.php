<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;

class Relation extends Model
{
    use HasFactory;


    public function authors()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }
}
