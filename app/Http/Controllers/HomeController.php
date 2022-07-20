<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $resources = Resource::orderBy('created_at', 'desc')
            ->get();
        return view('home', [
            'resources' => $resources
        ]);
    }


}
