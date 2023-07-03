@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Medewerkers</h1>
        <!-- Search Bar -->
        <form action="{{ route('employees.index') }}" method="GET" class="mb-4">
            <div class="flex justify-end">
                <input type="text" name="search" value="{{ $search }}"
                    class="shadow appearance-none border rounded-l w-2/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Zoek...">
                <button type="submit"
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r ml-2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        @if (count($employees) > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Naam
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Medewerker Nummer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span>Bewerk</span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span>Verwijder</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($employees as $employee)
                        @php
                            $isCurrentUser = $employee->id === auth()->id();
                        @endphp

                        <tr class="{{ $isCurrentUser ? 'bg-gray-200' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $employee->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $employee->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $employee->employee_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $employee->role }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('employees.edit', $employee) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Bewerk</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                    onsubmit="return confirm('Weet je zeker dat je deze medewerker wilt verwijderen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Verwijder</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                <a href="{{ route('employees.create') }}"
                    class="bg-green-700 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Medewerker toevoegen</a>
            </div>
        @else
            <p>Geen medewerkers gevonden</p>
        @endif
    </div>
@endsection
