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

    public function toolRequest()
    {
        return $this->belongsTo(ToolRequest::class, 'id', 'tool_request_id');
    }

    public function toolRequests()
    {
        return $this->hasMany(ToolRequest::class, 'id', 'tool_request_id');
    }

    public function tool()
    {
        return $this->belongsTo(ToolInventory::class, 'tool_id', 'id');
    }

    public function tools()
    {
        return $this->hasMany(ToolInventory::class, 'tool_id', 'id');
    }
}
