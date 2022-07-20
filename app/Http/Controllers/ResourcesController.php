<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResourcesController extends Controller
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
        return view('admin', [
            'resources' => $resources
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'resource_type' => ['required', Rule::in(['pdf', 'html', 'link'])],
            'title' => ['required'],
            'file' => ['nullable','required_if:resource_type,pdf','mimes:pdf'],
            'description' => ['required_if:resource_type,html'],
            'html' => ['required_if:resource_type,html'],
            'link' => ['required_if:resource_type,link'],
            'open_in_new_tab' => ['required_if:resource_type,link'],
        ]);
        $resource = new Resource();
        $resource->resource_type = $request->resource_type;
        $resource->title = $request->title;
        if ($request->resource_type === 'pdf') {
            $file = $request->file('file')->store('public');
            $resource->file_path = basename($file);
        }
        if ($request->resource_type === 'html') {
            $resource->description = $request->description;
            $resource->html = $request->html;
        }
        if ($request->resource_type === 'link') {
            $resource->link = $request->link;
            $resource->open_in_new_tab = $request->open_in_new_tab ? 1 : 0;
        }
        $resource->save();
        return response()->json($resource);

    }

    /**
     * Display the specified resource.
     *
     * @param Resource $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Resource $resource)
    {
        return response()->json($resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Resource $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'title' => ['required'],
            'file' => ['nullable', 'mimes:pdf'],
            'description' => ['required_if:resource_type,html'],
            'html' => ['required_if:resource_type,html'],
            'link' => ['required_if:resource_type,link'],
            'open_in_new_tab' => ['required_if:resource_type,link'],
        ]);
        $resource->title = $request->title;
        if ($resource->resource_type === 'pdf') {
            if ($request->hasFile('file')) {
                $file = $request->file('file')->store('public');
                $resource->file_path = basename($file);
            }
        }
        if ($resource->resource_type === 'html') {
            $resource->description = $request->description;
            $resource->html = $request->html;
        }
        if ($resource->resource_type === 'link') {
            $resource->link = $request->link;
            $resource->open_in_new_tab = $request->open_in_new_tab ? 1 : 0;
        }
        $resource->save();
        return response()->json($resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resource $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
