<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertiser_name',
        'company_name',
        'email',
        'phone',
        'placement_spot',
        'budget_range',
        'banner_image',
        'message',
        'status',
    ];

    public function getBannerUrlAttribute(): ?string
    {
        if ($this->banner_image) {
            return asset($this->banner_image);
        }
        return null;
    }
}
