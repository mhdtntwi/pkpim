<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-2">
            <div id="chart-container" class="space-y-3">
                @foreach ($chartData as $programId => $data)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 ">
                        <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
                            <h2 id="accordion-flush-heading-{{ $programId }}">
                                <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-{{ $programId }}" aria-expanded="true" aria-controls="accordion-flush-body-{{ $programId }}">
                                    <span>Laporan : {{ $data['program_name'] }}</span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-flush-body-{{ $programId }}" class="hidden" aria-labelledby="accordion-flush-heading-{{ $programId }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4 mt-4 pb-20">
                                    <div class="h-32 md:h-64">
                                        <div class="flex justify-center mb-5">
                                            <div>
                                                <div class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    Rekod Peserta
                                                </div>
                                            </div>
                                        </div>
                                        @if ($data['user_count'] + $data['guest_count'] > 0)
                                            <canvas id="chart-peserta-{{ $programId }}"></canvas>
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <span class="text-gray-500">No Data</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="h-32 md:h-64">
                                        <div class="flex justify-center mb-5">
                                            <div>
                                                <div class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    Rekod Jantina
                                                </div>
                                            </div>
                                        </div>
                                        @if (array_sum($data['gender_counts']) > 0)
                                            <canvas id="chart-gender-{{ $programId }}"></canvas>
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <span class="text-gray-500">No Data</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="h-32 md:h-64">
                                        <div class="flex justify-center mb-5">
                                            <div>
                                                <div class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    Rekod Kehadiran
                                                </div>
                                            </div>
                                        </div>
                                        @if ($data['submitted_attendance_count'] + $data['not_submitted_attendance_count'] > 0)
                                            <canvas id="chart-attendance-{{ $programId }}"></canvas>
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <span class="text-gray-500">No Data</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4 pb-20 mt-10">
                                    <div class="lg:col-span-2 h-32 md:h-64 mt-20">
                                        <div class="flex justify-center mb-5">
                                            <div>
                                                <div class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                    Rekod Negeri
                                                </div>
                                            </div>
                                        </div>
                                        @if (array_sum($data['user_states']) + array_sum($data['guest_states']) > 0)
                                            <canvas id="chart-states-{{ $programId }}"></canvas>
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <div class="relative">
                                                    <canvas id="chart-states-{{ $programId }}-no-data" class="chart-no-data"></canvas>
                                                    <span class="text-gray-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">No Data</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <style>
        .chart-wrapper {
            width: 250px;
            height: 250px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chartData = @json($chartData);

            Object.keys(chartData).forEach(function(programId) {
                var data = chartData[programId];

                var ctxPeserta = document.getElementById('chart-peserta-' + programId)?.getContext('2d');
                if (ctxPeserta) {
                    new Chart(ctxPeserta, {
                        type: 'doughnut',
                        data: {
                            labels: ['Users', 'Guests'],
                            datasets: [{
                                label: 'Number of Participants',
                                data: [data.user_count, data.guest_count],
                                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)'],
                                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                datalabels: {
                                    formatter: (value, context) => {
                                        let percentage = (value * 100 / context.dataset.data.reduce((a, b) => a + b)).toFixed(1);
                                        return percentage + '%';
                                    }
                                }
                            }
                        }
                    });
                }

                var ctxSubmitted = document.getElementById('chart-attendance-' + programId)?.getContext('2d');
                if (ctxSubmitted) {
                    new Chart(ctxSubmitted, {
                        type: 'doughnut', // Update the type to 'line'
                        data: {
                            labels: ['Hadir', 'Tidak Hadir'],
                            datasets: [{
                                label: 'Rekod Kehadiran',
                                data: [data.submitted_attendance_count, data.not_submitted_attendance_count],
                                backgroundColor: ['rgba(75, 192, 192, 0.6)','rgba(156, 163, 175, 0.6)'],
                                borderColor: ['rgba(75, 192, 192, 1)','rgba(107, 114, 128, 0.6)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                datalabels: {
                                    formatter: (value, context) => {
                                        let percentage = (value * 100 / context.dataset.data.reduce((a, b) => a + b)).toFixed(1);
                                        return percentage + '%';
                                    }
                                }
                            }
                        }
                    });
                }

                var ctxGender = document.getElementById('chart-gender-' + programId)?.getContext('2d');
                if (ctxGender) {
                    new Chart(ctxGender, {
                        type: 'doughnut',
                        data: {
                            labels: ['Lelaki', 'Perempuan'],
                            datasets: [{
                                label: 'Gender Distribution',
                                data: Object.values(data.gender_counts),
                                backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                datalabels: {
                                    formatter: (value, context) => {
                                        let percentage = (value * 100 / context.dataset.data.reduce((a, b) => a + b)).toFixed(1);
                                        return percentage + '%';
                                    }
                                }
                            }
                        }
                    });
                }

                var ctxStates = document.getElementById('chart-states-' + programId)?.getContext('2d');
                if (ctxStates) {
                    new Chart(ctxStates, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data.user_states),
                            datasets: [{
                                label: 'Rekod Negeri',
                                data: Object.values(data.user_states).map((value, index) => value + data.guest_states[Object.keys(data.guest_states)[index]]),
                                backgroundColor: 'rgba(46, 204, 113, 0.6)',
                                borderColor: 'rgba(46, 204, 113, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: false
                                },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'end',
                                    formatter: (value, context) => {
                                        return value;
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
</x-admin-layout>
