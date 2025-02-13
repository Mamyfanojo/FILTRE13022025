<?php

namespace App\Http\Controllers;

use App\Models\Avurnav;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AvurnavController extends Controller
{
    public function index()
    {
        $avurnavs = Avurnav::all();
        return view('surveillance.avurnav.index', compact('avurnavs'));
    }
    public function create()
    {
        return view('surveillance.avurnav.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'avurnav_local' => 'required|string',
            'ile' => 'required|string',
            'vous_signale' => 'required|string',
            'position' => 'required|string',
            'navire' => 'required|string',
            'pob' => 'required|integer',
            'type' => 'required|string',
            'caracteristiques' => 'required|string',
            'zone' => 'required|string',
            'derniere_communication' => 'required|date',
            'contacts' => 'required|string',
        ]);

        // Enregistrement dans la base de données
        Avurnav::create($validatedData);

        return redirect()->route('avurnav.index')->with('success', 'Données enregistrées avec succès.');
    }
    public function exportPDF($id)
    {
        $avurnav = Avurnav::findOrFail($id);
        
        $pdf = Pdf::loadView('surveillance.avurnav.pdf', compact('avurnav'));

        return $pdf->download("AVURNAV_{$avurnav->id}.pdf");
    }
}