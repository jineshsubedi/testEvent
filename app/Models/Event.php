<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'description', 'start_date', 'end_date', 'image'];

    protected $appends = ['image_url', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::exists($this->image) ? Storage::url($this->image) : '',
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getEventStatus(),
        );
    }
    private function getEventStatus()
    {
        $today = Date('Y-m-d');
        if($this->start_date > $today)
        {
            return '<span class="badge bg-primary">Upcomming</span>';
        }else if($this->start_date <= $today && $this->end_date >= $today)
        {
            return '<span class="badge bg-primary">Running</span>';
        }else if($this->end_date < $today)
        {
            return '<span class="badge bg-primary">Finished</span>';
        }
        else{
            return '';
        }
    }
}
