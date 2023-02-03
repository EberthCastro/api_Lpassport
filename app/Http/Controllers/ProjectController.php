<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $projects=Project::where('user_id', $user_id)->get();
        return  response($projects,201);
    }

    public function create(Request $request)
    {
        // $user_id
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'tech' => 'required',
            'cover' => 'required',
            'url_deploy' => 'required',
            'url_github' => 'required',
        ]);

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'tech' => $request->tech,
            'cover' => $request->cover,
            'url_deploy' => $request->url_deploy,
            'url_github' => $request->url_github,
            'user_id' => $request->user()->id
        ]);

        return response([
            'message' => 'Project created successfully'
        ],201);
    }

    public function show($id)
    {
        $project=Project::findOrFail($id);
        return response($project,201);
    }

    public function update(Request $request, $id)
    {
        $project=Project::findOrFail($id);
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'tech' => $request->tech,
            'cover' => $request->cover,
            'url_deploy' => $request->url_deploy,
            'url_github' => $request->url_github,
        ]);

        return response([
            'message'=>'Project updated successfully'
        ],201);

    }

    public function destroy($id)
    {
        $project=Project::where('id',$id)->delete();

        return response([
            'message'=>'Project deleted successfully'
        ],201);
    }

}