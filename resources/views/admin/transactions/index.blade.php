@extends('layouts.admin')

@section('title', 'Laporan Transaksi')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Rekap seluruh transaksi pembelian tiket')

@section('content')
<div class="p-6 w-full">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Laporan Transaksi</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar transaksi pembelian tiket event</p>
        </div>

        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            Export Laporan
        </button>
    </div>

    <!-- DATA DUMMY -->
    @php
    $transactions = [
    ['name' => 'Donni Prabowo','email' => 'donni@example.com','event' => 'Jazz Night 2024','status' => 'Success','total' => 155000],
    ['name' => 'Maya Sari','email' => 'maya@example.com','event' => 'AI Workshop','status' => 'Pending','total' => 55000],
    ['name' => 'Budi Santoso','email' => 'budi@example.com','event' => 'Hackathon 2024','status' => 'Free','total' => 0],
    ];

    $success = collect($transactions)->where('status','Success')->count();
    $pending = collect($transactions)->where('status','Pending')->count();
    $free = collect($transactions)->where('status','Free')->count();
    @endphp

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">

            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Event</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Total</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($transactions as $i => $trx)
                <tr class="hover:bg-slate-50">

                    <td class="px-6 py-4 text-slate-400 font-semibold">
                        {{ $i + 1 }}
                    </td>

                    <td class="px-6 py-4 font-bold text-slate-800 uppercase">
                        {{ $trx['name'] }}
                    </td>

                    <td class="px-6 py-4 text-slate-500 text-xs">
                        {{ $trx['email'] }}
                    </td>

                    <td class="px-6 py-4 text-slate-700">
                        {{ $trx['event'] }}
                    </td>

                    <td class="px-6 py-4">
                        @if($trx['status'] == 'Success')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">Success</span>
                        @elseif($trx['status'] == 'Pending')
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold">Pending</span>
                        @else
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold">Free</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 font-bold text-indigo-600">
                        Rp {{ number_format($trx['total'],0,',','.') }}
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- CHART SECTION -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

        <!-- BAR CHART -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <h2 class="text-lg font-bold mb-4 text-slate-700">Transaksi per Status</h2>
            <canvas id="barChart"></canvas>
        </div>

        <!-- PIE CHART -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <h2 class="text-lg font-bold mb-4 text-slate-700">Distribusi Status</h2>
            <canvas id="pieChart"></canvas>
        </div>

    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const success = @json($success);
    const pending = @json($pending);
    const free = @json($free);

    // BAR CHART
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Success', 'Pending', 'Free'],
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [success, pending, free],
                backgroundColor: ['#22c55e', '#f59e0b', '#64748b']
            }]
        }
    });

    // PIE CHART
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Success', 'Pending', 'Free'],
            datasets: [{
                data: [success, pending, free],
                backgroundColor: ['#22c55e', '#f59e0b', '#64748b']
            }]
        }
    });
</script>

@endsection