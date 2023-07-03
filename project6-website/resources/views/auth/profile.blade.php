@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-screen">

    {{-- Update profile form --}}
    <form action="{{ route('profile.update') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <h1 class="text-2xl font-bold mb-4">Welkom, {{ auth()->user()->name }}!</h1>
        <p>Pas hier je profiel aan!</p>
        <p {{ auth()->user()->role }}></p>
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
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Naam:</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Wachtwoord:</label>
            <p class="italic text-gray-700 text-xs">(minimaal 6 tekens)</p>
            <input type="password" name="password" id="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <p class="text-gray-500 text-sm mt-1">Laat leeg als je het wachtwoord niet wilt veranderen</p>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Herhaal
                Wachtwoord:</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div>
            <button type="submit"
                class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded border-green-800">Update
                Profiel</button>
        </div>
    </form>
</div>
@endsection
