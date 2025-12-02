<?php

namespace App\helper;

class bestMatchBro
{
    /**
     * Menghitung Levenshtein Distance (jarak kemiripan) antara dua string.
     * Jarak yang lebih kecil berarti lebih mirip.
     *
     * @param string $inputUser String dari pengguna (e.g., "pusing keliling")
     * @param string $target    String target dari database (e.g., "pusing tujuh keliling")
     * @return int              Jarak kemiripan (Levenshtein Distance)
     */
    public  static function dapatkanGap(string $inputUser, string $target): int
    {
        // 1. Normalisasi Input (wajib)
        $s1 = strtolower(trim($inputUser));
        $s2 = strtolower(trim($target));

        $len1 = strlen($s1);
        $len2 = strlen($s2);

        // 2. Kasus Dasar (Base Cases)
        // Jika salah satu string kosong, jaraknya adalah panjang string lainnya.
        if ($len1 === 0) {
            return $len2;
        }
        if ($len2 === 0) {
            return $len1;
        }
        
        // 3. Inisialisasi Matriks
        $matrix = [];

        // Inisialisasi kolom 0 (Jarak dari string kosong ke s1)
        for ($i = 0; $i <= $len1; $i++) { 
            $matrix[$i][0] = $i;
        }
        
        // Inisialisasi baris 0 (Jarak dari string kosong ke s2)
        for ($j = 0; $j <= $len2; $j++) { 
            $matrix[0][$j] = $j;
        }

        // 4. Pengisian Matriks (Dynamic Programming)
        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                
                // Tentukan biaya substitusi (cost): 0 jika karakter sama, 1 jika beda.
                // Kritis: Akses string ($s1/$s2), BUKAN panjangnya ($len1/$len2)!
                $cost = ($s1[$i - 1] === $s2[$j - 1]) ? 0 : 1;

                // Nilai minimum dari tiga operasi:
                $matrix[$i][$j] = min(
                    $matrix[$i - 1][$j] + 1,        // Deletion (Hapus)
                    $matrix[$i][$j - 1] + 1,        // Insertion (Sisipkan)
                    $matrix[$i - 1][$j - 1] + $cost // Substitution (Ganti/Cocok)
                );
            }
        }
        
        // 5. Hasil Akhir adalah nilai di sudut kanan bawah matriks
        return $matrix[$len1][$len2];
    }
}