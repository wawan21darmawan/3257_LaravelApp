@extends('layouts.app') {{-- Sesuaikan dengan nama layout dashboard organizer-mu --}}

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="bg-indigo-600 px-6 py-4 text-center">
            <h2 class="text-2xl font-black text-white">Scanner Tiket</h2>
            <p class="text-indigo-200 text-sm mt-1 font-medium">{{ $event->title }}</p>
        </div>
        
        <div class="p-6">
            <!-- Peringatan Akses Kamera -->
            <p class="text-center text-gray-500 text-sm mb-4">
                Pastikan Anda memberikan izin akses kamera pada browser. Sorot QR Code pada E-Ticket peserta ke arah kotak di bawah ini.
            </p>

            <!-- Container Kamera (Otomatis dirender oleh JS) -->
            <div id="reader" class="mx-auto rounded-lg overflow-hidden border-2 border-dashed border-indigo-300"></div>
            
            <!-- Area Hasil Scan (Awalnya disembunyikan) -->
            <div id="result-container" class="mt-6 hidden flex-col items-center">
                <div id="alert-box" class="w-full p-4 rounded-lg mb-4 text-center text-lg font-bold">
                    <!-- Pesan sukses/gagal akan muncul di sini -->
                </div>
                
                <!-- Tombol Lanjut Scan -->
                <button id="resume-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                    📷 Scan Tiket Berikutnya
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Library HTML5 QR Code -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfigurasi Scanner
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { 
                fps: 10, 
                qrbox: {width: 250, height: 250},
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
            },
            /* verbose= */ false
        );

        const resultContainer = document.getElementById('result-container');
        const alertBox = document.getElementById('alert-box');
        const resumeBtn = document.getElementById('resume-btn');
        
        let isProcessing = false;

        // Fungsi saat QR Code berhasil terbaca
        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return; // Mencegah scan dobel secara tidak sengaja
            isProcessing = true;

            // Hentikan sementara kamera
            html5QrcodeScanner.pause();
            
            // Tampilkan status loading UI
            resultContainer.classList.remove('hidden');
            alertBox.className = 'w-full p-4 rounded-lg mb-4 text-center text-lg font-bold bg-yellow-100 text-yellow-800 border border-yellow-200';
            alertBox.innerHTML = '<span class="animate-pulse">⏳ Memverifikasi tiket...</span>';

            // Kirim data ke backend (CheckInController@process)
            fetch("{{ route('organizer.scanner.process') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    order_id: decodedText,
                    event_id: {{ $event->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Jika sukses dan belum pernah di-scan
                    alertBox.className = 'w-full p-4 rounded-lg mb-4 text-center text-lg font-bold bg-green-100 text-green-800 border border-green-200';
                    alertBox.innerHTML = '✅ Berhasil!<br><span class="text-sm font-normal">' + data.message + '</span>';
                } else {
                    // Jika gagal (tidak valid atau sudah dipakai)
                    alertBox.className = 'w-full p-4 rounded-lg mb-4 text-center text-lg font-bold bg-red-100 text-red-800 border border-red-200';
                    alertBox.innerHTML = '❌ Ditolak!<br><span class="text-sm font-normal">' + data.message + '</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alertBox.className = 'w-full p-4 rounded-lg mb-4 text-center text-lg font-bold bg-red-100 text-red-800 border border-red-200';
                alertBox.innerHTML = '⚠️ Terjadi kesalahan jaringan. Coba lagi.';
            });
        }

        function onScanFailure(error) {
            // Dikosongkan agar kamera tidak terus-menerus memunculkan error saat mencari kotak QR
        }

        // Mulai jalankan kamera
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        // Aksi tombol "Scan Tiket Berikutnya"
        resumeBtn.addEventListener('click', () => {
            resultContainer.classList.add('hidden');
            isProcessing = false;
            html5QrcodeScanner.resume(); // Nyalakan kamera kembali
        });
    });
</script>
@endsection