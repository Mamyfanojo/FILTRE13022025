<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\zone_1;
use App\Models\zone_2;
use App\Models\zone_3;
use App\Models\zone_4;
use App\Models\zone_5;
use App\Models\zone_6;
use App\Models\zone_7;
use App\Models\zone_8;
use App\Models\zone_9;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Imports\ZoneImport;

class ZoneController extends Controller
{
    public function show($id)
    {
        $model = "App\Models\zone_{$id}";
        
        if (class_exists($model)) {
            return view('zone.index', ['articles' => $model::paginate(10), 'id' => $id]);
        }

        abort(404, 'Zone non trouvée');
    }

    private function formatTimeOfFix(?string $timeOfFix): ?string
    {
        if ($timeOfFix) {
            try {
                if (strpos($timeOfFix, 'Z') !== false) {
                    return Carbon::parse($timeOfFix)->timezone(config('app.timezone'))->toDateTimeString();
                } else {
                    return Carbon::parse($timeOfFix)->timezone(config('app.timezone'))->toDateTimeString();
                }
            } catch (\Throwable $th) {
                Log::error("Erreur lors du formatage de time_of_fix : " . $th->getMessage());
                return null;
            }
        }

        return null;
    }

    public function importCSV(Request $request, $id)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048' // max 2MB
        ]);

        $file = $request->file('csv_file');

        if (!$file) {
            return back()->with('error', 'Aucun fichier sélectionné.');
        }

        $modelClass = "App\Models\zone_{$id}";

        if (!class_exists($modelClass)) {
            return back()->with('error', "La zone {$id} est invalide.");
        }

        set_time_limit(1200); // Augmente le temps d'exécution si le fichier est volumineux

        try {
            $handle = fopen($file->getPathname(), 'r');

            if (!$handle) {
                return back()->with('error', "Impossible d'ouvrir le fichier.");
            }

            // Lire la première ligne pour les en-têtes (à ignorer si inutiles)
            fgetcsv($handle, 1000, ';');

            $articles = [];
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                // Vérifier si la ligne a assez de colonnes (ex: 14 colonnes attendues)
                if (count($data) < 14) {
                    continue; // Ignore la ligne incorrecte
                }

                $timeOfFix = $this->formatTimeOfFix($data[13]);

                $articles[] = [
                    'flag' => $data[0] ?? null,
                    'vessel_name' => $data[1] ?? null,
                    'registered_owner' => $data[2] ?? null,
                    'call_sign' => $data[3] ?? null,
                    'mmsi' => (int) ($data[4] ?? 0),
                    'imo' => (int) ($data[5] ?? 0),
                    'ship_type' => $data[6] ?? null,
                    'destination' => $data[7] ?? null,
                    'eta' => $data[8] ?? null,
                    'navigation_status' => $data[9] ?? null,
                    'latitude' => (float) ($data[10] ?? 0),
                    'longitude' => (float) ($data[11] ?? 0),
                    'age' => (int) ($data[12] ?? 0),
                    'time_of_fix' => $timeOfFix ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            fclose($handle);

            if (!empty($articles)) {
                // Vérifier si le modèle existe bien
                if (!class_exists($modelClass)) {
                    return back()->with('error', "Modèle non trouvé pour la zone {$id}.");
                }

                // Insérer les données
                $modelClass::insert($articles);

                return back()->with('success', "Importation réussie pour la Zone {$id}! Données insérées : " . count($articles));
            } else {
                return back()->with('error', "Aucune donnée valide trouvée dans le fichier.");
            }
        } catch (\Exception $e) {
            return back()->with('error', "Erreur lors de l'importation : " . $e->getMessage());
        }
    }
}