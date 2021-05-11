<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestAssigned extends Model
{
    protected $table = 'service_request_assigned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'service_request_id', 'job_accepted', 'job_acceptance_time', 'job_diagnostic_date', 'job_declined_time', 'job_completed_date'
    ];

    /**
     * Get the authenticated user assigned to the request
     */
    public function service_request()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * Get the service request assigned user
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with('account', 'roles');
    }

    /**
     * Store record of a Assigned User on the Service Request Assigned Table
     * 
     * @param  int      $user_id
     * @param  int      $service_request_id
     * @param  string   $job_accepted
     * @param  string   $job_acceptance_time
     * @param  string   $job_diagnostic_date
     * @param  string   $job_declined_time
     * @param  string   $job_completed_date
     * 
     * @return \App\Models\ServiceRequestAssigned|Null
     */
    public static function assignUserOnServiceRequest(int $user_id, int $service_request_id, string $job_accepted = null, string $job_acceptance_time = null, string $job_diagnostic_date = null, string $job_declined_time = null, string $job_completed_date = null)
    {
        return ServiceRequestAssigned::create([
            'user_id'                   => $user_id,
            'service_request_id'        => $service_request_id,
            'job_accepted'              => $job_accepted,
            'job_acceptance_time '      => $job_acceptance_time,
            'job_diagnostic_date'       => $job_diagnostic_date,
            'job_declined_time'         => $job_declined_time,
            'job_completed_date'        => $job_completed_date
        ]);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id')->with('roles', 'account');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'service_request_id', 'user_id');
    }


    public function service_requests()
    {
        return $this->belongsTo(ServiceRequest::class)->with('users', 'client');
    }

    public function request_status()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client_requesting_service()
    {
        return $this->belongsTo(Account::class, 'user_id');
    }

    public function tech_account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'service_id');
    }

    /**
     * Scope a query to sort and filter service_request_assigned table
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopejobAssignedSorting($query, $sortLevel, $dateFrom, $dateTo, $cses)
    {

        if (!empty($cses)) {
            return $query->when($cses, function ($query, $cses) {
                $query->whereIn('user_id', $cses[0]);
            });
        }

        if (!empty($dateFrom)) {
            return $query->when($dateFrom, function ($query) use ($sortLevel, $dateFrom, $dateTo) {
                if ($sortLevel == 'SortType2') {
                    $query->whereBetween('job_acceptance_time', [$dateFrom, $dateTo]);
                } elseif ($sortLevel == 'SortType3') {
                    $query->whereBetween('job_completed_date', [$dateFrom, $dateTo]);
                }
            });
        }
    }

    /**
     * Scope a query to sort and filter service_request_assigned table
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        // Split all filter parameters from the array of filters
        $query->when((string) $filters['sort_level'] ?? null, function ($query, $sortLevel) {
            switch ($sortLevel) {
                case 'SortType2':
                    # code...
                    break;

                case 'SortType3':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }
        })->when((array)$filters['cse_id'][0] ?? null, function ($query, array $cses) {
            $query->whereIn('user_id', $cses);
        })->when((string)$filters['job_status'] ?? null, function ($query, $job_status) {
            // 
        });
    }
}
