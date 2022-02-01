<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;

class Order extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public function products()
    {
       return $this->hasMany(OrderProduct::class);
    }
}