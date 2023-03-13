<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
</head>

<body class="bg-green-100">
    <header class="bg-gray-900 px-5">
        <nav class="flex items-center justify-between flex-wrap py-6">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <span class="font-bold text-xl">GroeneVingers</span>
            </div>
            <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                <div class="text-sm lg:flex-grow">
                    <a href="/" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                        Home
                    </a>
                    <a href="/contact" class="block mt-4 lg:inline-block lg:mt-0 text-gray-300 hover:text-white mr-4">
                        Contact
                    </a>
                </div>
                <div>
                    <a href="/login"
                        class="bg-green-700 hover:bg-green-600 text-white font-bold right-20 py-2 px-4 rounded border-green-800">
                        Log In
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="bg-cover bg-center h-96" style="background-image: url('{{ asset('images/intratuin.png') }}');">
    </div>
    <div class="absolute left-0 flex flex-col justify-top h-max w-max bg-white bg-opacity-50 py-8 px-8">
        <div class="flex text-black mb-4">
            <p class="pr-4">Nuenen <br> 2587 WD <br> Tuinstraat 167</p>
            <p class="pr-4">Zwanenburg <br> 1161 AM <br> Kruiswaal 16</p>
            <p>Soesterberg <br> 3769 DH <br> Kampweg 47</p>
        </div>
        <div class="center">
            <a href="/contact"
                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg rounded-l-lg border border-green-800 w-32 text-center">Contact</a>
        </div>
    </div>
    <div class="relative top-0 left-0 flex flex-col justify-center h-full w-full px-8 pt-8 text-center">
        <h1 class="text-4xl text-black font-bold mb-4">Binnenkort een nieuwe website!</h1>
        <p class="text-black text-lg mb-8">We zijn hard aan het werk aan een webshop, blijf op de hoogte!</p>
        <form action="/" method="POST" class="mx-auto">
            <div class="flex items-center py-2">
                <input type="email" name="email" id="email-input" placeholder="Email"
                    class="px-4 py-2 rounded-l-lg border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white">
                <button type="submit"
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg border-t border-b border-r border-green-800"
                    onclick="showConfirmation()">Houd mij op de hoogte!</button>

                {{-- Email Verzenden --}}
                <script>
                    function showConfirmation() {
                        const emailInput = document.getElementById('email-input').value;
                        alert(`Updates zullen naar ${emailInput} worden verzonden`);
                    }
                </script>

            </div>
        </form>
    </div>

    {{-- Images + Laad meer Images --}}
    <div class="flex flex-wrap justify-between">
        @foreach ($images->take(5) as $image)
            <img src="{{ $image->image }}" alt="{{ $image->name }}" class="w-1/5 h-24 object-cover">
        @endforeach
    </div>
    
    <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="show-more-button">
        Show More
    </button>
    
    <div class="hidden" id="more-images">
        <div class="flex flex-wrap justify-between">
            @foreach ($images->slice(5, 5) as $image)
                <img src="{{ $image->image }}" alt="{{ $image->name }}" class="w-1/5 h-24 object-cover">
            @endforeach
        </div>
    </div>
    


    <script>
        const showMoreButton = document.querySelector('#show-more-button');
        const moreImages = document.querySelector('#more-images');

        showMoreButton.addEventListener('click', function() {
            moreImages.classList.toggle('hidden');
        });
    </script>

</body>

</html>
