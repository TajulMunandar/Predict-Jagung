<?php

namespace App\Http\Controllers;

use App\Models\Jagung;
use Illuminate\Http\Request;

class PrediksiController extends Controller
{
    public function index()
    {
        $title = 'Data Prediksi';
        return view('dashboard.prediksi.index')->with(compact('title')); //
    }

    public function getData()
    {
        // Mengambil semua data produk dari database
        $perPeriode = Jagung::selectRaw('priode, SUM(totalProduksi) as totalProduksiPerPeriode, SUM(areaLahan) as totalLahanPerPeriode, SUM(areaPanen) as totalPanenPerPeriode')
            ->groupBy('priode')
            ->get();

        // Mengonversi data produk ke dalam format yang dapat digunakan oleh Python
        $jagungData = [];
        foreach ($perPeriode as $jagung) {
            $jagungData[] = [
                'Produksi' => $jagung->totalProduksiPerPeriode,
                'Area_Lahan' => $jagung->totalLahanPerPeriode,
                'Area_Panen' => $jagung->totalPanenPerPeriode,
            ];
        }

        return response()->json($jagungData);
    }
}
