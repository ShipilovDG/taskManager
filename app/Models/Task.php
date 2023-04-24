<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static Task findOrFail(int $id)
 */
class Task extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function executor(): BelongsTo
    {
        return $this->belongsTo(Executor::class);
    }
}
