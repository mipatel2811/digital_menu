<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    use HasFactory;

    public $fillable = ["name", "slug", "logo", "background_color", "description", "user_id", "images", "location", "address", "city"];


    public function owner() {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
