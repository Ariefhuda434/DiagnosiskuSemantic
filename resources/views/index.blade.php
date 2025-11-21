<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Diagnosisku || Home</title>
    <link rel="icon" href="public/build/assets/Logo.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-100 to-blue-200 font-sans">
    <!-- Navigation Bar -->
    <nav class="h-20 w-full bg-primary border-b-8 border-secondary flex items-center px-6">
        <p class="italic text-white font-bold text-4xl underline">Diagnosisku</p>
    </nav>
    
    <!-- Main Content -->
    <div class="flex flex-col justify-center items-center h-screen px-4">
        <h1 class="text-8xl text-primary font-semibold font-swash text-gray-800 mb-4">Penyelidikan Gejala Cepat</h1>
        <p class="text-lg text-gray-600 mb-6 font-medium ">Dapatkan Jawaban Cepat Atas Kekhawatiran Kesehatan Anda.</p>
        
        <!-- Search Bar -->
        <form action="/" method="POST" class="flex items-center bg-warning rounded-full border-7 border-netral shadow-lg p-2 w-full max-w-xl">
            @csrf
            <input type="text" name="inputUser" placeholder="Tuliskan keluhan anda..." required class="flex-grow py-2 font-nunito text-netral font-bold px-4 text-lg border-none rounded-l-full focus:outline-none">
            <button type="submit" class="h-12 w-12">
                <img src="{{ asset('build/assets/iconsearch.png') }}" class="h-12 w-12 mr-3 bg-netral rounded-full p-2 hover:bg-[#478480] transition-all ease-in-out duration-300" alt="" srcset="">
            </button>
        </form>

    @if (empty($results['results']['bindings']))
        <p>Tidak ditemukan penyakit yang sesuai dengan kat kunci Anda.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nama Penyakit</th>
                    <th>Deskripsi Singkat</th>
                    <th>Skor Relevansi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results['results']['bindings'] as $penyakit)
                    <tr>
                        <td>{{ $penyakit['namaLabel']['value'] }}</td>
                        <td>{{ substr($penyakit['deskripsi']['value'], 0, 150) }}...</td>
                        <td>{{ $penyakit['relevanceScore']['value'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div>

     <footer class="bg-primary text-white py-6 mt-10">
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
    </footer>
</body>
</html>
