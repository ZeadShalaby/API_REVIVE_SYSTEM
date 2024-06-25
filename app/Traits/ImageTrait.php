<?php

namespace App\Traits;

use App\Models\Role;


trait ImageTrait

{   // save image 
   public function saveimage($image , $folder ,$path)
   {
      $image_name = time().'.'.$image->extension();
      $images = $image->move(public_path($folder),$image_name) ;
      $destination_path = "/api/rev/images/$path/";
      $http_address = env('APP_URL');
      $path = $destination_path.$image_name;

    return $path;
   }

   // todo return image users I Want it
   public function returnimageusers($key , $value , $msg = "" )
   {
      return response()->download(public_path('images/users/'.$value));
   }

   // todo return image filemachine data training I Want it
   public function returnimagemachineD($key , $value , $msg = "")
   {
      return response()->download(public_path('images/machine/data/'.$value),$key);
   }

   // todo return image filemachine factory training I Want it
   public function returnimagemachineF($key , $value , $msg = "")
   {
      return response()->download(public_path('images/machine/factory/'.$value),$key);
   }

   // todo return image filemachine person training  I Want it
   public function returnimagemachineP($key , $value , $msg = "")
   {
      return response()->download(public_path('images/machine/person/'.$value),$key);
   }

   // todo return image filemachine I Want it
   public function returnimageposts($key , $value , $msg = "" )
   {
      return response()->download(public_path('images/posts/'.$value),$key);
   }

   // todo return random photo to register it 
   public function random($array,$funreturn)
   {
      $ran = $array;
      $randomElement = $ran[array_rand($ran, 1)];
      $destination_path = "/api/rev/images/$funreturn/";
      $http_address = env('APP_URL','http://127.0.0.1:8000');
      $path = $destination_path.$randomElement;
      return $path ;
   }
}





