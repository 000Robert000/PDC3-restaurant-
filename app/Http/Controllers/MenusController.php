<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Menus::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique|max:128',
        ]);

        $menu = Menus::create($validated);
        return response()->json($menu, 201);

        $menu = Menus::find($request->menu_id);
        $menu->products()->sync($request->product_ids);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $menu = Menus::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        return response()->json($menu, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'  => 'sometimes|required|string|max:128', 
        ]);
        
        $menu = Menus::find($id); 

        if ($menu) {
            $menu->update($validated); 
            return response()->json($menu, 200);
        }
        return response()->json(['message' => 'Menu not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) 
    {
        $menu = Menus::find($id);
    
        if ($menu) {
            $menu->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        }

        return response()->json(['message' => 'Menu not found'], 404);
    }

    
}