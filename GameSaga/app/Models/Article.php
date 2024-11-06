<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'note_auteur',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}