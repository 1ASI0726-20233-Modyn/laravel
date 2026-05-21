<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCatalogueController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('q', ''));

        $query = DB::table('Products')
            ->select('PRO_id', 'PRO_name', 'PRO_description', 'PRO_price');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('PRO_id', 'LIKE', "%{$search}%")
                  ->orWhere('PRO_name', 'LIKE', "%{$search}%")
                  ->orWhere('PRO_description', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->orderBy('PRO_id')->get();
        $total    = $products->count();

        return view('catalogue.index', compact('products', 'search', 'total'));
    }
}
