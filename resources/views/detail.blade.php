<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diagnosisku || Detail</title>

    <link rel="icon" href="/Logo.png"> 
    
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col items-center bg-gray-100 font-sans">
    
    <nav class="h-20 w-full bg-primary border-b-8 border-[#D4A349] flex items-center px-6 shadow-md">
        <p class="italic underline text-white font-extrabold  text-4xl"><a href="/" class="hover:text-warning transition duration-150">Diagnosisku</a></p>
    </nav>
    <div class="w-full max-w-5xl px-4 md:px-8 py-6 flex-grow flex flex-col bg-white shadow-2xl rounded-xl my-6"> 
        
        <a href="javascript:history.back()" class="text-primary hover:opacity-80 font-semibold transition duration-150 flex items-center mb-4 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Pencarian
        </a>
        @foreach ($results['results']['bindings'] as $penyakit)
        <div id="disease-detail" class="flex flex-col flex-grow min-h-0">
            <header class="pb-4 mb-4 border-b-2 border-gray-100">
                <h1 class="text-3xl sm:text-4xl text-primary font-extrabold mb-1">
                    {{ $penyakit['namaLabel']['value'] }} - {{ $penyakit['gender']['value'] }}
                </h1>
                <p class="text-md text-gray-500 mt-1">Informasi Lengkap tentang Penyakit ini.</p>
            </header>
              @php
                $createList = function($content) {
                    if (empty($content)) {
                        return '<p class="text-gray-500 italic">Informasi belum tersedia.</p>';
                    }
                    $items = array_filter(array_map('trim', explode(', ', $content)));
                    if (empty($items)) {
                        return '<p class="text-gray-500 italic">Informasi belum tersedia.</p>';
                    }
                    $html = '<ul class="list-disc list-inside space-y-2 text-gray-700 ml-5">';
                    foreach ($items as $item) {
                        $html .= '<li>' . ucfirst(trim($item)) . '</li>';
                    }
                    $html .= '</ul>';
                    return $html;
                };
            @endphp
            
            <div class="flex-grow overflow-y-auto pr-2 custom-scrollbar">
                
                <section class="mb-8 p-4 bg-primary/5 rounded-lg  border-primary">
                    <h2 class="text-xl text-primary font-bold mb-3">Deskripsi Penyakit</h2>
                    <p class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                        {{ $penyakit['deskripsi']['value'] }}
                    </p>
                </section>

                <div class="grid md:grid-cols-2 gap-x-8 gap-y-10">

                    <section>
                        <h3 class="text-xl text-primary font-bold mb-3 border-b pb-1 border-gray-200">Gejala</h3>
                            {!! $createList($penyakit['gejalaList']['value'] ?? '') !!}
                        </ul>
                    </section>

                    <section>
                        <h3 class="text-xl text-primary font-bold mb-3 border-b pb-1 border-gray-200">Penyebab</h3>
                             {!! $createList($penyakit['penyebabList']['value'] ?? '') !!}
                    </section>
                    
                    <section class="md:col-span-2">
                        <h3 class="text-xl text-primary font-bold mb-3 border-b pb-1 border-gray-200">Diagnosis</h3>
                        <p class="text-gray-700 leading-relaxed text-sm">
                            {{ $penyakit['pencegahan']['value'] ?? 'Informasi pencegahan belum tersedia.' }}
                        </p>
                    </section>

                    <section class="md:col-span-2"> 
                        <h3 class="text-xl text-primary font-bold mb-3 border-b pb-1 border-gray-200">Penanganan</h3>
                        <p class="text-gray-700 leading-relaxed text-sm">
                            {{ $penyakit['diagnosis']['value'] ?? 'Informasi diagnosis belum tersedia.' }}
                        </p>
                    </section>

                    <section class="md:col-span-2">
                        <h3 class="text-xl text-primary font-bold mb-3 border-b pb-1 border-gray-200">Pencegahan</h3>
                        <p class="text-gray-700 leading-relaxed text-sm">
                        {{ $penyakit['penanganan']['value'] ?? 'Informasi penanganan belum tersedia.' }}
                        </p>
                    </section>
                    
                </div>
                <div class="h-4"></div>
            </div>

        </div>
        @endforeach
    </div>
    {{-- Footer --}}
    <footer class="bg-primary text-white py-6 mt-auto w-full">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-center items-center">
            <div class="mb-4 md:mb-0">
                <p class="text-xl font-semibold">Diagnosisku</p>
                <p class="text-sm">© 2025 All rights reserved</p>
            {{-- </div>
            <div class="flex space-x-6">
                <a href="#" class="text-white hover:text-gray-300 transition duration-200">About</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-200">Privacy Policy</a>
                <a href="#" class="text-white hover:text-gray-300 transition duration-200">Terms of Service</a>
            </div> --}}
        </div>
    </footer>
</body>
</html>