<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class ScanLog extends Model
{
protected $fillable = ['tag_id','ip','user_agent','scanned_at'];


public function tag(){ return $this->belongsTo(Tag::class); }
}