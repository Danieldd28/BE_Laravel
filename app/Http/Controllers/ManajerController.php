<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class ManajerController extends Controller
{
    /**
     * View all transaksis.
     */
    public function indexTransaksis()
    {
        $transaksis = Transaksi::with('detailTransaksis.menu', 'meja', 'user')->get();
        return response()->json(['transaksis' => $transaksis], 200);
    }


    /**
     * Filter transaksis by date range.
     */
    public function filterTransaksis(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $transaksis = Transaksi::whereBetween('tgl_transaksi', [$validated['start_date'], $validated['end_date']])
        ->with('detailTransaksis.menu', 'meja', 'user')
        ->get();


        return response()->json(['transaksis' => $transaksis], 200);
    }


    /**
     * Show specific transaksi details.
     */
    public function showTransaksi($id)
    {
        $transaksi = Transaksi::with('detailTransaksis.menu', 'meja', 'user')->findOrFail($id);
        return response()->json(['transaksi' => $transaksi], 200);
    }
}
