<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolRequestBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_request_id', 'tool_id', 'quantity'
    ];
}
