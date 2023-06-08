@if ($alert)
    <div class="fixed top-0 left-0 right-0 flex justify-center mt-4">
        <div class="bg-{{ $alert['type'] }}-500 bg-green-600 text-white font-bold py-2 px-4 rounded border-2 border-green-700 flex items-center justify-between">
            <span>{{ $alert['message'] }}</span>
            <button type="button" class="text-white ml-2 font-bold" onclick="this.parentNode.parentNode.remove()">
                &times;
            </button>
        </div>
    </div>

    @if ($alert['autoClose'])
        <script>
            setTimeout(function() {
                document.querySelector('.fixed.top-0.left-0.right-0').remove();
            }, 3000); // Adjust the duration (in milliseconds) as needed
        </script>
    @endif
@endif
