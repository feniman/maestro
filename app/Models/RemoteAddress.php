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
        'remote_address',
        'status',
        'deleted_at',
    ];
}