<?php

namespace App\Http\Controllers;

use App\Http\Traits\HeaderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
  use HeaderTrait;
   //constructor
   private $headers;
   private $url ;
   public function __construct(){
       $this->headers= $this->headers();
       $this->url =env('API_URL',null);
     }
   //Ticket
   public function ticket(Request $request){
       if($request->ismethod('post')){
           $data = $request->all();
           //Validation
           $rules= [
            'booking_id'=>'required',
            'payment_type'=>'required',
        ];
        $customMessage=[
            'booking_id.required'=>'Booking Id is required', 
            'payment_type.required'=>'Payment Type is required',
        ];
        $validator = Validator::make($data, $rules, $customMessage);
        if($validator->fails()){
               return response()->json( [
                   'status' => 0,
                   'errors'=>$validator->errors()
               ], 422);
        }
        $response = Http::withHeaders($this->headers)->post($this->url."/flight/v1/ticket", $data);
        return response()->json($response->json(), $response->status());
      }
   }
}
