<?php

namespace App\Http\Controllers;

use App\Models\MenuProducts;
use App\Models\Menus;
use Illuminate\Http\Request;

class MenuProductsController extends Controller
{
    /**
     * Display a listing of the resource grouped by Menu.
     */
    public function index()
    {
        $data = Menus::with('products')->get();
        return response()->json($data, 200);
    }

    /**
     * Store multiple product links.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'menu_id'     => 'required|exists:menus,id',
        'product_ids' => 'required|array',
        'product_ids.*' => 'exists:products,id'
    ]);

    $menu = \App\Models\Menus::find($validated['menu_id']);

    $menu->products()->sync($validated['product_ids']);

    return response()->json([
        'message' => 'Menu Product updated successfully',
        'data' => $menu->load('products')
    ], 201);
    }

    /**
     * Display a specific menu with its products nested.
     */
    public function show($id)
    {
        $menu = Menus::with('products')->find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu Product not found'], 404);
        }

        return response()->json($menu, 200);
    }

    /**
     * Update a single link in the pivot table.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'menu_id'    => 'sometimes|required|exists:menus,id',
            'product_id' => 'sometimes|required|exists:products,id',
        ]);

        $menuLink = MenuProducts::find($id);

        if (!$menuLink) {
            return response()->json(['message' => 'Link not found'], 404);
        }

        $menuLink->update($validated);
        return response()->json($menuLink, 200); 
    }

    /**
     * Remove a specific link.
     */
    public function destroy($id)
    {
        $menuproducts = MenuProducts::find($id);
        
        if ($menuproducts) {
            $menuproducts->delete();
            return response()->json(['message' => 'Deleted successfully'], 200);
        }

        return response()->json(['message' => 'Menu Product link not found'], 404);
    }
}