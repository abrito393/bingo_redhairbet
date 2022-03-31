<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\configuracion;

class ConfiguracionController extends Controller
{

    public function index()
    {
        return view('admin.configuracion.index')->with('data',configuracion::first());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $data = [
            "segundos_espera" => (int)$request->segundos_espera,
        ];

        configuracion::first()->update($data);
        return redirect()->route('configuracion.index');
    }

    public function destroy($id)
    {
        //
    }
}
