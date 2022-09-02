<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request) {
        $tel = $request->post('telephone');

        return redirect(route('profile', $tel));
    }
}
