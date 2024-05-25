<?php

namespace App\Http\Controllers;

use App\Models\Jagung;
use Illuminate\Http\Request;

class PrediksiController extends Controller
{
    public function index()
    {
        $title = 'Prediksi';
        return view('dashboard.prediksi.index')->with(compact('title')); //
    }

    public function getData()
    {
        // Mengambil semua data produk dari database
        $perPeriode = Jagung::select('priode', 'totalProduksi', 'areaLahan', 'areaPanen')
            ->orderBy('priode', 'asc')
            ->get();


        // Mengonversi data produk ke dalam format yang dapat digunakan oleh Python
        $jagungData = [];
        foreach ($perPeriode as $jagung) {
            $jagungData[] = [
                'Tahun' => $jagung->priode,
                'Produksi' => $jagung->totalProduksi,
                'Area_Lahan' => $jagung->areaLahan,
                'Area_Panen' => $jagung->areaPanen,
            ];
        }


        return response()->json($jagungData);
    }
}
