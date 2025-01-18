<?php 

namespace App\Http\Traits;

trait ApiResponseTrait 
{
    public function api_Response($data,$token,$message,$status){
        $array = [
            'data'=>$data,
            'message'=>$message,
            'access_token'=>$token,
            'token_type'=>'bearer',
        ];

        return response()->json($array,$status);
    }

    //========================================================================================================================
    
    public function failed_Response($message,$status){
        $array = [
            'message'=>$message,
        ];
        return response()->json($array,$status);
    }
    //========================================================================================================================
    public function success_Response($data,$message,$status){
        $array = [
            'data'          => $data,
            'message'       => $message,
        ];
        
        return response()->json($array,$status);
    }
    
}