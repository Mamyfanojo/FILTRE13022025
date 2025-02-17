<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(20);
        return view('articles.index', compact('articles'));
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé.');
    }


    public function importCSV(Request $request)
    {
        $file = $request->file('csv_file');
        set_time_limit(1200);

        if ($file) {
            $handle = fopen($file->getPathname(), 'r');
            fgetcsv($handle, 1000, ';'); // Ignorer la ligne d'en-tête

            $articles = [];

            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                if (count($data) < 14) {
                    continue; // Ignorer les lignes incomplètes
                }

                $timeOfFix = $this->formatTimeOfFix($data[13]);

                $articles[] = [
                    'flag' => $data[0],
                    'vessel_name' => $data[1],
                    'registered_owner' => $data[2],
                    'call_sign' => $data[3],
                    'mmsi' => $data[4],
                    'imo' => $data[5],
                    'ship_type' => $data[6],
                    'destination' => $data[7],
                    'eta' => $data[8],
                    'navigation_status' => $data[9],
                    'latitude' => $data[10],
                    'longitude' => $data[11],
                    'age' => $data[12],
                    'time_of_fix' => $timeOfFix,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($articles) >= 1000) {
                    Article::insert($articles);
                    $articles = [];
                }
            }

            if (!empty($articles)) {
                Article::insert($articles);
            }

            fclose($handle);
        }

        return back()->with('success', 'Importation terminée.');
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

    public function filter(Request $request)
    {
        $filter = $request->input('filter'); // Récupérer le filtre sélectionné
        
        $query = Article::query(); // Initialisation de la requête
    
        if ($filter === 'destinationmada') {
            // Liste des destinations pour "Destination Mada"
            $filtreDestinations = [
                "Mg die", "Antsiranana [mdg]", "Mg Die", "Mgdie", "Diego Suarez",
                "Mg Dgo", "Mg Mjn", "Mgmjn", "Mg Mga", "Majunga", "Mahajanga",
                "Mg Tle", "Mgtle", "Mg Ehl", "mgehl", "Mgt0a", "Mg Tmm", "Mgtoa",
                "Mg Toa", "Tamatave", "Toamasina", "Tamatave-madagascar",
                "Toamasina(tamatave)", "Mg.toamasina", "Mgtmm", "mgtmm", "Mgtmve",
                "Tma", "Tma@@@@@@@@@@@@@@@@a", "Toamasina. Madagasca", "Nosy Be",
                "Mgehl", "Mg Eho", "Mg Nbe", "Mg Voh", "Vohemar", "Mg Vhm", "Tular",
                "Eez Madagascar", "Ile Sainte Marie", "Sainte Marie", "Iharana",
                "Andoany", "Ehoala", "Tulear-Madagascar", "Tulear-mg", "Nosy Be",
                "Ankify", "Mg Nos", "Mgnos", "Mg B2g", "Mg Ftu", "Hell-ville",
                "Nosy Be Madagascar", "Nosy Iranja", "Mg Nbe", "Fort Dauphin",
                "Antsiranana", "Mg Nosy Mangabe", "Nosy Tanikely", "Tulear__madagascar",
                "Nosy Sakatia", "Mghlv", "Morondava", "Toamgt"
            ];
    
           // Appliquer le filtre
        $query->where(function ($q) use ($filtreDestinations) {
            foreach ($filtreDestinations as $destination) {
                $q->orWhere('destination', $destination);
            }
            // Inclure aussi les destinations qui commencent par "Mg"
            $q->orWhere('destination', 'LIKE', 'Mg%');
        });

        // Exclure les lignes avec shiptype = "Tug"
        $query->where('ship_type', '!=', 'Tug');

        // Exclure les lignes avec vessel_name = "TSARAVATSY", "AVISOA", "TS INDIAN OCEAN"
        $query->whereNotIn('vessel_name', ['TSARAVATSY', 'AVISOA', 'TS INDIAN OCEAN']);

        // Exclure les lignes avec flag = "Madagascar"
        $query->where('flag', '!=', 'Madagascar');

        } elseif ($filter === 'national') {
            // Filtrer uniquement les articles avec "Madagascar" et "Luxembourg"
            $query->whereIn('flag', ['Madagascar', 'Luxembourg']);
        } elseif ($filter === 'international') {
            // Filtrer tout sauf "Madagascar" et "Luxembourg"
            $query->whereNotIn('flag', ['Madagascar', 'Luxembourg']);
        }
    
        $articles = $query->paginate($query->count());
    
        return view('articles.index', compact('articles'));
    }
    

    // Code corrigé pour les méthodes d'exportation CSV
    public function exportCSV()
    {
        $articles = Article::all();
        $fileName = 'articles'.carbon::now().'.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
            "Pragma" => "public",
        ];

        return response()->stream(function () use ($articles) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); 

            // Entête CSV
            fputcsv($file, ['flag', 'vessel_name', 'registered_owner', 'call_sign', 'mmsi', 'imo', 'ship_type', 'destination', 'eta', 'navigation_status', 'latitude', 'longitude', 'age', 'time_of_fix'], ';');

            foreach ($articles as $article) {
                $timeOfFix = $article->time_of_fix ? Carbon::parse($article->time_of_fix)->format('Y-m-d\TH:i:s.000\Z') : null;
                fputcsv($file, [
                    $article->flag,
                    $article->vessel_name,
                    $article->registered_owner,
                    $article->call_sign,
                    $article->mmsi,
                    $article->imo,
                    $article->ship_type,
                    $article->destination,
                    $article->eta,
                    $article->navigation_status,
                    $article->latitude,
                    $article->longitude,
                    $article->age,
                    $timeOfFix,
                ], ';');
            }

            fflush($file);
            fclose($file);
        }, 200, $headers);
    }

    public function exportFilteredCSV(Request $request)
    {
        $filter = $request->input('filter');
    
        $query = Article::query();
    
        if ($filter === 'destinationmada') {
            $filtreDestinations = [
                "Mg die", "Antsiranana [mdg]", "Mg Die", "Mgdie", "Diego Suarez",
                "Mg Dgo", "Mg Mjn", "Mgmjn", "Mg Mga", "Majunga", "Mahajanga",
                "Mg Tle", "Mgtle", "Mg Ehl", "mgehl", "Mgt0a", "Mg Tmm", "Mgtoa",
                "Mg Toa", "Tamatave", "Toamasina", "Tamatave-madagascar",
                "Toamasina(tamatave)", "Mg.toamasina", "Mgtmm", "mgtmm", "Mgtmve",
                "Tma", "Tma@@@@@@@@@@@@@@@@a", "Toamasina. Madagasca", "Nosy Be",
                "Mgehl", "Mg Eho", "Mg Nbe", "Mg Voh", "Vohemar", "Mg Vhm", "Tular",
                "Eez Madagascar", "Ile Sainte Marie", "Sainte Marie", "Iharana",
                "Andoany", "Ehoala", "Tulear-Madagascar", "Tulear-mg", "Nosy Be",
                "Ankify", "Mg Nos", "Mgnos", "Mg B2g", "Mg Ftu", "Hell-ville",
                "Nosy Be Madagascar", "Nosy Iranja", "Mg Nbe", "Fort Dauphin",
                "Antsiranana", "Mg Nosy Mangabe", "Nosy Tanikely", "Tulear__madagascar",
                "Nosy Sakatia", "Mghlv", "Morondava", "Toamgt"
            ];
    
            $query->where(function ($q) use ($filtreDestinations) {
                foreach ($filtreDestinations as $destination) {
                    $q->orWhere('destination', $destination);
                }
                $q->orWhere('destination', 'LIKE', 'Mg%');
            });

                // Exclure les lignes avec shiptype = "Tug"
            $query->where('ship_type', '!=', 'Tug');

            // Exclure les lignes avec vessel_name = "TSARAVATSY", "AVISOA", "TS INDIAN OCEAN"
            $query->whereNotIn('vessel_name', ['TSARAVATSY', 'AVISOA', 'TS INDIAN OCEAN']);

            // Exclure les lignes avec flag = "Madagascar"
            $query->where('flag', '!=', 'Madagascar');
        } elseif ($filter === 'national') {
            $query->whereIn('flag', ['Madagascar', 'Luxembourg']);
        } elseif ($filter === 'international') {
            $query->whereNotIn('flag', ['Madagascar', 'Luxembourg']);
        }
    
        $articles = $query->get();
    
        $fileName = 'articles_filtrés_'.$filter.'_' . Carbon::now()->format('Y-m-d_His') . '.csv';
        $headers = [
            
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Expires" => "0",
        ];
    
        $callback = function () use ($articles) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
    
            // En-tête du fichier CSV
            fputcsv($file, ['flag', 'vessel_name', 'registered_owner', 'call_sign', 'mmsi', 'imo', 'ship_type', 'destination', 'eta', 'navigation_status', 'latitude', 'longitude', 'age', 'time_of_fix'], ';');
    
            // Contenu du fichier CSV
            foreach ($articles as $article) {
                $timeOfFix = $article->time_of_fix ? Carbon::parse($article->time_of_fix)->format('Y-m-d\TH:i:s.000\Z') : null;
                fputcsv($file, [
                    $article->flag,
                    $article->vessel_name,
                    $article->registered_owner,
                    $article->call_sign,
                    $article->mmsi,
                    $article->imo,
                    $article->ship_type,
                    $article->destination,
                    $article->eta,
                    $article->navigation_status,
                    $article->latitude,
                    $article->longitude,
                    $article->age,
                    $timeOfFix,
                ], ';');
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    

}