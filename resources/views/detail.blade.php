<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diagnosisku || detail</title>
    <link rel="icon" href="public/build/assets/Logo.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col items-center bg-gray-50">
    <nav class="h-20 w-full bg-primary border-b-8 border-secondary flex items-center px-6">
        <p class="italic text-white font-bold text-4xl underline"><a href="/">Diagnosisku</a></p>
    </nav>
    
    <div class="w-full max-w-4xl px-4 md:px-6 py-8 flex-grow bg-white shadow-xl rounded-lg my-8">   
        <a href="/" class="underline font-bold font-nunito">kembali</a>

         @foreach ($results['results']['bindings'] as $penyakit)
        <header class="pb-4 mb-6 border-b border-gray-200">
            <h1 class="text-3xl text-warning font-bold mb-3 border-l-4 border-yellow-300 pl-3">{{ $penyakit['namaLabel']['value'] }}</h1>
            <p class="text-lg text-gray-500 mt-2">Informasi Lengkap mengenai Penyakit {{ $penyakit['namaLabel']['value'] }}</p>
        </header>

        <section class="mb-8">
            <h2 class="text-3xl text-primary font-bold mb-3 border-l-4 border-green-400 pl-3">Deskripsi</h2>
            <p class="font-nunito text-gray-700 leading-relaxed text-base"  name="deskripsi">
                {{ $penyakit['deskripsi']['value'] }}
            </p>
        </section>

        <div class="space-y-10">

            <section>
                <h3 class="text-3xl text-primary font-bold mb-3 border-l-4 border-green-400 pl-3">Gejala</h3>
                <p class="text-gray-600 leading-relaxed">{{ $penyakit['gejalaList']['value']?? 'Informasi Gejala belum tersedia.' }}</p>
            </section>

            <section>
                <h3 class="text-3xl text-primary font-bold mb-3 border-l-4 border-green-400 pl-3">Penyebab</h3>
                <p class="text-gray-600 leading-relaxed">{{ $penyakit['penyebabList']['value']?? 'Informasi penyebab belum tersedia.' }}</p>
            </section>
            
            <section>
                <h3 class="text-3xl text-primary font-bold mb-3 border-l-4 border-green-400 pl-3">Pencegahan</h3>
                <p class="text-gray-600 leading-relaxed">{{ $penyakit['pencegahan']['value']?? 'Informasi pencegahan belum tersedia.' }}</p>
            </section>
            
            <section>
                <h3 class="text-3xl text-primary font-bold mb-3 border-l-4 border-green-400 pl-3">Diagnosis</h3>
                <p class="text-gray-600 leading-relaxed">{{ $penyakit['diagnosis']['value']?? 'Informasi Diagnosis belum tersedia.' }}</p>
            </section>
            
            <section>   
                <h3 class="text-3xl text-primary font-bold mb-3 border-l-4 border-green-400 pl-3">Penanganan</h3>
                <p class="text-gray-600 leading-relaxed">{{ $penyakit['penanganan']['value']?? 'Informasi penanganan belum tersedia.' }}</p>
            </section>
        </div>
         @endforeach
        
    </div>
    
{{-- 
     <footer class="bg-primary text-white py-6 mt-10 w-full">
         <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
             <div class="mb-4 md:mb-0">
                 <p class="text-xl font-semibold">Diagnosisku</p>
                 <p class="text-sm">© 2025 All rights reserved</p>
             </div>
             <div class="flex space-x-6">
                 <a href="#" class="text-white hover:text-gray-300 transition duration-200">About</a>
                 <a href="#" class="text-white hover:text-gray-300 transition duration-200">Privacy Policy</a>
                 <a href="#" class="text-white hover:text-gray-300 transition duration-200">Terms of Service</a>
             </div>
         </div>
     </footer> --}}
</body>
</html>