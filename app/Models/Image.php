<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $gaurded = [];

    public function getImageStringAttribute()
    {
        $type = pathinfo($this->image, PATHINFO_EXTENSION);
        $data = file_get_contents($this->image);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        return $base64;
    }

}
