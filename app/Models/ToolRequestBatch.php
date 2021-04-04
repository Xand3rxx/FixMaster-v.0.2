<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolRequestBatch extends Model
{

    protected $fillable = [
        'tool_request_id', 'tool_id', 'quantity'
    ];

    public $timestamps = false; 
}
