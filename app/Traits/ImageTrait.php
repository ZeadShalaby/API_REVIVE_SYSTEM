<?php

namespace App\Traits;

use App\Models\Role;


trait ImageTrait

{   // save image 
   public function saveimage($image , $folder)
   {
      $image_name = time().'.'.$image->extension();
      $images = $image->move(public_path($folder),$image_name) ;
      $destination_path = '/api/rev/images/reviveimageposts/';
      $http_address = env('APP_URL');
      $path = $http_address.$destination_path.$image_name;

    return $path;
   }
}


