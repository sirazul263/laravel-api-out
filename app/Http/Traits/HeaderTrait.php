<?php
namespace App\Http\Traits;
trait HeaderTrait {
    public function headers() {
        // Headers 
        $headers= [
            'Accept' => 'application/json' ,
            'Content-Type'=>'application/json',
            'token'=>"tQQpFp78Okuq80DhR0xn7qqnwyKs4YMYlPAOIqAx"
        ];
        return $headers;
    }
}