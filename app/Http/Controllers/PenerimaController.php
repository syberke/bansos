<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
class PenerimaController extends Controller
{

    private $spreadsheetApi = 'https://script.google.com/macros/s/AKfycbznOvrrQNDBlxQ1wlhMekYI-3TUomUaRmZSUJG3-k1GF7EcoZCCzqV40C6CpbqdqdFq/exec';
    public function index()
    {
        $response = Http::get($this->spreadsheetApi);

        if ($response->successful()) {
            $penerimas = $response->json();

            // Jika datanya ada di key tertentu (misal "data"), sesuaikan:
            // $penerimas = $response->json()['data'];

            return view('penerima.index', compact('penerimas'));
        }

        return back()->with('error', 'Gagal mengambil data dari Spreadsheet');
    }

    public function create()
    {
        return view('penerima.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_sekolah' => 'required',
            'tingkat' => 'required|in:SD,SMP',
            'kelas' => 'required',
            'alamat' => 'required',
        ]);

        $validated['kode_unik'] = strtoupper(Str::random(10));
        Penerima::create($validated);

        return redirect()->route('penerima.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(Penerima $penerima)
    {
        return view('penerima.edit', compact('penerima'));
    }

    public function update(Request $request, Penerima $penerima)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'nama_sekolah' => 'required',
            'tingkat' => 'required|in:SD,SMP',
            'kelas' => 'required',
            'alamat' => 'required',
            'status' => 'required|boolean',
        ]);

        $penerima->update($validated);
        return redirect()->route('penerima.index')->with('success', 'Data berhasil diupdate!');
    }

    public function exportBarcode($kode)
    {
        $response = Http::get($this->spreadsheetApi);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data dari Spreadsheet');
        }

        $dataList = $response->json();

        // Cari data penerima berdasarkan kode_unik
        $penerima = collect($dataList)->firstWhere('kode_unik', $kode);

        if (!$penerima || !isset($penerima['kode_unik']) || !is_string($penerima['kode_unik'])) {
            return back()->with('error', 'Data tidak ditemukan atau kode tidak valid.');
        }

        $writer = new PngWriter();
        $qrCode = new QrCode($penerima['kode_unik']);
        $qrResult = $writer->write($qrCode);

        $qrImage = imagecreatefromstring($qrResult->getString());

        $width = 400;
        $height = 300;
        $canvas = imagecreatetruecolor($width, $height);

        $white = imagecolorallocate($canvas, 255, 255, 255);
        $black = imagecolorallocate($canvas, 0, 0, 0);
        imagefilledrectangle($canvas, 0, 0, $width, $height, $white);

        imagecopyresampled($canvas, $qrImage, 20, 70, 0, 0, 150, 150, imagesx($qrImage), imagesy($qrImage));
        imagestring($canvas, 5, 20, 20, 'QR Penerima Bansos', $black);
        imagestring($canvas, 4, 20, 50, 'Nama: ' . ($penerima['nama_lengkap'] ?? '-'), $black);
        imagestring($canvas, 4, 20, 230, 'Kode: ' . $penerima['kode_unik'], $black);

        $filename = storage_path('app/public/barcode_' . $penerima['kode_unik'] . '.png');
        imagepng($canvas, $filename);
        imagedestroy($qrImage);
        imagedestroy($canvas);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
    

    public function exportAllBarcode()
    {
        $penerimas = Penerima::all();

        if ($penerimas->isEmpty()) {
            return back()->with('success', 'Tidak ada data untuk diexport.');
        }

        $tempDir = storage_path('app/qrcards');
        File::ensureDirectoryExists($tempDir);
        File::cleanDirectory($tempDir);

        $writer = new PngWriter();

        foreach ($penerimas as $p) {
            $qrCode = new QrCode($p->kode_unik);
            $qrResult = $writer->write($qrCode);

            $qrImage = imagecreatefromstring($qrResult->getString());

            $width = 400;
            $height = 300;
            $canvas = imagecreatetruecolor($width, $height);

            $white = imagecolorallocate($canvas, 255, 255, 255);
            $black = imagecolorallocate($canvas, 0, 0, 0);
            imagefilledrectangle($canvas, 0, 0, $width, $height, $white);

            imagecopyresampled($canvas, $qrImage, 20, 70, 0, 0, 150, 150, imagesx($qrImage), imagesy($qrImage));
            imagestring($canvas, 5, 20, 20, 'QR Penerima Bansos', $black);
            imagestring($canvas, 4, 20, 50, 'Nama: ' . $p->nama_lengkap, $black);
            imagestring($canvas, 4, 20, 230, 'Kode: ' . $p->kode_unik, $black);

            $filename = $tempDir . '/' . $p->kode_unik . '_card.png';
            imagepng($canvas, $filename);
            imagedestroy($qrImage);
            imagedestroy($canvas);
        }

        // ZIP
        $zipPath = storage_path('app/qrcards.zip');
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach (File::files($tempDir) as $file) {
                $zip->addFile($file->getPathname(), $file->getFilename());
            }
            $zip->close();
        } else {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
