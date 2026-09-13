<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   // ในไฟล์ app/Models/Customer.php
protected $fillable = [
    'customer_id', 'name', 'type', 'phone', 'contact_person',
    'address_number', 'address_building', 'address_street', 'address_subdistrict',
    'address_district', 'address_province', 'postal_code',
    'total_spent',
        'purchase_count',
        'is_wholesale'
    ];

    protected $casts = [
        'is_wholesale' => 'boolean'
    ];

    // ===============================
    // 🎯 Loyalty Logic
    // ===============================
    public function updateLoyalty($orderTotal)
    {
        // ลูกค้าทั่วไปไม่สะสม
        if ($this->type === 'ทั่วไป') {
            return;
        }

        //  สะสมเฉพาะ ร้านค้า / ช่าง
        $this->total_spent += $orderTotal;
        $this->purchase_count += 1;

        //  เงื่อนไขปลดล็อคราคาส่ง
        if (
            $this->total_spent >= 5000 &&
            $this->purchase_count >= 5
        ) {
            $this->is_wholesale = true;
        }

        $this->save();
    }

    // ===============================
    //  เช็คว่าใช้ราคาส่งได้ไหม
    // ===============================
    public function canUseWholesale()
    {
        return in_array($this->type, ['ร้านค้า', 'ช่าง']) && $this->is_wholesale;
    }


}
