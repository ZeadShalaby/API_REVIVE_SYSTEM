<?php
namespace App\Traits\validator;

use Exception;
use Validator;

trait ValidatorTrait

{  

    //todo check machine work or not 
    public function validate($request, array $rules, array $messages = [], array $attributes = []){

        // ! valditaion
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }

        return true;

    }

}