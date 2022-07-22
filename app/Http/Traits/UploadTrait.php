<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait UploadTrait{

    private $location   = "/img/avatar/";  

    public function upload(Request $request,  $name = 'image', $location = null)
    {
        if ($location == null) {
            $location = $this->location;
        }

        if (!$request->hasFile($name) ) return null;
        $image = $request->file($name);       
        $image_name = $this->makeImageName($image);         
        $path = $location . $image_name;        
        $image->move(public_path($location),$image_name);
        return $path;
    } 

    public function deleteImage($path)
    {      
        $path = public_path() . $path;
        File::delete($path);        
    }

    private function makeImageName($image){
        $size = $image->getSize(); 
        $type = $image->getClientOriginalExtension();       
        return date('Y') . time() . $size . "." . $type;
    }

}
