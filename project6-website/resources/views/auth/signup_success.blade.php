@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white shadow-md rounded px-8 py-6">
            <h2 class="text-2xl font-bold mb-4">Succesvol geregistreerd!</h2>
            <p class="text-gray-700">Je kunt zich nu aanmelden op uw account</p>
            <a href="{{ route('login') }}" class="text-green-700 hover:text-green-600 font-bold mt-4">Aanmelden</a>
        </div>
    </div>
@endsection
