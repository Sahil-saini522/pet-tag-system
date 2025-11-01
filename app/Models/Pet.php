<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'breed',
        'photo',
        'medical_info',
        'address',
        'emergency_contact',
        'user_id',
        'owner_name',
        'contact_email',
        'contact_phone',
    ];

    // Each pet has one tag (Tag stores pet_id)
    public function tag()
    {
        return $this->hasOne(Tag::class, 'pet_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
