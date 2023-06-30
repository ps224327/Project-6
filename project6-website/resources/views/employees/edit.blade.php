@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <form action="{{ route('employees.update', $employee) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            <h1 class="text-2xl font-bold mb-4">Bewerk Medewerker</h1>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Naam:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" placeholder="Naam" name="name" value="{{ $employee->name }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="email" placeholder="Email" name="email" value="{{ $employee->email }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Wachtwoord:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" placeholder="******" name="password">
                <p class="text-gray-500 text-sm mt-1">Laat leeg als je het wachtwoord niet wilt veranderen</p>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                    Herhaal wachtwoord
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="password_confirmation" type="password" placeholder="******" name="password_confirmation">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="employee_number">
                    Medewerker Nummer:
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="employee_number" type="text" placeholder="Medewerker Nummer" name="employee_number"
                    value="{{ $employee->employee_number }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                    Rol:
                </label>
                <select id="role" name="role"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <option value="webAdmin" {{ $employee->role === 'webAdmin' ? 'selected' : '' }}>Web Admin</option>
                    <option value="customer" {{ $employee->role === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="webemployee" {{ $employee->role === 'webemployee' ? 'selected' : '' }}>Web Medewerker</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Bewerk
                </button>
            </div>
        </form>
    </div>
@endsection
