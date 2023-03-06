<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
</head>

<body class="bg-green-100">
    <header>
        <button>Home</button>
    </header>
    <div class="bg-cover bg-center h-96" style="background-image: url('{{ asset('images/intratuin.png') }}');">
    </div>
    <div class="absolute top-10 left-0 flex flex-col justify-top h-max w-max bg-white bg-opacity-50 py-8 px-8">
        <div class="flex text-black mb-4">
            <p class="pr-4">Nuenen <br> 2587 WD <br> Tuinstraat 167</p>
            <p class="pr-4">Zwanenburg <br> 1161 AM <br> Kruiswaal 16</p>
            <p>Soesterberg <br> 3769 DH <br> Kampweg 47</p>
        </div>
        <div class="center">
            <a href="/contact"
                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg rounded-l-lg border border-blue-500 border-gray-200 w-32 text-center">Contact</a>
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
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r-lg border-t border-b border-r border-blue-500 border-gray-200"
                    onclick="showConfirmation()">Houd mij op de hoogte!</button>

                <script>
                    function showConfirmation() {
                        const emailInput = document.getElementById('email-input').value;
                        alert(`Updates zullen naar ${emailInput} worden verzonden`);
                    }
                </script>

            </div>
        </form>
    </div>
    <div class="flex justify-center items-end h-48">
        <div class="w-1/3 mx-4">
            <img class="h-32 mx-auto" src="{{ asset('images/image1.jpg') }}" alt="Image 1">
        </div>
        <div class="w-1/3 mx-4">
            <img class="h-32 mx-auto" src="{{ asset('images/image2.jpg') }}" alt="Image 2">
        </div>
        <div class="w-1/3 mx-4">
            <img class="h-32 mx-auto" src="{{ asset('images/image3.jpg') }}" alt="Image 3">
        </div>
    </div>
</body>

</html>
