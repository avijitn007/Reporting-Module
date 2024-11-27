<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use App\Models\Campaign;
use Exception;

class Campaigns extends Controller
{   
    private $Campaign;
    private $Affiliate;
    protected $stopOnFirstFailure = true;
    private $response = "";

    public function __construct()
    {
        $this->Campaign = new Campaign();
        $this->Affiliate = new Affiliate();
    }

    public function index(){

        $all_affiliates = $this->Affiliate->where('status', '1')->get();
        
        return view('campaigns', ['all_affiliates'=>$all_affiliates]);
        
    }

    public function add(Request $request){

        $request->validate([
            'affiliate' => 'required',
            'row.*.name' => 'required|unique:campaigns,name,null,null,affiliate,'.$request->affiliate,
            'row.*.start_date' => 'required|date',
            'row.*.end_date' => 'required|date',
            'row.*.gross_clicks' => 'required|numeric',
            'row.*.unique_clicks' => 'required|numeric',
            'row.*.duplicate_clicks' => 'required|numeric',
            'row.*.cv' => 'required|numeric',
            'row.*.cvr' => 'required|numeric',
            'row.*.cpa_affiliate' => 'required|numeric',
            'row.*.cpa_advertiser' => 'required|numeric',
            'row.*.payout_affiliate' => 'required|numeric',
            'row.*.payout_advertiser' => 'required|numeric',
            'row.*.gross_profit' => 'required|numeric'

        ],[/* rules */],
        [
            'affiliate' => 'Affiliate',
            'row.*.name' => 'Campaign Name [row: :index]',
            'row.*.start_date' => 'Start Date [row: :index]',
            'row.*.end_date' => 'End Date [row: :index]',
            'row.*.gross_clicks' => 'Gross Clicks [row: :index]',
            'row.*.unique_clicks' => 'Unique Clicks [row: :index]',
            'row.*.duplicate_clicks' => 'Duplicate Clicks [row: :index]',
            'row.*.cv' => 'CV [row: :index]',
            'row.*.cvr' => 'CVR [row: :index]',
            'row.*.cpa_affiliate' => 'CPA Affiliate [row: :index]',
            'row.*.cpa_advertiser' => 'CPA Advertiser [row: :index]',
            'row.*.payout_affiliate' => 'Payout Affiliate [row: :index]',
            'row.*.payout_advertiser' => 'Payout Advertiser [row: :index]',
            'row.*.gross_profit' => 'Gross Profit [row: :index]'
        ]);

        foreach($request->row as $campaign_row){
            $dataset[] = [
                'affiliate' =>$request->affiliate,
                'name' =>$campaign_row['name'],
                'start_date' =>$campaign_row['start_date'],
                'end_date' =>$campaign_row['end_date'],
                'gross_clicks' =>$campaign_row['gross_clicks'],
                'unique_clicks' =>$campaign_row['unique_clicks'],
                'duplicate_clicks' =>$campaign_row['duplicate_clicks'],
                'cv' =>$campaign_row['cv'],
                'cvr' =>$campaign_row['cvr'],
                'cpa_affiliate' =>$campaign_row['cpa_affiliate'],
                'cpa_advertiser' =>$campaign_row['cpa_advertiser'],
                'payout_affiliate' =>$campaign_row['payout_affiliate'],
                'payout_advertiser' =>$campaign_row['payout_advertiser'],
                'gross_profit' =>$campaign_row['gross_profit']
            ];
        }
        // print_r($dataset);
        // return;
        try{
            // $this->Campaign->upsert($dataset, uniqueBy: ['affiliate','name']);
            // $this->Campaign->fill($dataset);
            $this->Campaign->insert($dataset);
            return back()->with('response', "Campaigns added for Affiliate #".$request->affiliate);
        } catch(Exception $e){
            return back()->with('response', $e->getMessage())->withInput();
        }
        
    }

    public function edit(Request $request){        
        $all_affiliates = $this->Affiliate->where('status', '1')->get();
        
        if(!$request->affiliateid){            
            $data = ['all_affiliates'=>$all_affiliates];
        }else{

            $affiliate = $this->Affiliate->where('id',$request->affiliateid)->first();
            $all_campaigns = $this->Campaign->where('affiliate',$request->affiliateid)->get();
            $data = ['selected_affiliate'=>$affiliate,'all_campaigns'=>$all_campaigns,'all_affiliates'=>$all_affiliates];
            // echo '<pre>';print_r($affiliate->id);die;
        }
    
        return view('edit-campaigns', $data);
   }

    public function update(Request $request){
        $request->validate([
            'affiliate' => 'required',
            'update_row.*.id' => 'required',
            'update_row.*.name' => 'required',
            'update_row.*.start_date' => 'required|date',
            'update_row.*.end_date' => 'required|date',
            'update_row.*.gross_clicks' => 'required|numeric',
            'update_row.*.unique_clicks' => 'required|numeric',
            'update_row.*.duplicate_clicks' => 'required|numeric',
            'update_row.*.cv' => 'required|numeric',
            'update_row.*.cvr' => 'required|numeric',
            'update_row.*.cpa_affiliate' => 'required|numeric',
            'update_row.*.cpa_advertiser' => 'required|numeric',
            'update_row.*.payout_affiliate' => 'required|numeric',
            'update_row.*.payout_advertiser' => 'required|numeric',
            'update_row.*.gross_profit' => 'required|numeric'

        ],[],
        [
            'affiliate' => 'Affiliate',
            'update_row.*.name' => 'Campaign Name [campaign no. #:position]',
            'update_row.*.start_date' => 'Start Date [campaign no. #:position]',
            'update_row.*.end_date' => 'End Date [campaign no. #:position]',
            'update_row.*.gross_clicks' => 'Gross Clicks [campaign no. #:position]',
            'update_row.*.unique_clicks' => 'Unique Clicks [campaign no. #:position]',
            'update_row.*.duplicate_clicks' => 'Duplicate Clicks [campaign no. #:position]',
            'update_row.*.cv' => 'CV [campaign no. #:position]',
            'update_row.*.cvr' => 'CVR [campaign no. #:position]',
            'update_row.*.cpa_affiliate' => 'CPA Affiliate [campaign no. #:position]',
            'update_row.*.cpa_advertiser' => 'CPA Advertiser [campaign no. #:position]',
            'update_row.*.payout_affiliate' => 'Payout Affiliate [campaign no. #:position]',
            'update_row.*.payout_advertiser' => 'Payout Advertiser [campaign no. #:position]',
            'update_row.*.gross_profit' => 'Gross Profit [campaign no. #:position]'
        ]);

        foreach($request->update_row as $campaign_update_row){
            $dataset[] = [
                'affiliate' =>$request->affiliate,
                'id' =>$campaign_update_row['id'],
                'name' =>$campaign_update_row['name'],
                'start_date' =>$campaign_update_row['start_date'],
                'end_date' =>$campaign_update_row['end_date'],
                'gross_clicks' =>$campaign_update_row['gross_clicks'],
                'unique_clicks' =>$campaign_update_row['unique_clicks'],
                'duplicate_clicks' =>$campaign_update_row['duplicate_clicks'],
                'cv' =>$campaign_update_row['cv'],
                'cvr' =>$campaign_update_row['cvr'],
                'cpa_affiliate' =>$campaign_update_row['cpa_affiliate'],
                'cpa_advertiser' =>$campaign_update_row['cpa_advertiser'],
                'payout_affiliate' =>$campaign_update_row['payout_affiliate'],
                'payout_advertiser' =>$campaign_update_row['payout_advertiser'],
                'gross_profit' =>$campaign_update_row['gross_profit']
            ];
        }
        // print_r($dataset);
        // return;
        try{
            $this->Campaign->upsert($dataset, ['id']);
            // $this->Campaign->fill($dataset);
            // $this->Campaign->insert($dataset);
            return back()->with('response', "Campaigns updated for Affiliate #".$request->affiliate);
        } catch(Exception $e){
            return back()->with('response', $e->getMessage())->withInput();
        }
        
        
    }

    public function deactivate($id){
        
        $row = $this->Campaign->find($id);
        if($row){
            $row->status = '0';
            $row->save();
            $this->response = "Campaign deactivated successfully!";
        }else{
            $this->response = "Campaign not found!";            
        }

        return back()->with('response', $this->response);

    }

    public function activate($id){
        
        $row = $this->Campaign->find($id);
        if($row){
            $row->status = '1';
            $row->save();
            $this->response = "Campaign activated successfully!";
        }else{
            $this->response = "Campaign not found!";            
        }

        return back()->with('response', $this->response);

    }
}
