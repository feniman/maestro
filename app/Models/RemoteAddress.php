<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class RemoteAddress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use UsesUuid;
    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'part1',
        'part2',
        'part3',
        'part4',
        'status',
        'deleted_at',
    ];
}