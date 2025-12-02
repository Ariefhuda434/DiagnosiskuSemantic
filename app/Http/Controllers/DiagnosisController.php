<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
// Pastikan helper ini ada dan berfungsi
// use App\helper\cutAfterChar; 
// use App\helper\bestMatchBro; 

class DiagnosisController extends Controller
{
   
    public function index()
    {
        return view('index', [
            'results' => null,
            'query' => null
        ]);
    }

    /**
     * Memproses input pengguna untuk mencari penyakit berdasarkan gejala atau nama.
     * @param Request $request
     */
    public function search(Request $request)
    {
        $inputUser = $request->input('inputUser'); 
        if (empty($inputUser)) {
             return redirect('/')->with('error', 'Mohon masukkan gejala atau nama penyakit.');
        }

        $inputUser = strtolower(trim($inputUser));
        //kamus
        $similarityMap = [
            'migren' => 'migrain',
            'migraint' => 'migrain',
            'migrant' => 'migrain',
            'flu berat' => 'influenza',
            'alergi dingin' => 'urtikaria dingin',
            'dbd' => 'demam berdarah dengue',
            'tipes' => 'tifus',
            'tifoid' => 'tifus',
            'puyeng' => 'pusing',
            'pening' => 'pusing', 
            'pala sakit' => 'sakit kepala',
            'kepala sakit' => 'sakit kepala',
            'sakit kepala' => 'sakit kepala',
            'pusing berputar' => 'vertigo',
            'mual muntah' => 'mual', 
            'mual2' => 'mual',
            'kembung' => 'perut kembung',
            'diare' => 'diare',
            'mencret' => 'diare',
            'perut sakit' => 'sakit perut',
            'mules' => 'sakit perut',
            'badan panas' => 'demam',
            'batuk' => 'batuk',
            'tenggorokan sakit' => 'sakit tenggorokan',
            'sakit tenggorokan' => 'sakit tenggorokan',
            'sesak' => 'sesak napas',
            'sesak nafas' => 'sesak napas',
        ];
        
        if (strpos($inputUser, ',') === false) {
            $stopwords = ['aku', 'saya', 'agak', 'ini', 'lah', 'dan', 'atau', 'tapi', 'pun', 'rasanya', 'sangat', 'sekali', 'ku', 'nya', 'adalah'];
            
            $kataKunci = preg_split('/[^\w]+/', $inputUser, -1, PREG_SPLIT_NO_EMPTY);
            
            $kataBersih = array_filter($kataKunci, function($word) use ($stopwords) {
                return !in_array($word, $stopwords);
            });
            
            $frasaMentah = [implode(' ', $kataBersih)];
            
        } else {
            $frasaMentah = array_map('trim', explode(',', $inputUser));
            $frasaMentah = array_filter(array_unique($frasaMentah));
        }

        $frasaTerkoreksi = [];
        foreach ($frasaMentah as $frasa) {
            $frasa = trim($frasa);
            
            if (array_key_exists($frasa, $similarityMap)) {
                $frasaTerkoreksi[] = $similarityMap[$frasa];
            } else {
                $frasaTerkoreksi[] = $frasa;
            }
        }
        
        $frasaTerkoreksi = array_filter(array_unique($frasaTerkoreksi));
        
        $polaRegexFrasa = implode('|', array_map(function($gejala) {
            return preg_quote($gejala, '/'); 
        }, $frasaTerkoreksi));
        
        if (empty($polaRegexFrasa)) {
            return view('index', ['results' => ['bindings' => []], 'query' => $inputUser]);
        }

        $sparqlQueryLabel = "
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX penyakit: <http://contoh.org/penyakit/>
PREFIX gejala: <http://contoh.org/gejala/>

SELECT ?penyakit ?displayLabel ?deskripsi 
        (SUM(?calculatedBobot) AS ?relevanceScore) 
        (GROUP_CONCAT(DISTINCT ?matchString ; SEPARATOR=\", \") AS ?matchPoint)
WHERE {
    ?penyakit rdfs:label ?displayLabel .
    ?penyakit penyakit:memilikiDeskripsi ?deskripsi .  
    
    OPTIONAL {
        SELECT ?penyakit ?matchString (MAX(?tempBobot) AS ?calculatedBobot) 
        WHERE{
            { 
                ?penyakit rdfs:label ?matchString . 
                FILTER (regex(LCASE(STR(?matchString)), \"{$polaRegexFrasa}\", 'i'))
                BIND(20 AS ?tempBobot) 
            }
            UNION
            { 
                ?penyakit penyakit:memilikiGejala ?gejalaURI .
                ?gejalaURI rdfs:label ?matchString . 
                FILTER (regex(LCASE(STR(?matchString)), \"{$polaRegexFrasa}\", 'i'))
                BIND(10 AS ?tempBobot) 
            }
        }
        GROUP BY ?penyakit ?matchString 
        HAVING (MAX(?tempBobot) > 0)
    }
}
GROUP BY ?penyakit ?displayLabel ?deskripsi
HAVING (SUM(?calculatedBobot) > 0) 
ORDER BY DESC(?relevanceScore)
LIMIT 10
";
        
        $fusekiEndpoint = "http://localhost:3030/Diagnosisku/sparql";
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $fusekiEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "query=" . urlencode($sparqlQueryLabel) . "&output=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            Log::error('CURL Error: ' . $error);
            return redirect('/')->with('error', 'Gagal terhubung ke Fuseki Endpoint: ' . $error);
        }
        
        curl_close($ch);

        $penyakitKetemu = json_decode($response, true); 
        
        return view('index', [
            'results' => $penyakitKetemu,
            'query' => $inputUser
        ]);
    }
    
    /**
     * Menampilkan halaman detail untuk penyakit tertentu.
     * @param Request $request
     */
    public function detail(Request $request){
        $input = $request->input('label');     
        
        $detail = trim(preg_replace('/\s*\([^)]*\)$/', '', $input)); 
        
        $sparqlQueryLabel = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>
            PREFIX gejala: <http://contoh.org/gejala/>

            SELECT ?penyakit ?namaLabel ?deskripsi ?pencegahan ?diagnosis ?penanganan ?gender
            (GROUP_CONCAT(DISTINCT STR(?gejalaLabel); SEPARATOR=\", \") AS ?gejalaList)
            (GROUP_CONCAT(DISTINCT ?penyebab; SEPARATOR=\", \") AS ?penyebabList)
            WHERE {
                ?penyakit rdfs:label ?namaLabel .
                FILTER (STR(?namaLabel) = \"{$detail}\" || regex(?namaLabel, \"{$detail}\", 'i'))

                OPTIONAL { ?penyakit penyakit:memilikiDeskripsi ?deskripsi . } 
                OPTIONAL { 
                    ?penyakit penyakit:memilikiGejala ?gejalaURI . 
                    # Memastikan predikat Gejala menggunakan rdfs:label
                    ?gejalaURI rdfs:label ?gejalaLabel . 
                }
                OPTIONAL { ?penyakit penyakit:memilikiPenyebab ?penyebab . }
                OPTIONAL { ?penyakit penyakit:memilikiPencegahan ?pencegahan . }
                OPTIONAL { ?penyakit penyakit:memilikiDiagnosis ?diagnosis . }
                OPTIONAL { ?penyakit penyakit:memilikiPenanganan ?penanganan . }
                OPTIONAL { ?penyakit penyakit:spesifikGender ?gender . }
            }
            GROUP BY ?penyakit ?namaLabel ?deskripsi ?pencegahan ?diagnosis ?penanganan ?gender
            LIMIT 1 
        ";

        $fusekiEndpoint = "http://localhost:3030/Diagnosisku/sparql";
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $fusekiEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "query=" . urlencode($sparqlQueryLabel) . "&output=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            Log::error('CURL Error: ' . $error);
            return redirect('/')->with('error', 'Gagal terhubung ke Fuseki Endpoint: ' . $error);
        }
        
        curl_close($ch);

        $penyakitKetemu = json_decode($response, true); 

        return view('detail', [
            'results' => $penyakitKetemu,
        ]);
    }
    
    public function detailView()
    {
        return view('detail');
    }
}