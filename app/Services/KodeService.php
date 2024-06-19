<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\Bank;
use App\Models\UserClickAdsHistory;

trait KodeService
{
    private function KodeIklan($kdIklan='',$jenisIklan='',$tanggal,$urutan='') {
        $kodeIklan = strtolower($kdIklan);
        if ($kodeIklan == 'property') {
            $kodeIklan = 'P';
        } elseif ($kodeIklan == 'food') {
            $kodeIklan = 'F';
        } elseif ($kodeIklan == 'merchant') {
            $kodeIklan = 'M';
        } elseif ($kodeIklan == 'lbh') {
            $kodeIklan = 'L';
        } elseif ($kodeIklan == 'notaris') {
            $kodeIklan = 'N';
        } elseif ($kodeIklan == 'lelang') {
            $kodeIklan = 'L';
        }
        $jenisIklan = strtolower($jenisIklan);

switch ($jenisIklan) {
    case 'jual':
        $kodeJenisIklan = 1;
        break;
    case 'beli':
        $kodeJenisIklan = 2;
        break;
    case 'sewa':
        $kodeJenisIklan = 3;
        break;
    default:
        $kodeJenisIklan = "Jenis iklan tidak dikenali";
}



    // Format urutan untuk selalu lima digit
    $urutanFormatted = str_pad($urutan, 5, '0', STR_PAD_LEFT);
    $timestamp = strtotime($tanggal);

        // Mengambil tahun dan bulan dari timestamp
        $tahun = date("Y", $timestamp);
        $bulan = date("m", $timestamp);
    // Format tahun dan bulan untuk selalu dua digit
    $tahunFormatted = substr($tahun, -2);
    $bulanFormatted = str_pad($bulan, 2, '0', STR_PAD_LEFT);
    // Gabungkan semua bagian untuk membuat kode iklan lengkap
    $kodeIklanLengkap = $kodeIklan . $kodeJenisIklan . $tahunFormatted . $bulanFormatted . $urutanFormatted;

    return $kodeIklanLengkap;
        
    }

    private function kodeIklanLelang($kodeIklan, $bankId, $tanggal, $urutan){
        $kodeIklan = strtolower($kodeIklan);
        if ($kodeIklan == 'property') {
            $kodeIklan = 'P';
        } elseif ($kodeIklan == 'food') {
            $kodeIklan = 'F';
        } elseif ($kodeIklan == 'merchant') {
            $kodeIklan = 'M';
        } elseif ($kodeIklan == 'lbh') {
            $kodeIklan = 'L';
        } elseif ($kodeIklan == 'notaris') {
            $kodeIklan = 'N';
        } elseif ($kodeIklan == 'lelang') {
            $kodeIklan = 'L';
        }
        
        // Mengambil data bank berdasarkan ID
        $bank = Bank::whereId($bankId)->first();
        
        // Menentukan jenis bank
        switch (strtolower($bank->type)) {
            case 'umum':
                $jenisBank = 1;
                break;
            case 'bpr':
                $jenisBank = 2;
                break;
            case 'financing':
                $jenisBank = 3;
                break;
            default:
                $jenisBank = 0;
                break;
        }
        
        // Format urutan untuk selalu lima digit
        $urutanFormatted = str_pad($urutan, 5, '0', STR_PAD_LEFT);
        
        // Mengubah string tanggal menjadi timestamp
        $timestamp = strtotime($tanggal);
        
        // Mengambil tahun dan bulan dari timestamp
        $tahun = date("Y", $timestamp);
        $bulan = date("m", $timestamp);
        
        // Format tahun dan bulan untuk selalu dua digit
        $tahunFormatted = substr($tahun, -2);
        $bulanFormatted = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        
        // Gabungkan semua bagian untuk membuat kode iklan lengkap
        $kodeIklanLelangLengkap = $kodeIklan.$jenisBank.$tahunFormatted.$bulanFormatted.$urutanFormatted;
        
        return $kodeIklanLelangLengkap;
    }
    
}