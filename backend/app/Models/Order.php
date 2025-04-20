<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'menu_order')->withPivot('quantity')->withTimestamps();
    }
}
