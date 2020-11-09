<?php

namespace App\Traits;

trait Utils {

   protected function tokenExp( $isAdmin=false) {
        return !$isAdmin?env('JWT_TTL', 60):null;
   }
}