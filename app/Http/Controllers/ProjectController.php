<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChecklistRequest;
use App\Http\Requests\StorePrivateProjectRequest;
use App\Http\Requests\StoreSubChecklistRequest;
use App\Models\Checklist;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index() {
        $authUser = auth()->user();
        $user = User::find($authUser->id);
        $projects = $user->projects()->with('checklists')->get();
        // count completed checklists
        // projects have many checklists
        // completed checklist are checklists that have all it's subchecklist's is_completed = true
        $projects->map(function ($project) {
            $project->completed_checklists = $project->checklists->filter(function ($checklist) {
                return $checklist->subChecklists->count() === $checklist->subChecklists->where('is_completed', true)->count();
            })->count();
            return $project;
        });

        return response()->json([
            'data' => $projects
        ]);
    }

    public function storePrivate(StorePrivateProjectRequest $request): JsonResponse {
        $authUser = auth()->user();
        $request->merge([
            'user_id' => $authUser->id,
            'team_id' => null
        ]);
        $user = User::find($authUser->id);
        $project = $user->projects()->create($request->all());

        return response()->json([
            'data' => $project
        ], 201);
    }

    // add new checklist
    public function addChecklist(StoreChecklistRequest $request) {
        $project = Project::find($request->project_id);
        $project->checklists()->create($request->all());

        return response()->json([
            'message' => 'Checklist created'
        ], 201);
    }

    // add new sub-checklist
    public function addSubChecklist(StoreSubChecklistRequest $request) {
        $checklist = Checklist::find($request->checklist_id);
        $checklist->subChecklists()->create($request->all());

        return response()->json([
            'message' => 'Sub-checklist created'
        ], 201);
    }

    public function detail($id) {
        $authUser = auth()->user();
        $users = User::find($authUser->id);

        $project = $users->projects()
            ->with('checklists')
            ->with('checklists.subChecklists')
            ->with('notes')->where('id', $id)
            ->first();

        // count completed checklists
        // projects have many checklists
        // completed checklist are checklists that have all it's subchecklist's is_completed = true
        $project->completed_checklists = $project->checklists->filter(function ($checklist) {
            return $checklist->subChecklists->count() === $checklist->subChecklists->where('is_completed', true)->count();
        })->count();

        // count completed subchecklists
        // for each checklist add count completed subchecklist
        for ($i = 0; $i < $project->checklists->count(); $i++) {
            $project->checklists[$i]->completed_subchecklists = $project->checklists[$i]->subChecklists->where('is_completed', true)->count();
        }

        return response()->json([
            'data' => $project
        ]);
    }

    public function updateDeskripsiProject(Request $request, int $id) {
        $authUser = auth()->user();
        $user = User::find($authUser->id);
        $project = $user->projects()->find($id);
        $project->update([
            'deskripsi' => $request->deskripsi
        ]);
        return response()->json([
            'data' => $project
        ]);
    }
}
