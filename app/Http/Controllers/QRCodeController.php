<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeController extends Controller
{
    public function generate($text)
    {
        $result = Builder::create()
            ->writer(new PngWriter()) // Gunakan GD writer, bukan Imagick
            ->data($text) // Data yang dimasukkan ke QR code
            ->size(300)
            ->margin(10)
            ->build();

        return response($result->getString())
            ->header('Content-Type', $result->getMimeType());
    }
}
