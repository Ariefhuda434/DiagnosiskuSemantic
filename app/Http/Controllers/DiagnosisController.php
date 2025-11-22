<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\helper\cutAfterChar;
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

    //format slug
    
    public function search(Request $request)
    {
        $inputUser = $request->input('inputUser');      
        //pemecahan input uswe
        $gejalaArray = array_map('trim', explode(',', $inputUser));
        //memastikan tidak ada string kosong
        $gejalaArray = array_filter($gejalaArray);
        //memastikan tidak ada input duplikat
        $gejalaArray = array_unique($gejalaArray);
        //menyusun kembali untuk filter regex
        $regexPattern = implode('|', array_map('preg_quote', $gejalaArray));
        //best match
        $sparqlQueryLabel = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit ?namaLabel ?deskripsi 
            (SUM(?bobot) AS ?relevanceScore) 
            (GROUP_CONCAT(DISTINCT ?match ; SEPARATOR=\", \") AS ?matchPoint)
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi . 
            OPTIONAL {
            { 
                ?penyakit rdfs:label ?match .
                FILTER (regex(?match, \"{$regexPattern}\", 'i'))
                BIND(2 AS ?bobot) 
            }
            UNION
            { 
                ?penyakit penyakit:memilikiGejala ?match .
                FILTER (regex(?match, \"{$regexPattern}\", 'i'))
                BIND(2 AS ?bobot) 
            }
            UNION
            { 
                ?penyakit penyakit:memilikiPenyebab ?match .
                FILTER (regex(?match, \"{$regexPattern}\", 'i'))
                BIND(2 AS ?bobot) 
            }
            UNION
            { 
                ?penyakit penyakit:memilikiDeskripsi ?match .
                FILTER (regex(?match, \"{$regexPattern}\", 'i'))
                BIND(1   AS ?bobot) 
            }
        }
    }
    GROUP BY ?penyakit ?namaLabel ?deskripsi
    HAVING (SUM(?bobot) > 0)
    ORDER BY DESC(?relevanceScore)
    LIMIT 10    
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
   
    public function detail(Request $request){
            $input = $request->input('label');    
             $detail = $input;

        $detail = urldecode($detail);
        $detail = trim($detail, '/'); 
        $detail = cutAfterChar::cutBefore($detail, '/');
        $detail = cutAfterChar::cutBefore($detail, '(');
        $detail = trim($detail);
            $sparqlQueryLabel = "
           PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit ?namaLabel ?deskripsi ?pencegahan ?diagnosis ?penanganan
            (GROUP_CONCAT(DISTINCT ?gejala; SEPARATOR=\", \") AS ?gejalaList)
            (GROUP_CONCAT(DISTINCT ?penyebab; SEPARATOR=\", \") AS ?penyebabList)
            WHERE {
                ?penyakit rdfs:label ?namaLabel .
                FILTER (regex(?namaLabel, \"{$detail}\", 'i'))
                OPTIONAL { ?penyakit penyakit:memilikiDeskripsi ?deskripsi . } 
                OPTIONAL { ?penyakit penyakit:memilikiGejala ?gejala . }
                OPTIONAL { ?penyakit penyakit:memilikiPenyebab ?penyebab . }
                OPTIONAL { ?penyakit penyakit:memilikiPencegahan ?pencegahan . }
                OPTIONAL { ?penyakit penyakit:memilikiDiagnosis ?diagnosis . }
                OPTIONAL { ?penyakit penyakit:memilikiPenanganan ?penanganan . }
            }
            GROUP BY ?penyakit ?namaLabel ?deskripsi ?pencegahan ?diagnosis ?penanganan
            LIMIT 1 
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
//tutup koneksi
curl_close($ch);

$penyakitKetemu = json_decode($response, true); //best match

if ($response === false) {
             Log::error('CURL Error: ' . curl_error($ch));
             return redirect('/')->with('error', 'Gagal terhubung ke Fuseki Endpoint.');
}
        
return view('detail', [
            'results' => $penyakitKetemu,
        ]);
    }

     public function detailView()
    {
        return view('detail');
    }

}