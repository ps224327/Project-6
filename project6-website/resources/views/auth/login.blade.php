@extends('layouts.app')

@section('content')

        <div class="flex justify-center items-center h-screen">
            <form action="{{ route('login') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" placeholder="Email" name="email">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Wachtwoord
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" placeholder="********" name="password">
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Log In
                    </button>
                    {{-- <a class="inline-block align-baseline font-bold text-sm text-green-700 hover:text-green-600"
                        href="#">
                        Wachtwoord vergeten?
                    </a> --}}
                </div>
            </form>
        </div>

@endsection
