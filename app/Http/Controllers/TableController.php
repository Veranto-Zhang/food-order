<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    public function redirect($number)
    {
        session([
            'table_number' => $number,
            'table_scanned_at' => now(),
        ]);

        return redirect()->route('home');
    }
}
