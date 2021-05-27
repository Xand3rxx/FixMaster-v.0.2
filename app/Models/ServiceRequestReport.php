<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestReport extends Model
{
    use HasFactory;

    protected $table = 'medias';

    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    const TYPES = ['Root-Cause', 'Other-Comment', 'Comment'];
    const STAGES = ['Service-Request', 'Warranty-Claim'];
}
