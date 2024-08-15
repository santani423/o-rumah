<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Response;

class QRCodeController extends Controller
{
    public function generate()
    {
        $qrcode = QrCode::size(200)->generate('https://o-rumah.com');

        return view('qrcode', compact('qrcode'));
    }

    public function download()
    {
        $qrcodeImage = QrCode::format('png')->size(200)->generate('https://o-rumah.com');
        
        $filename = 'https://o-rumah.com/assets/logo-o-rumah.png';
        $path = public_path($filename);

        file_put_contents($path, $qrcodeImage);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function generateWithLogo()
    {
        // Buat QR code dan simpan sebagai gambar sementara
        $qrcodeImage = QrCode::format('png')->size(500)->generate('https://o-rumah.com');
        $qrcodePath = public_path('qrcode_temp.png');
        file_put_contents($qrcodePath, $qrcodeImage);

        // Buat instance gambar dari QR code
        $qrCode = Image::make($qrcodePath);

        // Tambahkan logo di tengah
        $logo = Image::make(public_path('logo.png'))->resize(100, 100);
        $qrCode->insert($logo, 'center');

        // Simpan gambar QR code dengan logo
        $qrCodeWithLogoPath = public_path('qrcode_with_logo.png');
        $qrCode->save($qrCodeWithLogoPath);

        // Hapus file sementara QR code tanpa logo
        unlink($qrcodePath);

        return response()->download($qrCodeWithLogoPath)->deleteFileAfterSend(true);
    }
}
