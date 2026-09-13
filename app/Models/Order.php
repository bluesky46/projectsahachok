<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
// {
//     use HasFactory;

//     protected $fillable = ['total_price']; // ฟิลด์ที่บันทึกใน Order
// }
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'status',
        'customer_phone',
        'is_delivery',
        'delivery_image',
    ];

    // public function items()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }
    // public function orderDetails()
    // {
    // return $this->hasMany(OrderDetail::class, 'orders_id');
    // }
    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class, 'orders_id');
}


    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_phone', 'phone');
    // สมมติว่าคุณเชื่อมด้วยเบอร์โทร 'phone'
    // ถ้า Order มี customer_id ก็เปลี่ยนเป็น:
    // return $this->belongsTo(Customer::class, 'customer_id');
}



}
