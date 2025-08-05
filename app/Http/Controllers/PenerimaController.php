<?php

namespace App\Http\Controllers;

use App\Models\Penerima;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\Response;
use ZipArchive;
use Illuminate\Support\Facades\File;

class PenerimaController extends Controller
{
    public function index()
    {
        $penerimas = Penerima::all();
        return view('penerima.index', compact('penerimas'));
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



    public function exportBarcode(Penerima $penerima)
    {
        $qrCode = new QrCode($penerima->kode_unik); // isi QR code

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return response($result->getString())
            ->header('Content-Type', $result->getMimeType())
            ->header('Content-Disposition', 'attachment; filename="barcode_' . $penerima->kode_unik . '.png"');
    }

    public function exportAllBarcode()
    {
        $penerimas = Penerima::all();

        if ($penerimas->isEmpty()) {
            return back()->with('success', 'Tidak ada data untuk diexport.');
        }

        $tempDir = storage_path('app/qrcodes');
        File::ensureDirectoryExists($tempDir);

        // Kosongkan folder QR sebelumnya
        File::cleanDirectory($tempDir);

        $writer = new PngWriter();

        foreach ($penerimas as $p) {
            $qrCode = new QrCode($p->kode_unik);
            $result = $writer->write($qrCode);
            $filename = $tempDir . '/' . $p->kode_unik . '.png';
            file_put_contents($filename, $result->getString());
        }

        // Buat file ZIP
        $zipPath = storage_path('app/qrcodes.zip');
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
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
