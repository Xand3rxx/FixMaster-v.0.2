<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestProgress extends Model
{

    /**
     * Store record of a Assigned User on the Service Request Progress Table
     * 
     * @param  int          $user_id
     * @param  int          $service_request_id
     * @param  int          $status_id
     * @param  int|Null     $sub_status_id
     * @return \App\Models\ServiceRequestProgress|Null
     */
    public static function storeProgress(int $user_id, int $service_request_id, int $status_id, int $sub_status_id = null)
    {
        return ServiceRequestProgress::create([
            'user_id'              => $user_id,
            'service_request_id'   => $service_request_id,
            'status_id'            => $status_id,
            'sub_status_id'        => $sub_status_id,
        ]);
    }
}
