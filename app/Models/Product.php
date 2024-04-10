<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'image',
        'price',
        'color_id',
        'description',
        'multi_image',
        'measument_id',
        'weight'
    ];
    public function measurment()
    {
        return $this->belongsTo('App\Models\Measurment');
    }
    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }
}
