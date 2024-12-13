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
            $query->select('id', 'title', 'description', 'due_date', 'category_id')
                ->where('user_id', Auth::user()->id)
                ->orderBy('category_id', 'ASC');
        }])->get();

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
                        ];
                    })
                ];
            })
        ];

        return response()->json($result);



//        $tasks = Task::all();
//
//        // Formatar o created_at de cada categoria no padrão brasileiro
//        foreach($tasks as $task){
//            // Usar o Carbon para formatar a data no padrão brasileiro (d/m/Y H:i)
//            $task->dataLimite = date('d/m/Y H:i', strtotime($task->due_date));
//        }
//
//        return response()->json(
//            [
//                'message' => 'Listagem das tasks realizadas com sucesso.',
//                'tasks' => $tasks
//            ]
//        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
