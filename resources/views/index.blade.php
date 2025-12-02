    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Diagnosisku || Home</title>
        <link rel="icon" href="public/build/assets/Logo.png">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
         <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-gradient-to-br from-gray-100 to-blue-200 font-sans">
         <nav x-data="{ open: false, mobileMenuOpen: false }" 
     class="h-20 w-full bg-primary border-b-8 border-warning flex items-center px-4 md:px-6 shadow-xl relative z-20 ">
    
    <a href="#" class="italic underline text-white font-extrabold text-4xl hover:text-secondary transition duration-300 mr-4 md:mr-8">
        Diagnosisku
    </a>

    <div class="hidden md:flex items-center space-x-4">
        
        <div class="relative inline-block text-left" @click.away="open = false">
            <button 
                @click="open = !open" 
                class="bg-white text-primary font-semibold px-4 py-2 rounded-xl shadow-lg hover:bg-gray-100 transition duration-150 inline-flex items-center text-sm md:text-base ring-2 ring-primary/20"
            >
                Kategori 
                <svg x-show="!open" class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                <svg x-show="open" x-cloak class="-mr-1 ml-2 h-5 w-5 rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            
            <div x-show="open" 
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="origin-top-left absolute left-0 mt-2 w-56 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-30 transform" 
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                
                <div class="py-1" role="none">
                    
                    <div x-data="{ openSub: false }" @mouseenter="openSub = true" @mouseleave="openSub = false" class="relative">
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-primary/10 hover:text-primary transition font-bold flex justify-between items-center" tabindex="-1">
                            Demografi Tubuh 
                            <svg class="w-4 h-4 ml-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </a>
                        
                        <div x-show="openSub" 
                              x-cloak
                              x-transition:enter="transition ease-out duration-150"
                              x-transition:enter-start="opacity-0 translate-x-[-10px]"
                              x-transition:enter-end="opacity-100 translate-x-0"
                              x-transition:leave="transition ease-in duration-100"
                              x-transition:leave-start="opacity-100 translate-x-0"
                              x-transition:leave-end="opacity-0 translate-x-[-10px]"
                              class="absolute left-full top-0 ml-2 w-48 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" 
                              style="min-width: 150px;">
                            <div class="py-1">
                                <h4 class="px-4 py-1 text-xs font-semibold text-primary uppercase border-b mb-1">Rentang Usia</h4>
                                    <form action="/kategori/lansia" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Lansia</button>
                                    </form>
                                    <form action="/kategori/dewasa" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Dewasa</button>
                                    </form>
                                    <form action="/kategori/remaja" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Remaja</button>
                                    </form>
                                    <form action="/kategori/anak-kecil" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Anak Kecil</button>
                                    </form>
                                    <form action="/kategori/bayi" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Bayi</button>
                                    </form>
                        </div>
                    </div>
                    
                    <div x-data="{ openSub: false }" @mouseenter="openSub = true" @mouseleave="openSub = false" class="relative">
                         <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-primary/10 hover:text-primary transition font-bold flex justify-between items-center" tabindex="-1">
                            Sistem Tubuh 
                            <svg class="w-4 h-4 ml-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </a>
                        <div x-show="openSub" 
                              x-cloak
                              x-transition:enter="transition ease-out duration-150"
                              x-transition:enter-start="opacity-0 translate-x-[-10px]"
                              x-transition:enter-end="opacity-100 translate-x-0"
                              x-transition:leave="transition ease-in duration-100"
                              x-transition:leave-start="opacity-100 translate-x-0"
                              x-transition:leave-end="opacity-0 translate-x-[-10px]"
                              class="absolute left-full top-0 ml-2 w-48 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" 
                              style="min-width: 150px;">
                            <div class="py-1">
                                <h4 class="px-4 py-1 text-xs font-semibold text-primary uppercase border-b mb-1">Sistem Organ</h4>
                               <form action="/kategori/pernapasan" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Pernapasan</button>
                                    </form>
                                    <form action="/kategori/saraf" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Saraf</button>
                                    </form>
                                    <form action="/kategori/Indra" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Indra</button>
                                    </form>
                                    <form action="/kategori/Pencernaan" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Penceranaan</button>
                                    </form>
                                    <form action="/kategori/Reproduksi" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Reproduksi</button>
                                    </form>
                                    <form action="/kategori/Dermatologi" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Dermatologi</button>
                                    </form>
                                    <form action="/kategori/Integumen" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Integumen</button>
                                    </form>
                                    <form action="/kategori/Imunologi" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Imunologi</button>
                                    </form>
                                    <form action="/kategori/Kardiovaskular" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Kardiovaskular</button>
                                    </form>
                                    <form action="/kategori/Endokrin" method="POST" class="text-gray-700 block px-4 py-2 text-sm rounded-xl hover:bg-gray-100">
                                        @csrf
                                            <button type="submit">Endokrin</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <form action="/kategori/semua" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-700 w-full rounded-b-xl  block px-4 py-2 text-sm hover:bg-gray-100 mt-1 border-t pt-2">Semua Kondisi</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</nav>
    
        
        <div class="flex flex-col justify-center items-center mt-60 h-full px-4">
            <h1 class="text-8xl text-primary font-semibold font-swash text-gray-800 mb-4">Penyelidikan Gejala Cepat</h1>
            <p class="text-lg text-gray-600 mb-6 font-medium ">Dapatkan Jawaban Cepat Atas Kekhawatiran Kesehatan Anda.</p>
            
            <!-- Search Bar -->
            <form action="/search" method="POST" class="flex items-center bg-warning rounded-full border-7 border-netral shadow-lg p-2 w-full max-w-xl">
                @csrf
                <input type="text" name="inputUser" placeholder="Tuliskan keluhan anda..." required class="flex-grow py-2 font-nunito text-netral font-bold px-4 text-lg border-none rounded-l-full focus:outline-none">
                <button type="submit" class="h-12 w-12">
                    <img src="{{ asset('build/assets/iconsearch.png') }}" class="h-12 w-12 mr-3 bg-netral rounded-full p-2 hover:bg-[#478480] transition-all ease-in-out duration-300" alt="" srcset="">
                </button>
            </form>

        <div class="w-full max-w-7xl px-4 pb-12">
                @if (empty($results['results']['bindings']))
                    @if (isset($query))
                        <div class="bg-warning border-7 border-netral text-yellow-700 mt-10 p-4 rounded-lg shadow-md mx-auto max-w-xl" role="alert">
                            <p class="font-bold font-nunito text-gray-600">Pencarian Selesai</p>
                            <p class="font-nunito text-netral">Tidak ditemukan penyakit yang sesuai dengan kata kunci "<strong>{{ $query }}</strong>".</p>
                        </div>
                    @endif
                @else
                         <div class="bg-warning border-7 border-netral text-yellow-700 mt-10 p-4 mb-10  rounded-lg shadow-md mx-auto max-w-xl" role="alert">
                            <p class="font-bold font-nunito text-gray-600 font-bold text-2xl text-gray-700"> Ditemukan {{ count($results['results']['bindings']) }} Penyakit</p>
                            <p class="font-nunito text-netral"><strong>{{ $query ?? '' }}</strong></p>
                        </div>
                    <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b-2 border-primary/30 pb-2">
                    </h2>
                    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 ">
                        @foreach ($results['results']['bindings'] as $penyakit)
                        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl  transition duration-300 transform hover:scale-[1.02] border border-gray-100 flex flex-col">
                            
                            <div class="p-6 pb-4 bg-primary/10 border-b border-gray-200 rounded-t-2xl">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-xl font-bold text-primary leading-tight pr-4">
                                         {{ $penyakit['displayLabel']['value'] }} 
                                    </h3>
                                   {{-- @if (!empty($penyakit['relevanceScore']['value']))
                                        <span class="relevance-badge py-1 px-3 text-xs font-bold rounded-full text-white bg-secondary shadow-md"> {{ number_format((float)$penyakit['relevanceScore']['value'], 2, '.', '') }}
                                    </span>
                                    @endif --}}
                                </div>
                            </div>

                            <div class="p-6 flex-grow">
                                <p class="text-sm text-gray-600 mb-4 line-clamp-4">
                                    {{ substr($penyakit['deskripsi']['value'], 0, 150) }}...
                                </p>
                                @php
                                    $label = $penyakit['displayLabel']['value'];
                                    $slug = \App\helper\cutAfterChar::cutBefore($label ,'/');
                                @endphp
                                
                                <form action="{{ route('penyakit.detail',['namaLabel' => $slug]) }}" method="POST">
                                        @csrf
                                        <input value="{{ $slug }}" name="label" class="hidden" >
                                        <button type="submit" class="text-primary hover:text-hover-search font-semibold text-sm transition duration-150 flex items-center mt-3">
                                            Lihat Detail >
                                        </button>
                                    </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <footer class="bg-primary text-white py-6 mt-70">
            <div class="w-full justify-center flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-xl font-semibold">Diagnosisku</p>
                    <p class="text-sm">© 2025 All rights reserved</p>
                </div>
            </div>
        </footer>
    </body>
    </html>
