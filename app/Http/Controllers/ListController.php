<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $list = Lists::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'List created successfully',
            'list' => $list,
        ], 201);
    }
    public function getLists()
    {
        $lists = Lists::where('user_id', auth()->id())->get();
 
        return response()->json([
            'lists' => $lists,
        ], 200);
    }
}
