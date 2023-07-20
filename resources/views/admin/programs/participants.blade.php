<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $program->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <div class="flex items-center justify-between pb-4 p-2">
                            <div class="flex space-x-2">
                                <div class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3a3 3 0 1 1-1.614 5.53M15 12a4 4 0 0 1 4 4v1h-3.348M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM5 11h3a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
                                      </svg>
                                      {{ $participantCountUser }}/{{ $totalParticipantCount }}
                                </div>
                                <form action="{{ route('program.form', $program->slug) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if ($program->form == 0)
                                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h8m-1-3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1m6 0v3H6V2m6 0h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m0 9.464 2.025 1.965L12 9.571"/>
                                        </svg>
                                        Borang Kehadiran : {{ $program->form == 1 ? 'Open' : 'Closed' }}
                                    </button>
                                    @else
                                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h8m-1-3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1m6 0v3H6V2m6 0h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m0 9.464 2.025 1.965L12 9.571"/>
                                        </svg>
                                        Borang Kehadiran : {{ $program->form == 1 ? 'Open' : 'Closed' }}
                                    </button>
                                    @endif
                                </form>

                            </div>
                            <div class="flex space-x-2">
                                <div>
                                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                        <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                          <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                        Export
                                      </button>
                                      <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                          <li>
                                            <a href="{{ route('programs.export', $program->slug) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Export PDF</a>
                                          </li>
                                          <li>
                                            <a href="{{ route('programs.export-excel', $program->slug) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Export CSV</a>
                                          </li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <form action="{{ route('programs.participants', $program->slug) }}" method="GET">
                                            <input type="text" name="search" value="{{ $search }}" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="hadir-tab" data-tabs-target="#hadir" type="button" role="tab" aria-controls="hadir" aria-selected="false">Senarai Hadir</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="peserta-tab" data-tabs-target="#peserta" type="button" role="tab" aria-controls="peserta" aria-selected="false">Senarai Peserta</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="guest-tab" data-tabs-target="#guest" type="button" role="tab" aria-controls="guest" aria-selected="false">Senarai Tetamu</button>
                                </li>
                            </ul>
                        </div>
                        <div id="myTabContent">
                            <div class="hidden p-2 rounded-lg bg-gray-50 dark:bg-gray-800" id="hadir" role="tabpanel" aria-labelledby="hadir-tab">
                                @if ($attendanceUser->count() > 0)
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Email
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    No. Kad Pengenalan
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Phone
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Organization
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Address
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Notes
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Submitted Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($attendanceUser as $participant)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <th scope="row" class="px-6 py-4">
                                                        {{ $participant->name }}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        {{ $participant->email }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $participant->ic }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $participant->phone }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $participant->organization }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $participant->address }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $participant->notes }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $participant->submitted ? \Carbon\Carbon::parse($participant->submitted)->format('Y-m-d h:i:s A') : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                <div class="flex items-center justify-center w-full p-5 font-medium text-left text-gray-500 border border-b-1 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <span>No Participant Found.</span>
                                </div>
                                @endif
                            </div>
                            <div class="hidden p-2 rounded-lg bg-gray-50 dark:bg-gray-800" id="peserta" role="tabpanel" aria-labelledby="peserta-tab">
                                @if ($participants->count() > 0)
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Email
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    No. Kad Pengenalan
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Phone
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Organization
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Address
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Notes
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Joined Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($participants as $participant)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row" class="px-6 py-4">
                                                    {{ $participant->name }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $participant->email }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $participant->ic }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $participant->phone }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $participant->organization }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $participant->address }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $participant->notes }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $participant->joined ? \Carbon\Carbon::parse($participant->joined)->format('Y-m-d h:i:s A') : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                <div class="flex items-center justify-center w-full p-5 font-medium text-left text-gray-500 border border-b-1 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <span>No Participant Found.</span>
                                </div>
                                @endif
                            </div>
                            <div class="hidden p-2 rounded-lg bg-gray-50 dark:bg-gray-800" id="guest" role="tabpanel" aria-labelledby="guest-tab">
                                @if ($guests->count() > 0)
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Email
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Phone
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Joined Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($guests as $guest)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row" class="px-6 py-4">
                                                    {{ $guest->name }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $guest->email }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $guest->phone }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ \Carbon\Carbon::parse($guest->joined)->format('Y-m-d h:i:s A') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                <div class="flex items-center justify-center w-full p-5 font-medium text-left text-gray-500 border border-b-1 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <span>No Guests Found.</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
