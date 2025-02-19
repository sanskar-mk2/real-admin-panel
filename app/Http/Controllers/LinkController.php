<?php

namespace App\Http\Controllers;

use App\Models\Link;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('links.index', compact('links'));
    }
}
