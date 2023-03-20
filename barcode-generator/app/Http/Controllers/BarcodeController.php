<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{
    public function generateBarcodes()
    {
        $rows = DB::table('response')->get();

        foreach ($rows as $row) {
            $barcode = DNS1D::getBarcodeHTML($row->id, "C39", 1, 50);
            DB::table('response')->where('id', $row->id)->update(['barcodes' => $barcode]);
        }

        return 'Barcodes generated successfully';
    }
}