<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SliderImage extends Model
{
    use HasFactory;

    public function slider(): HasOne
    {
        return $this->hasOne(Slider::class);
    }
}
