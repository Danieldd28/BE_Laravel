<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Retrieve all users.
     */
    public function indexUsers()
    {
        $users = User::all(['id_user', 'nama_user', 'username', 'role', 'created_at', 'updated_at']);
        return response()->json(['users' => $users], 200);
    }

    /**
     * Create a new user.
     */
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'nama_user' => 'required|string|max:100',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,kasir,manajer',
        ]);

        $user = User::create([
            'nama_user' => $validated['nama_user'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json(['user' => $user], 201);
    }

    /**
     * Update an existing user.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama_user' => 'sometimes|required|string|max:100',
            'username' => 'sometimes|required|string|unique:users,username,' . $id . ',id_user',
            'password' => 'sometimes|required|string|min:6',
            'role' => 'sometimes|required|in:admin,kasir,manajer',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json(['user' => $user], 200);
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 204);
    }

    /**
     * List all menus.
     */
    public function indexMenu()
    {
        // Assuming you have a Menu model
        $menus = Menu::all();
        return response()->json(['menus' => $menus], 200);
    }

    /**
     * Create a new menu.
     */
    public function createMenu(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'jenis' => 'required|in:makanan,minuman',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|string', // Or 'image' if handling uploads
            'harga' => 'required|integer|min:0',
        ]);

        $menu = Menu::create($validated);

        return response()->json(['menu' => $menu], 201);
    }

    /**
     * Update an existing menu.
     */
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'nama_menu' => 'sometimes|required|string|max:255',
            'jenis' => 'sometimes|required|in:makanan,minuman',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|string', // Or 'image' if handling uploads
            'harga' => 'sometimes|required|integer|min:0',
        ]);

        $menu->update($validated);

        return response()->json(['menu' => $menu], 200);
    }
    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json(['message' => 'Menu deleted successfully.'], 204);
    }

    /**
     * List all tables.
     */
    public function indexTables()
    {
        $tables = Meja::all();
        return response()->json(['tables' => $tables], 200);
    }

    /**
     * Create a new table.
     */
    public function createTable(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|integer|unique:mejas,nomor_meja',
            'status' => 'required|in:available,occupied',
        ]);

        $table = Meja::create($validated);

        return response()->json(['table' => $table], 201);
    }

    /**
     * Update an existing table.
     */
    public function updateTable(Request $request, $id)
    {
        $table = Meja::findOrFail($id);

        $validated = $request->validate([
            'nomor_meja' => 'sometimes|required|integer|unique:mejas,nomor_meja,' . $id . ',id_meja',
            'status' => 'sometimes|required|in:available,occupied',
        ]);

        $table->update($validated);

        return response()->json(['table' => $table], 200);
    }

    /**
     * Delete a table.
     */
    public function deleteTable($id)
    {
        $table = Meja::findOrFail($id);
        $table->delete();

        return response()->json(['message' => 'Table deleted successfully.'], 204);
    }
}
