<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class DiagnosisController extends Controller
{
    /**
     * Menerima input gejala, menghubungi Fuseki, memproses hasil, dan mengirimkannya ke View.
     */
    public function index()
    {
        return view('index', [
        'results' => null,
        'query' => null
    ]);
    }
    public function search(Request $request)
    {
        $inputUser = $request->input('inputUser');

        //best match
        $sparqlQueryLabel = "
    PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
    PREFIX penyakit: <http://contoh.org/penyakit/>

    SELECT ?penyakit ?namaLabel ?deskripsi (?score AS ?relevanceScore)
    WHERE{
         ?penyakit rdfs:label ?namaLabel .
         ?penyakit penyakit:memilikiDeskripsi ?deskripsi .

    OPTIONAL { 
        ?penyakit penyakit:memilikiGejala ?gejala.
        FILTER (regex(?gejala, \"{$inputUser}\", 'i')) .
        BIND(1 AS ?score_match)
    }
    BIND(COALESCE(?score_match, 0) AS ?score)
    FILTER (?score > 0)
}
ORDER BY DESC(?score)";
//server fuseki
$fusekiEndpoint = "http://localhost:3030/Diagnosisku/sparql";
//buka koneksi
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $fusekiEndpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "query=" . urlencode($sparqlQueryLabel) . "&output=json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
$response = curl_exec($ch);
//tutup koneksi
curl_close($ch);

$penyakitKetemu = json_decode($response, true); //best match

if ($response === false) {
             Log::error('CURL Error: ' . curl_error($ch));
             return redirect('/')->with('error', 'Gagal terhubung ke Fuseki Endpoint.');
}
        
return view('index', [
            'results' => $penyakitKetemu,
            'query' => $inputUser
        ]);
    }
  
}