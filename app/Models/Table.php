<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;

class Table extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['number', 'image'];

    public function generateQr()
    {
        // $url = url('/?table=' . $this->number); // homepage link with table number
        $url = route('table.redirect', ['number' => $this->number]);
        $path = "qr_codes/{$this->number}.png";
        $fullPath = Storage::disk('public')->path($path);

        // Ensure the directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Generate QR code directly using Simple QrCode (no Imagick)
        QrCode::format('png')->size(300)->generate($url, $fullPath);

        // Save the path in DB
        $this->updateQuietly(['image' => $path]);
    }

    
    
}
