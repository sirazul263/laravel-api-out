<?php

namespace App\Http\Controllers;

use App\Http\Traits\HeaderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller
{
    use HeaderTrait;
    //constructor
    private $headers;
    private $url ;
    public function __construct(){
        $this->headers= $this->headers();
        $this->url =env('API_URL',null);
      }
    //Price 
    public function price(Request $request){
        $query = $request->query();
        if($request->ismethod('get')){
            //Search id
            if(!isset($query['searchId'])){
                return response()->json(['status'=>0, 'message'=>'Search Id is required'], 422);
            }
            //Index
            if(!isset($query['index'])){
                return response()->json(['status'=>0, 'message'=>'Index number  is required'], 422);
            }
            $reqBody =[
                'searchId'=>$query['searchId'],
                'index'=>$query['index'],
            ];
            $response = Http::withHeaders($this->headers)->get($this->url."/flight/v1/price", $reqBody);
            return response()->json($response->json(), $response->status());
       }
    }

     //Save traveler
     public function saveTraveler(Request $request){
        if($request->ismethod('put')){
            $data = $request->all();
            //Validation
            $rules= ['searchId'=>'required', 
                     'email'=>'required|email|',
                     'phonePrefix'=>'required|min:2',
                     'phone'=>'required|max:10',
                     'countryCode'=>'required',
                     'travelers'=>'required'

            ];
            $customMessage=[
                     'searchId.required'=>'Search Id is required', 
                     'email.required'=>'Email is required', 
                     'email.email'=>'Email must be valid email', 
                     'phonePrefix'=>'Phone prefix is required',
                     'phone'=>'Phone is required',
                     'countryCode'=>'Country Code is required',
                     'travelers'=>'Travelers is required'
            ];
            $validator = Validator::make($data, $rules, $customMessage);
            if($validator->fails()){
                return response()->json( [
                    'status' => 0,
                    'errors'=>$validator->errors()
                ], 422);
            }
             $response = Http::withHeaders($this->headers)->put($this->url."/flight/v1/save-travelers", $data);
             return response()->json($response->json(), $response->status());
       }
    }
}
