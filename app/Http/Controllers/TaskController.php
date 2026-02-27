<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * GET /api/tasks
     * Lista todas as tarefas
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($tasks);
    }

    /**
     * POST /api/tasks
     * Cria uma nova tarefa
     */
    public function store(StoreTaskRequest $request): JsonResponse
     {
        try {
            $task = Task::create($request->validated());
            return response()->json($task, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar criar a tarefa.',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    /**
     * GET /api/tasks/{task}
     * Exibe os detalhes de uma tarefa específica
     */
    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }

    /**
     * PUT /api/tasks/{task}
     * Atualiza uma tarefa específica se ela existir
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            $task->update($request->validated());
            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar atualizar a tarefa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/tasks/{task}
     * Remove a tarefa específica se ela existir
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar deletar a tarefa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
