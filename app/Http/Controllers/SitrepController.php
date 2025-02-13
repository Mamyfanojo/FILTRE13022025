<?php

namespace App\Http\Controllers;

use App\Models\Sitrep;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class SitrepController extends Controller
{
    public function index()
    {
        $sitreps = Sitrep::all();
        return view('surveillance.sitreps.index', compact('sitreps'));
    }

    public function create()
    {
        return view('surveillance.sitreps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sitrep_sar' => 'required|string',
            'mrcc_madagascar' => 'required|string',
            'event' => 'required|string',
            'position' => 'required|string',
            'situation' => 'required|string',
            'number_of_persons' => 'required|string',
            'assistance_required' => 'required|string',
            'coordinating_rcc' => 'required|string',
            'initial_action_taken' => 'required|string',
            'chronology' => 'required|string',
            'additional_information' => 'nullable|string',
        ]);

        Sitrep::create($request->all());
        return redirect()->route('sitreps.index')->with('success', 'SITREP ajouté avec succès.');
    }

    public function show(Sitrep $sitrep)
    {
        return view('sitreps.show', compact('sitrep'));
    }

    public function edit(Sitrep $sitrep)
    {
        return view('surveillance.sitreps.edit', compact('sitrep'));
    }

    public function update(Request $request, Sitrep $sitrep)
    {
        $request->validate([
            'sitrep_sar' => 'required|string',
            'mrcc_madagascar' => 'required|string',
            'event' => 'required|string',
            'position' => 'required|string',
            'situation' => 'required|string',
            'number_of_persons' => 'required|string',
            'assistance_required' => 'required|string',
            'coordinating_rcc' => 'required|string',
            'initial_action_taken' => 'required|string',
            'chronology' => 'required|string',
            'additional_information' => 'nullable|string',
        ]);

        $sitrep->update($request->all());
        return redirect()->route('sitreps.index')->with('success', 'SITREP mis à jour avec succès.');
    }

    public function destroy(Sitrep $sitrep)
    {
        $sitrep->delete();
        return redirect()->route('sitreps.index')->with('success', 'SITREP supprimé avec succès.');
    }

    public function exportPDF($id)
    {
        $sitrep = Sitrep::findOrFail($id);
        $pdf = Pdf::loadView('surveillance.sitreps.pdf', compact('sitrep'));
        return $pdf->download('sitrep_'.$id.'.pdf');
    }

    

   
}
