<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
class CoffeeSalesController extends Controller
{
    // coffee sales page
    // Added By Harish Bommena
    public function index(){
        return view('coffee_sales');
    }

    // Fetching all coffee sales records from database
    // Added By Harish Bommena
    public function salesList(){
        $list = \App\Models\CoffeeSales::select('product','quantity','unit_cost','selling_price','created_at')->get();
        $listData['data'] = [];
        if(@count($list) > 0){
            foreach($list as $lis){
                $lis->product = str_replace('-',' ',$lis->product);
                $lis->product = ucfirst($lis->product);
                $lis->sold_on = date('Y-m-d H:i:s',strtotime($lis->created_at));
                $lis->unit_cost = '£'.$lis->unit_cost;
                $lis->selling_price = '£'.$lis->selling_price;
                $listData['data'][] = $lis;
            }
        }
        $listData['total'] = count($listData['data']);
        return json_encode($listData); exit();
    }
    // Saving the coffee sales records into database
    // Added By Harish Bommena
    public function salesPost(Request $request){
        
        $input = $request->only('product','quantity','unit_cost');
        $margin = 0;
        $rules = [
            'product' => 'required',
            'quantity'=>'required|numeric',
            'unit_cost' => 'required|numeric'
        ];

        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {    
            return response()->json(['success'=>false, 'msg'=>$validator->messages()], 500);;
        }
        try{
            if($request->product == 'gold-coffee'){
                $margin = 0.25;
            }elseif($request->product == 'arabic-coffee'){
               $margin = 0.15; 
            }
            $unitCost = (int)$request->unit_cost*(int)$request->quantity;
            $input['selling_price'] = round(($unitCost/(1 - $margin))+10,2);
            $input['profile_margin'] = $margin;
            $input['shipping_cost'] = 10;
            $input['created_by'] = auth()->user()->id;
            $data = \App\Models\CoffeeSales::create($input);

            if($data){
                return response()->json(['success'=>true,'msg'=>'Record has been added.']);
            }else{
                return response()->json(['success'=>false,'msg'=>'Something went wrong.']);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false,'msg'=>$e->getMessage()],500);
        }
        
    }
}
