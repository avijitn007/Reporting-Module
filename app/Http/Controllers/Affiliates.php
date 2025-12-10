<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Affiliate;
use Exception;

class Affiliates extends Controller
{   
    private $response = "";
    // protected $affiliate;
    public function __construct(private Affiliate $Affiliate)
    {        
        // $this->Affiliate = $Affiliate;
    }
    
    public function index() {
        $all_affiliates = $this->Affiliate->all();
        return view('affiliates', ['all_affiliates'=>$all_affiliates]);
    }

    public function add(Request $request){
        $request->validate([
            'logo' => 'file|image',
            'name' => 'required',
            'email' => 'required|unique:affiliates,email|email:filter',
            'phone' => 'required|digits:10'
        ]); 
              
        if($request->hasFile('logo') && $request->file('logo')->isValid()){
            $image= $request->logo->hashname();
            $path = $request->logo->storeAs('assets/uploads', $image ,'public');
            $this->Affiliate->logo= $image;
        }
        // echo $path;
        $this->Affiliate->name= $request->name;
        $this->Affiliate->email= $request->email;
        $this->Affiliate->phone= $request->phone;
        try{
            $this->Affiliate->save();
            
            $insert_id = $this->Affiliate->id;
            
            return back()->with('response', "Affiliate added with ID#: ".$insert_id);            
        } catch(Exception $e){
            // echo "abc";
            return back()->with('response', $e->getMessage())->withInput();
        }

    }

    public function edit($id){
        $row = $this->Affiliate->find($id);
        return view('edit-affiliates', ['affiliate'=>$row]);
    }

    /* public function update( Request $request, Affiliate $affiliate){
        // $this->Affiliate = $affiliate;
        // dd($request->all(), $this->Affiliate);
        $validatedRequest = $request->validate([
            'logo' => 'file|image',
            'name' => 'required',
            'email' => 'required|unique:affiliates,email|email:filter,{$affiliate->id}',
            // 'email' => [
            //     'required',
            //     'email',
            //     // 👇 ignore the current affiliate's ID so it won't trigger the "email taken" error
            //     Rule::unique('affiliates', 'email')->ignore($affiliate->id),
            // ],
            'phone' => 'required|digits:10'
        ]); 
              
        if($request->hasFile('logo') && $request->file('logo')->isValid()){
            $image= $request->logo->hashname();
            $path = $request->logo->storeAs('assets/uploads', $image ,'public');
            // $this->Affiliate->logo= $image;
            $affiliate->logo= $image;
        }
        // echo $path;
        // $this->Affiliate->name= $request->name;
        // $this->Affiliate->email= $request->email;
        // $this->Affiliate->phone= $request->phone;
        try{
            $affiliate->update($validatedRequest);
            
            // $insert_id = $this->Affiliate->id;
            
            return back()->with('response', "Affiliate updated with ID#: ".$affiliate->id);            
        } catch(Exception $e){
            // echo "abc";
            return back()->with('response', $e->getMessage())->withInput();
        }
    } */
    public function update(Request $request, Affiliate $affiliate)
    {
        // Validate input
        $validated = $request->validate([
            'logo'  => 'file|image',
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:affiliates,email,' . $affiliate->id,
            'phone' => 'required|digits:10'
        ]);
        if($request->hasFile('logo') && $request->file('logo')->isValid()){
            $image= $request->logo->hashname();
            $path = $request->logo->storeAs('assets/uploads', $image ,'public');
            $affiliate->logo= $image;
        }
        $affiliate->fill($validated);
        if (!$affiliate->isDirty()) {
            return back()->with('response', 'No changes detected.');
        }

        try{
            // Update model
            $affiliate->update($validated);   
            return back()->with('response', "Affiliate updated with ID#: ".$affiliate->id);       
        } catch(Exception $e){
            // echo "abc";
            return back()->with('response', $e->getMessage())->withInput();
        }
    }
    public function deactivate($id){
        $row = $this->Affiliate->find($id);
        if($row){
            $row->status = '0';
            $row->save();
            $this->response = "Affiliate deactivated successfully!";
        }else{
            $this->response = "Affiliate not found!";            
        }

        return back()->with('response', $this->response);

    }

    public function activate($id){
        $row = $this->Affiliate->find($id);
        if($row){
            $row->status = '1';
            $row->save();
            $this->response = "Affiliate activated successfully!";
        }else{
            $this->response = "Affiliate not found!";            
        }

        return back()->with('response', $this->response);

    }

    /* public function edit(Request $request){
        
    }
    */
}
