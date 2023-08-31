<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'title',
    ];

    public static $VISIBLE = [
        'date',
        'start_time',
        'end_time',
        'title'
    ];
    //protected $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    protected $with = ['member'];

    public function member(): HasMany
    {
        return $this->hasMany(Member::class);
    }


    public $timestamps = false;
}
