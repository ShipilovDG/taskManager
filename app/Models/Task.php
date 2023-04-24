<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Task findOrFail(int $id)
 */
class Task extends Model
{
    use HasFactory;

    protected $guarded = false;
}
