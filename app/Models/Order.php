<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;



class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'address', 'phone', 'payment_type', 'total', 'sgst', 'cgst', 'delivery','status' ,'grand_total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function isWithinReturnWindow()
    {
        $orderCompletionTime = $this->updated_at;  // assuming 'updated_at' holds the completion time
        return Carbon::now()->diffInHours($orderCompletionTime) <= 48;
    }
    
   
    
}
