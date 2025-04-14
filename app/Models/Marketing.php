<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_no',
        'vas_type',
        'cat',
        'policy_no',
        'policy_start_date',
        'policy_end_date',
        'email',
        'account',
        'account_type',
        'industry',
        'is_mnc',
        'year',
        'quarter',
        'month',
        'sales_rm_name',
        'sales_band_1',
        'claims_manager_level_1',
        'claims_manager',
        'reporting_manager',
        'hub',
        'actual_hub',
        'vertical',
        'vertical_type',
        'status',
        'expense',
        'surveyor_name',
        'visit_date',
        'gwp',
        'nic',
        'nep',
        'number_of_claims',
        'lr_ytd',
        'pending_reason_description',
        'rm_name',
        'agent_name',
        'branch',
        'should_send_mail',
    ];
}
