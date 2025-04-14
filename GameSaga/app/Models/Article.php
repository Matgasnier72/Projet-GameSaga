<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        return $this->belongsTo(User::class, 'user_id');
    }
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y H:i');
    }
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y H:i');
    }
}