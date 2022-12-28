<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'from', 'to', 'message'
    ];
    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
    public function toContact()
    {
        return $this->hasOne(User::class, 'id', 'to');
    }
}
