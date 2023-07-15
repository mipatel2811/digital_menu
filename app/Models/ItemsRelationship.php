<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsRelationship extends Model
{
    use HasFactory;

    public $fillable = ["item_id", "term_id"];
}
