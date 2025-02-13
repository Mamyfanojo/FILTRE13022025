<?php

namespace App\Http\Controllers;

use App\Models\Listmada;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ListeMadaController extends Controller
{
    public function index(Request $request) {
        $query = Listmada::query();

        if ($request->filled('year')) {
            $query->whereYear('time_of_fix', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('time_of_fix', $request->month);
        }
        if ($request->filled('day')) {
            $query->whereDay('time_of_fix', $request->day);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('time_of_fix', [$request->start_date, $request->end_date]);
        }

        $listmadas = $query->orderBy('time_of_fix', 'desc')->get();
        return view('articles.listmada', ['listmadas' => $listmadas]);
    }

    public function import(Request $request)
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
                    Listmada::insert($articles);
                    $articles = [];
                }
            }

            if (!empty($articles)) {
                Listmada::insert($articles);
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

    public function export()
    {
        $articles = Listmada::all();
        $fileName = 'listmada_'.Carbon::now().'.csv';

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

    public function destroy($id) {

    }
}
