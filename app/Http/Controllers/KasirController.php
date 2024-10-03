<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Meja;
use App\Models\Menu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;



class KasirController extends Controller
{
    /**
     * Create a new transaksi (transaction).
     */
    public function createTransaksi(Request $request)
    {
        // Log the input or errors for debugging
        Log::info($request->all());
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'id_meja' => 'required|exists:mejas,id_meja',
            'id_user' => 'required|exists:users,id_user',
            'status' => 'required|in:belum_bayar,lunas',
            'items' => 'required|array|min:1',
            'items.*.id_menu' => 'required|exists:menus,id_menu',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|integer|min:0',
        ]);

        // Create Transaksi
        $transaksi = Transaksi::create([
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'id_meja' => $validated['id_meja'],
            'id_user' => $validated['id_user'],
            'status' => $validated['status'],
            'tgl_transaksi' => now(), // Assuming you have a timestamp
        ]);

        // Create DetailTransaksi
        foreach ($validated['items'] as $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_menu' => $item['id_menu'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
            ]);
        }

        // Load relationships
        $transaksi->load('detailTransaksis.menu', 'meja', 'user');

        return response()->json(['transaksi' => $transaksi], 201);
    }

    /**
     * List all transaksis for kasir.
     */
    public function indexTransaksis()
    {
        $transaksis = Transaksi::with('detailTransaksis.menu', 'meja', 'user')->get();
        return response()->json(['transaksis' => $transaksis], 200);
    }

    /**
     * Get menu items for ordering.
     */
    public function getMenu()
    {
        $menus = Menu::all();
        return response()->json(['menus' => $menus], 200);
    }
    public function getMeja()
    {
        // Retrieve only available tables
        $mejas = Meja::where('status', 'available')->get();
        return response()->json(['mejas' => $mejas], 200);
    }


    /**
     * Print transaksi as PDF receipt.
     */
    public function printTransaksi($id)
    {
        $transaksi = Transaksi::with('detailTransaksis.menu', 'meja', 'user')->findOrFail($id);

        // Ensure you have a Blade view file that formats the PDF correctly
        $pdf = PDF::loadView('receipts.transaksi', compact('transaksi'));

        // Download the generated PDF
        return $pdf->download('transaksi_' . $transaksi->id_transaksi . '.pdf');
    }


}
