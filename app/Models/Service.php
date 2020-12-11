<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesUuid;

class Service extends Model
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
        'host',
        'app_key',
        'app_name',
        'service_key',
        'remote_addr',
        'status',
        'deleted_at',
    ];
}