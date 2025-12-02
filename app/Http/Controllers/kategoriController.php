<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class kategoriController extends Controller
{ 
    /**
     * @param string $sparqlQuery Kueri SPARQL yang akan dieksekusi.
     * @return array|null Hasil kueri sebagai array PHP, atau null jika gagal.
     */
    private function executeSparqlQuery(string $sparqlQuery): ?array
    {
        $fusekiEndpoint = "http://localhost:3030/Diagnosisku/sparql";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fusekiEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "query=" . urlencode($sparqlQuery) . "&output=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || $httpCode !== 200) {
            Log::error("CURL Error accessing Fuseki: " . $curlError);
            Log::error("Fuseki HTTP Code: " . $httpCode);
            return null;
        }

        $results = json_decode($response, true);
        
        if (isset($results['results']) && isset($results['results']['bindings'])) {
            return $results;
        }
        
        return null;
    }
    
    // Kategori Berdasarkan USIA

    public function cariKategoriLansia(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?usia ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:umumPadaUsia ?usia 

            FILTER(?usia = penyakit:Lansia)
            }
            GROUP BY ?penyakit ?usia ?deskripsi
            ORDER BY ?penyakit
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    
    
    public function cariKategoriDewasa(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?usia ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:umumPadaUsia ?usia 

            FILTER(?usia = penyakit:Dewasa)
            }
            GROUP BY ?penyakit ?usia ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    
    public function cariKategoriRemaja(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?usia ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:umumPadaUsia ?usia 

            FILTER(?usia = penyakit:Remaja)
            }
            GROUP BY ?penyakit ?usia ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    public function cariKategoriAnakKecil(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?usia ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:umumPadaUsia ?usia 

            FILTER(?usia = penyakit:Anak_Kecil)
            }
            GROUP BY ?penyakit ?usia ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    public function cariKategoriBayi(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?usia ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:umumPadaUsia ?usia 

            FILTER(?usia = penyakit:Bayi)
            }
            GROUP BY ?penyakit ?usia ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }

    // Kategori Berdasarkan SISTEM TUBUH

    public function cariKategoriPernapasan(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Pernapasan)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }

    public function cariKategoriPencernaan(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Pencernaan)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }

    
    public function cariKategoriKardiovaskular(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Kardiovaskular)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    
    public function cariKategoriEndokrin(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Endokrin)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    public function cariKategoriImunologi(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Imunologi)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    public function cariKategoriDermatologi(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Dermatologi)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    public function cariKategoriIndra(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Indra)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    public function cariKategoriReproduksi(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Reproduksi)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }

    
    public function cariKategoriSaraf(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Saraf)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }

    public function cariKategoriUrogenital(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Urogenital)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
    public function cariKategoriIntegumen(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?bagian ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi .
            ?penyakit penyakit:menyerangSistem ?bagian .

            FILTER(?bagian = penyakit:Integumen)
            }
            GROUP BY ?penyakit ?bagian ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }
 
    
    public function cariKategoriSemua(Request $request)
    {
        $sparqlQuery = "
            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
            PREFIX penyakit: <http://contoh.org/penyakit/>

            SELECT ?penyakit (SAMPLE(?namaLabel) AS ?displayLabel) ?usia ?deskripsi
            WHERE {
            ?penyakit rdfs:label ?namaLabel .
            ?penyakit penyakit:memilikiDeskripsi ?deskripsi
            }
            GROUP BY ?penyakit ?usia ?deskripsi
            ORDER BY ?deskripsi
            ";
            
        $penyakitKetemu = $this->executeSparqlQuery($sparqlQuery);

        return view('index', [
            'results' => $penyakitKetemu,
        ]);
    }

}