<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Executor findOrFail(int $id)
 */
class Executor extends Model
{
    use HasFactory;
    protected $guarded = false;
}
