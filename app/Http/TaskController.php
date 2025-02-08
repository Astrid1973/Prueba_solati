<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;
use phpDocumentor\Reflection\Types\Nullable;

class TaskController extends Controller
{
    # lista todas las tareas
    public function listTask(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => 'Token invalido o expirado. Por favor, inicia sesion nuevamente.'
            ], 401);
        }

        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    # listas las tareas de un usuario
    public function listTaskByUser(Request $request, $id=null)
    {
        $user = $request->user();
         
        if (!$user) {
            return response()->json([
                'error' => 'Token invalido o expirado. Por favor, inicia sesion nuevamente.'
            ], 401);
        }
        
        $id = $id ?? $user->id;
        if ($user->id !== $id && !$user->is_admin) {
            return response()->json(['error' => 'No tienes permisos para ver estas tareas.'], 403);
        }
        $tasks = Task::where('user_id', $id)->get();
        return response()->json($tasks, 200);
    }

    # crea una nueva tarea
    public function createTask(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => 'Token invalido o expirado. Por favor, inicia sesion nuevamente.'
            ], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:user,id'
        ]);

        $task = Task::create($request->all());

        return response()->json(['message' => 'Tarea creada con éxito', 'task' => $task], 201);
    }

    # actualiza una tarea
    public function updateTask(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => 'Token invalido o expirado. Por favor, inicia sesion nuevamente.'
            ], 401);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status'      => 'sometimes|boolean'
        ]);

        $task->update($request->only(['title', 'description', 'status']));

        return response()->json(['message' => 'Tarea actualizada', 'task' => $task], 200);
    }

    public function updateStatusTask(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => 'Token invalido o expirado. Por favor, inicia sesion nuevamente.'
            ], 401);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $task->update([
            'status' => !$task->status
        ]);
        return response()->json(['message' => 'Estado de la tarea actualizado'], 200);
        }
    # elimina una tarea
    public function deleteTask(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'error' => 'Token invalido o expirado. Por favor, inicia sesion nuevamente.'
            ], 401);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Tarea eliminada'], 200);
    }

    /*=====================================
     Visualizar listado de tareas 
    =====================================
    */
    public function showTasks(Request $request)
{
    $user = $request->user();
    $tasks = Task::where('user_id', $user->id)->get();

    return view('tasks.index', compact('tasks'));
}
}
