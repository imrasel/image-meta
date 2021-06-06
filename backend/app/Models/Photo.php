<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    public const COPYRIGHT_KEYS = ['Copyright', 'UserComment', 'Artist', 'OwnerName', 'Author'];
    public const CAMERA_KEYS = ['Make', 'Model', 'ExposureTime', 'ApertureValue', 'FocalLength', 'ISOSpeedRatings', 'Flash'];
    public const EXCEPT_KEYS = ['COMPUTED', 'THUMBNAIL'];

    protected $fillable = ['url', 'camera', 'copyrights', 'exifs'];
}
