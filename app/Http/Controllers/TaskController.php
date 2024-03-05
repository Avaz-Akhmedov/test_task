<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $status = $request->input('status');
        $date = $request->input('date');

        $tasks = Task::query()
            ->with('category')
            ->latest()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($date, function ($query) use ($date) {
                $query->whereDate('created_at', Carbon::parse($date));
            })
            ->paginate(20);

        return TaskResource::collection($tasks);
    }

    public function show(Task $task): TaskResource
    {
        return TaskResource::make($task);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::query()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'status' => 'incomplete',
        ]);

        return response()->json([
            'success' => true,
            'task' => TaskResource::make($task)
        ], 201);
    }

    public function update(Task $task, StoreTaskRequest $request): JsonResponse
    {
        $task->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'success' => true,
            'task' => TaskResource::make($task->refresh())
        ]);
    }

    public function destroy(Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}
