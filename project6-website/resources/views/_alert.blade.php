@if ($alert)
    <div class="fixed top-0 left-0 right-0 flex justify-center items-center mt-4 z-50">
        @if ($alert['type'] === 'error')
            <div class="bg-red-500 text-white font-bold py-2 px-4 rounded border-2 border-red-700 flex flex-col items-center">
                <span>{{ $alert['message'] }}</span>
                @if (!empty($insufficientStockProducts))
                    <div class="mt-4">
                        <p class="text-lg font-bold">Onvoldoende voorraad voor de volgende product(en):</p>
                        <ul>
                            @foreach ($insufficientStockProducts as $product)
                                <li>{{ $product }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="button" class="text-white mt-4 font-bold block self-stretch" onclick="this.parentNode.parentNode.remove()">
                    &times;
                </button>
            </div>
        @else
            <div class="bg-green-500 text-white font-bold py-2 px-4 rounded border-2 border-green-700 flex items-center justify-between">
                <span>{{ $alert['message'] }}</span>
                <button type="button" class="text-white ml-2 font-bold" onclick="this.parentNode.parentNode.remove()">
                    &times;
                </button>
            </div>
        @endif
    </div>

    @if ($alert['autoClose'])
        <script>
            setTimeout(function() {
                document.querySelector('.fixed.top-0.left-0.right-0').remove();
            }, 3000); // Adjust the duration (in milliseconds) as needed
        </script>
    @endif
@endif
