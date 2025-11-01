<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\ScanLog;

class PublicTagController extends Controller
{
  public function show($code)
{
    $tag = \App\Models\Tag::where('tag_code', $code)->firstOrFail();

    // Log scan
    \App\Models\ScanLog::create([
        'tag_id' => $tag->id,
        'ip' => request()->ip(),
        'user_agent' => request()->header('User-Agent'),
    ]);

    // Get pet relation properly
    $pet = $tag->pet; // This gets the related pet model

    return view('tags.public', compact('tag', 'pet'));
}
public function scanHistory($code)
{
    $tag = Tag::where('tag_code', $code)->firstOrFail();
    $logs = \App\Models\ScanLog::where('tag_id', $tag->id)
                ->latest()
                ->take(20)
                ->get();

    return view('history', compact('tag', 'logs'));
}


}
