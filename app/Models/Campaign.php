<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $fillable = ['affiliate','name','start_date','end_date','gross_clicks','unique_clicks','duplicate_clicks','cv','cvr','cpa_affiliate','cpa_advertiser','payout_affiliate','payout_advertiser','gross_profit'];
}
