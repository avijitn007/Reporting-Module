<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use App\Models\User;

class Dashboard extends Controller
{
    public function index(Request $request) {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');
        
        $data_counts_campaigns = DB::table('affiliates')
                        ->join('campaigns', 'affiliates.id', '=', 'campaigns.affiliate')
                        ->selectRaw('sum(gross_clicks) as total_gross_clicks, sum(unique_clicks) as total_unique_clicks,  sum(duplicate_clicks) as total_duplicate_clicks,  sum(cv) as total_cv,  avg(cvr) as total_cvr,  sum(cpa_affiliate) as total_cpa_affiliate,  sum(cpa_advertiser) as total_cpa_advertiser,  sum(payout_affiliate) as total_payout_affiliate,  sum(payout_advertiser) as total_payout_advertiser,  sum(gross_profit) as total_gross_profit')
                        ->where([ 
                            ['campaigns.start_date', '>=', $start_date],
                            ['campaigns.end_date', '<=', $end_date],
                            ['campaigns.status', '=', '1'],
                            ['affiliates.status', '=', '1']
                        ])
                        ->havingRaw('count(*)> 0')
                        ->get();
                    
        config()->set('database.connections.mysql.strict', false);
        DB::reconnect();
        $query = DB::table('affiliates')
                    ->join('campaigns', 'affiliates.id', '=', 'campaigns.affiliate')
                    ->where([ 
                        ['campaigns.start_date', '>=', $start_date],
                        ['campaigns.end_date', '<=', $end_date],
                        ['campaigns.status', '=', '1'],
                        ['affiliates.status', '=', '1']
                    ]);
        // $query->ddRawSql(); 

        $all_data = $query
                    ->select('affiliates.id as affiliate_id', 'affiliates.name as affiliate_name',  'campaigns.*')->get();
        $data_counts_affiliate_res =  $query
                    ->selectRaw('sum(campaigns.gross_clicks) as total_gross_clicks, sum(campaigns.unique_clicks) as total_unique_clicks,  sum(campaigns.duplicate_clicks) as total_duplicate_clicks,  sum(campaigns.cv) as total_cv,  avg(campaigns.cvr) as total_cvr,  sum(campaigns.cpa_affiliate) as total_cpa_affiliate,  sum(campaigns.cpa_advertiser) as total_cpa_advertiser,  sum(campaigns.payout_affiliate) as total_payout_affiliate,  sum(campaigns.payout_advertiser) as total_payout_advertiser,  sum(campaigns.gross_profit) as total_gross_profit')
                    ->groupBy('campaigns.affiliate', 'affiliates.id')
                    ->get();
        
        $all_data_arr = $all_data->toArray();
        
        /* $f = array();
        
        foreach($all_data_arr as $arr){
            if(key_exists($arr->affiliate_id, $f)){
                $f[$arr->affiliate_id] = $arr;
                echo 'exists';
                print_r($f);
            }else{
                $f[] = $arr;
                echo 'not';
                print_r($f);
            }
        }
        echo 'final'; */
        $data_counts_affiliate = [];
        foreach($data_counts_affiliate_res as $dc){
            $data_counts_affiliate[$dc->affiliate_id] = $dc;
        }

        $all_affiliates = array_map(function($arr){
            return array(
                'affiliate_id' => $arr->affiliate_id,
                'affiliate_name' => $arr->affiliate_name
            );
        }, $all_data_arr);            
        
        $all_affiliates = array_unique($all_affiliates, SORT_REGULAR );
        
        /* $final_array= array_map(function($main_arr, $aff_arr){
            if(isset($aff_arr['affiliate_id']) && $main_arr->affiliate_id == $aff_arr['affiliate_id']){
                return array($main_arr);
            }
        },$all_data_arr,$all_affiliates); */

        // echo "<pre>data: "; print_r($data_counts_campaigns);
        // die;

        DB::disconnect();
        return view('Dashboard',['affiliates'=>$all_affiliates, 'data_counts_campaigns'=>$data_counts_campaigns, 'all_data'=>$all_data, 'data_counts_affiliate' => $data_counts_affiliate, 'dates'=>[$start_date,$end_date]]);
    }

    public function users(){
        $all_users = DB::table('users')->get();

        return "<h1>Coming soon...</h1>"; //view('Dashboard',['users'=>$all_users]);
    }

    public function register(Request $request){
        $data = new User();
        // $data = $request->all();
        // unset($data['_token']);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;
        $ret = $data->save();
        return $ret;
        // return DB::table('users')->insertGetId($data);
    }
}
