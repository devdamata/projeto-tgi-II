<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['task' => function ($query) {
            $query->select('id', 'title', 'description', 'due_date', 'category_id', 'priority')
                ->where('user_id', Auth::user()->id)
                ->orderBy('priority', 'ASC'); // Ordena as tarefas por prioridade dentro de cada categoria
        }])
            ->orderBy('id', 'ASC') // Ordena as categorias por ordem de criação (ou outra lógica desejada)
            ->get();

        $result = [
            'category' => $categories->map(function ($category) {
                return [
                    'nameCategory' => $category->name,
                    'task' => $category->task->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'title' => $task->title,
                            'description' => $task->description,
                            'due_date' => $task->due_date,
                            'priority' => $task->priority, // Inclui a prioridade no resultado, se necessário
                        ];
                    }),
                ];
            }),
        ];

        return response()->json($result);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required'
        ]);

        // Criação da tarefa
        $task = Task::create([
            'user_id' => auth()->user()->id,
            'category_id' => $validatedData['category_id'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'priority' => $validatedData['priority'],
        ]);

        // Retornar resposta ou redirecionamento
        return response()->json([
            'message' => 'Task created successfully!',
            'task' => $task,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
