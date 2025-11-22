<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class kategoriController extends Controller
{   
    public function cariKategoriSemua(Request $request){
         $sparqlQueryLabel = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit ?namaLabel ?deskripsi 
            WHERE {
                ?penyakit rdfs:label ?namaLabel .
                ?penyakit penyakit:memilikiDeskripsi ?deskripsi . 
                
            }
            ";
    $fusekiEndpoint = "http://localhost:3030/Diagnosisku/sparql";

    //buka koneksi
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fusekiEndpoint);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "query=" . urlencode($sparqlQueryLabel) . "&output=json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
    $response = curl_exec($ch);

    curl_close($ch);

    $penyakitKetemu = json_decode($response, true); 
        
        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    

    public function cariKategoriTpologi(Request $request){
        $inputKategori = $request->input('inputKategori'); 

        $gejalaArray = array_map('trim', explode(',', $inputKategori));
        $regexPattern = implode('|', array_map('preg_quote', $gejalaArray));
        
        // SPARQL QUERY: Menggunakan pola regex yang dihasilkan
        $sparqlQueryLabel = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit ?namaLabel ?deskripsi 
            WHERE {
                ?penyakit rdfs:label ?namaLabel .
                ?penyakit penyakit:memilikiDeskripsi ?deskripsi . 
                
                { 
                    ?penyakit penyakit:memilikiDeskripsi ?match .
                    FILTER (regex(?match, \"{$regexPattern}\", 'i'))
                }
            }
            GROUP BY ?penyakit ?namaLabel ?deskripsi
            ";
            
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

curl_close($ch);

$penyakitKetemu = json_decode($response, true); //best match
        
return view('index', [
            'results' => $penyakitKetemu,
            'query' => $inputKategori
        ]);
    }
}