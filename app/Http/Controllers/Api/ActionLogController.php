<?php

namespace App\Http\Controllers\Api;

use App\Models\ActionLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionLogController extends Controller
{
    public function index(Request $request)
    {
       try {
            $request->validate([
                'search' => 'nullable|string|max:255',
            ]);

            $search = (string) $request->input('search', '');
            $actionLog = ActionLog::search($search)
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

            return response()->json(['actionLog'=> $actionLog],200);

       } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al obtener acción empleado.',
            'error' => $e->getMessage()
        ], 500);
    }
    }

   /*  public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'action' => 'required|string|max:255',
        ]);

        $log = ActionLog::create($validated);
        return response()->json($log, 201);
    } */
}
