<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChecklistRequest;
use App\Http\Requests\StorePrivateProjectRequest;
use App\Http\Requests\StoreSubChecklistRequest;
use App\Models\Checklist;
use App\Models\Project;
use App\Models\SubChecklist;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        $user = User::find($authUser->id);
        $projects = $user->projects()->with('checklists')->with('checklists.subChecklists')->get();

        return response()->json([
            'data' => $projects,
        ]);
    }

    public function storePrivate(StorePrivateProjectRequest $request): JsonResponse
    {
        $authUser = auth()->user();
        $request->merge([
            'user_id' => $authUser->id,
            'team_id' => null,
        ]);
        $user = User::find($authUser->id);
        $project = $user->projects()->create($request->all());

        return response()->json(
            [
                'data' => $project,
            ],
            201,
        );
    }

    // add new checklist
    public function addChecklist(Request $request, int $id)
    {
        $request->validate([
            'judul' => 'required|string',
        ]);
        $project = Project::find($id);
        $chekbox = $project->checklists()->create($request->all());

        return response()->json(
            [
                'data' => $chekbox,
            ],
            201,
        );
    }

    // add new sub-checklist
    public function addSubChecklist(StoreSubChecklistRequest $request)
    {
        $checklist = Checklist::find($request->checklist_id);
        $checklist->subChecklists()->create($request->all());

        return response()->json(
            [
                'message' => 'Sub-checklist created',
            ],
            201,
        );
    }

    public function detail($id)
    {
        $authUser = auth()->user();
        $users = User::find($authUser->id);

        $project = $users->projects()->with('checklists')->with('checklists.subChecklists')->with('notes')->where('id', $id)->first();

        return response()->json([
            'data' => $project,
        ]);
    }

    public function updateDeskripsiProject(Request $request, int $id)
    {
        $authUser = auth()->user();
        $user = User::find($authUser->id);
        $project = $user->projects()->find($id);
        $project->update([
            'deskripsi' => $request->deskripsi,
        ]);
        return response()->json([
            'data' => $project,
        ]);
    }

    public function updateDeadlineProject(Request $request, int $id)
    {
        $authUser = auth()->user();
        $user = User::find($authUser->id);
        $project = $user->projects()->find($id);
        $project->update([
            'deadline' => $request->deadline,
        ]);
        return response()->json([
            'data' => $project,
        ]);
    }

    public function updateSubChecklist(Request $request, int $id)
    {
        $subChecklist = SubChecklist::find($id);
        $subChecklist->update([
            'completed' => $request->status,
        ]);
        return response()->json([
            'data' => $subChecklist,
        ]);
    }
}
