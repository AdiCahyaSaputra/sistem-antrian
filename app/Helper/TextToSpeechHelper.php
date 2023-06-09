<?php

namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Helper\AntrianHelper;
use Illuminate\Http\Request;

class TextToSpeechHelper
{
  private static function getTranscriptionID(string $text)
  {
    $response = Http::withHeaders([
      'AUTHORIZATION' => env('AUTHORIZATION'),
      'X-USER-ID' => env('USER_ID'),
      'Accept' => 'application/json',
      'Content-Type' => 'application/json',
    ])->post('https://play.ht/api/v1/convert', [
      'content' => [$text],
      'voice' => 'id-ID-Standard-A',
      'globalSpeed' => '65%'
    ]);

    $data = $response->json();

    return $data['transcriptionId'];
  }

  private static function getDownloadUrl(string $transcriptionId)
  {
    $response = Http::withHeaders([
      'AUTHORIZATION' => env('AUTHORIZATION'),
      'X-USER-ID' => env('USER_ID'),
      'Accept' => 'application/json',
      'Content-Type' => 'application/json',
    ])->get('https://play.ht/api/v1/articleStatus?transcriptionId=' . $transcriptionId);


    $data = $response->json();

    if (!$data['converted']) {
      return self::getDownloadUrl($transcriptionId);
    }

    if (!empty($data['audioUrl'])) {
      return $data['audioUrl'];
    }

    return self::getDownloadUrl($transcriptionId);
  }

  private static function transformTextToSpeech(string $text)
  {
    $transcriptionId = self::getTranscriptionID($text);
    $audioUrl = self::getDownloadUrl($transcriptionId);

    $fileName = Str::random() . '.mp3';
    $pathToFile = storage_path('app/public/audio/' . $fileName);

    $audio = file_get_contents($audioUrl);
    file_put_contents($pathToFile, $audio);

    return 'storage/audio/' . $fileName;
  }

  public static function insertSpaceBeforeNumber(string $kode_nomor_antrian)
  {
    $splitted = str_split($kode_nomor_antrian);

    $splitted[0] = $splitted[0] . ' ';
    $kode_nomor_antrian = join('', $splitted);

    return $kode_nomor_antrian;
  }

  public static function getAudioPath(int $nomor_antrian, string|null $jenjang)
  {
    $kode_antrian = AntrianHelper::getKodeAntrian($jenjang);
    $kode_nomor_antrian = AntrianHelper::generateNomorAntrian($kode_antrian, $nomor_antrian);

    $antrian = DB::table('antrians')
      ->where('nomor_antrian', $nomor_antrian)
      ->where('kode_antrian', $kode_antrian)
      ->whereNotNull('audio_path')
      ->orderBy('tanggal_pendaftaran', 'asc')
      ->first('audio_path');

    $loket = is_null($jenjang) ? 'Bendahara' : strtoupper($jenjang);
    $loket = $jenjang === 'seragam' ? 'Seragam' : $loket;

    $kode_nomor_antrian = self::insertSpaceBeforeNumber($kode_nomor_antrian);

    $audio_path = $antrian->audio_path ?? self::transformTextToSpeech('Antrian nomor ' . $kode_nomor_antrian . ' menuju loket ' . $loket);

    return $audio_path;
  }
}
