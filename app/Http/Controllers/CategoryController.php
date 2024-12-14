<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($fields);

        if (!$category) {
            return [
                'message' => 'Erro ao criar categoria.'
            ];
        }

        return response()->json(
            [
                'message' => 'Categoria criada com sucesso.',
                'category' => $category,
            ]
        );
    }

    public function index()
    {
        $categories = Category::all();

        // Formatar o created_at de cada categoria no padrão brasileiro
        foreach($categories as $category){
            // Usar o Carbon para formatar a data no padrão brasileiro (d/m/Y H:i)
            $category->criadoEm = date('d/m/Y H:i', strtotime($category->created_at));
        }

        return response()->json(
            [
                'message' => 'Listagem das categorias feita com sucesso.',
                'categories' => $categories
            ]
        );
    }

    public function countTasksForCategory()
    {
        // Buscar todas as categorias e contar as tarefas associadas a cada uma
        $categories = Category::withCount('task')->get();

        // Retornar os dados das categorias com o número de tarefas
        return response()->json($categories);
    }
}
