<?php

namespace App\Traits\Crypt;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

trait CryptTrait
{
   // todo Encrypted the key to use this apis
   protected function SecurityEncrypt($value)
   {
        $secret = Crypt::encryptString($value);
        return $secret;
   }

   // todo Decrypted the key to use this apis
   protected function SecurityDecrypt($encryptedValue)
   {
        try {
            $decrypted = Crypt::decryptString($encryptedValue);
        } catch (DecryptException $e) {
            return "oops Something wrongs :( ...!";
        }
        return $decrypted;
   }

}