<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
protected $fillable = ['tag_code', 'user_id', 'pet_id', 'active'];


public function pet(){ return $this->belongsTo(Pet::class); }
public function user(){ return $this->belongsTo(User::class); }

}