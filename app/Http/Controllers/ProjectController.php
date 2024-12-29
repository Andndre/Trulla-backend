<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrivateProjectRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index() {
        $user = auth()->user();
        $projects = $user->projects;

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
}
