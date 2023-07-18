<?php

namespace App\Http\Controllers;

use App\Http\Traits\HeaderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{    
    use HeaderTrait;
    //constructor
    private $headers;
    private $url ;
    public function __construct(){
        $this->headers= $this->headers();
        $this->url =env('API_URL',null);
    }
    //Search
    public function search (Request $request){
     $query = $request->query();
     if($request->ismethod('get')){
        //Trip Type validation
        if(!isset($query['tripType'] )){
             return response()->json(['status'=>0, 'message'=>'Trip type is required'], 422);
         }
         if($query['tripType'] !="O" && $query['tripType']  !="R" && $query['tripType'] !="M"){
            return response()->json(['status'=>0, 'message'=>'Invalid trip type'], 422);
         }
       //Pax Type validation
         if(!isset($query['paxType'])){
            return response()->json(['status'=>0, 'message'=>'Pax type is required'], 422);
        }
        if(!str_contains($query['paxType'],"ADT") ||  !str_contains($query['paxType'],"CHD") || !str_contains($query['paxType'],"INF") ){
           return response()->json(['status'=>0, 'message'=>'Invalid pax type'], 422);
        }

        //Cabin Class validation
        if(!isset($query['cabinClass'])){
            return response()->json(['status'=>0, 'message'=>'Cabin Class is required'], 422);
        }
        if($query['cabinClass'] !="economy" && $query['cabinClass'] !="first" && $query['cabinClass']!="business" && $query['cabinClass']!="premiumeconomy") {
            return response()->json(['status'=>0, 'message'=>'Invalid Cabin Class'], 422);
         }
        //Itinerary validation

        if(!isset($query['itinerary'])){
            return response()->json(['status'=>0, 'message'=>'Itinerary is required'], 422);
        }
        if( count(explode('-',$query['itinerary'])) < 3) {
            return response()->json(['status'=>0, 'message'=>'Invalid Itinerary'], 422);
        }

        //passenger object
        $passengers = [
            'adult'=> explode("-",explode("_",$query['paxType'])[0])[1],
            'child'=> explode("-",explode("_",$query['paxType'])[1])[1],
            'infant'=>explode("-",explode("_",$query['paxType'])[2])[1],
        ];

        //Itinerary array
        $itineraryArray = explode("_",$query['itinerary']); //
        $itinerary = [];
        foreach ($itineraryArray as $segment) {
        $temp= [
          'departure'=> explode("-",$segment)[0],
          'arrival'=> explode("-",$segment)[1],
          'date'=> explode("-",$segment)[2]
        ];
          array_push($itinerary, $temp);
        }
        $reqBody =[
            'tripType'=>$query['tripType'],
            'cabin'=>$query['cabinClass'],
            'itinerary' => $itinerary,
            'passengers'=>$passengers,
        ];
         //Headers
          $response = Http::withHeaders($this->headers)->get($this->url."/flight/v1/search", $reqBody);
          return response()->json($response->json(), $response->status());
    }
  }
  

  //fare rules
  public function getFareRules(Request $request){
    $query = $request->query();
    if($request->ismethod('get')){
        //Search id
        if(empty($query['searchId'])){
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
        $response = Http::withHeaders($this->headers)->get($this->url."/flight/v1/fare-rules", $reqBody);
        return response()->json($response->json(), $response->status());
    }
  }
}
