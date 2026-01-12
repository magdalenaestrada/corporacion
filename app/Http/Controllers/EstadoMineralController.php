<?php

namespace App\Http\Controllers;

use App\Models\EstadoMineral;
use Illuminate\Http\Request;

class EstadoMineralController extends Controller
{
    public function index()
    {
        $estados = EstadoMineral::orderBy('nombre')->paginate(20);
        return view('estados_mineral.index', compact('estados'));
    }

    public function create()
    {
        return view('estados_mineral.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:estados_mineral,nombre',
        ]);

        EstadoMineral::create([
            'nombre' => strtoupper($request->nombre),
            'activo' => true,
        ]);

        return redirect()->route('estados_mineral.index')
            ->with('success', 'Estado creado correctamente');
    }

    public function edit(EstadoMineral $estados_mineral)
    {
        return view('estados_mineral.edit', compact('estados_mineral'));
    }

    public function update(Request $request, EstadoMineral $estados_mineral)
    {
        $request->validate([
            'nombre' => 'required|unique:estados_mineral,nombre,' . $estados_mineral->id,
        ]);

        $estados_mineral->update([
            'nombre' => strtoupper($request->nombre),
            'activo' => $request->activo,
        ]);

        return redirect()->route('estados_mineral.index')
            ->with('success', 'Estado actualizado');
    }
}
