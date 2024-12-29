<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChecklistRequest;
use App\Http\Requests\StorePrivateProjectRequest;
use App\Http\Requests\StoreSubChecklistRequest;
use App\Models\Checklist;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index() {
        $authUser = auth()->user();
        $user = User::find($authUser->id);
        $projects = $user->projects()->with('checklists')->get();

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
    public function addChecklist(StoreChecklistRequest $request, int $id) {
        $project = Project::find($id);
        $project->checklists()->create($request->all());

        return response()->json([
            'message' => 'Checklist created'
        ], 201);
    }

    // add new sub-checklist
    public function addSubChecklist(StoreSubChecklistRequest $request, int $id) {
        $checklist = Checklist::find($id);
        $checklist->subChecklists()->create($request->all());

        return response()->json([
            'message' => 'Sub-checklist created'
        ], 201);
    }
}
