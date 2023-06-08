@extends('layouts.app')

@section('content')

        <h1 class="text-2xl font-bold mb-4">Profiel</h1>

        <p class="mb-4">Welkom, {{ auth()->user()->name }}!</p>

        {{-- Update profile form --}}
        <form action="{{ route('profile.update') }}" method="POST" class="max-w-md mx-auto">
            @csrf
            {{-- Display validation errors, if any --}}
            @if ($errors->any())
                <div class="bg-red-500 text-white py-2 px-4 mb-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Display success message, if any --}}
            @if (session('success'))
                <div class="bg-green-500 text-white py-2 px-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="name" class="block font-medium">Naam:</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                    class="border border-green-800 rounded px-3 py-2 w-full">
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                    class="border border-green-800 rounded px-3 py-2 w-full">
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium">Wachtwoord:</label>
                <p class="italic text-gray-700 text-xs">(minimaal 6 tekens)</p>
                <input type="password" name="password" id="password"
                    class="border border-green-800 rounded px-3 py-2 w-full">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-medium">Herhaal Wachtwoord:</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="border border-green-800 rounded px-3 py-2 w-full">
            </div>

            <div>
                <button type="submit"
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded border-green-800">Update
                    Profile</button>
            </div>
        </form>

@endsection
