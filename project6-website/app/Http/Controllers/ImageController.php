<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function fetchImagesFromApi()
    {
        $token = '19|RxAmlMsGtp7zu1oCDmW3YKLuMm5hkn6DtjJLLLsQ';
        
        $response = Http::get('https://kuin.summaict.nl/api/product'); 
        dd($response);
        
        if ($response->ok()) {
            $images = $response->json();
            
            // process the $images array here
            
            return view('comingsoon', ['images' => $images]);
        } else {
            // handle the error here
        }
    }
}
?>
