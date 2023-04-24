<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static Executor findOrFail(int $id)
 */
class Executor extends Model
{
    use HasFactory;
    protected $guarded = false;
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
