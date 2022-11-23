<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    const DAY = 7;

    protected $fillable = ['user_id', 'title', 'slug', 'description', 'start_date', 'end_date', 'image'];

    protected $appends = ['image_url', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image != null && Storage::exists($this->image) ? Storage::url($this->image) : '',
        );
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
        );
    }
    protected function description(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => nl2br($value),
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
        if($this->start_date > $today && $this->start_date <= Carbon::today()->addDays(7))
        {
            return '<span class="badge bg-primary">Latest Upcomming</span>';
        }
        else if($this->start_date > $today)
        {
            return '<span class="badge bg-primary">Upcomming</span>';
        }
        else if($this->start_date <= $today && $this->end_date >= $today)
        {
            return '<span class="badge bg-success">Running</span>';
        }
        else if($this->end_date < $today && $this->end_date >= Carbon::today()->subDays(7))
        {
            return '<span class="badge bg-danger">Earliest Finished</span>';
        }
        else if($this->end_date < $today)
        {
            return '<span class="badge bg-danger">Finished</span>';
        }
        else{
            return '';
        }
    }

    public function scopeRunning($query)
    {
        return $query->whereDate('start_date', '<=' , date('Y-m-d'))
        ->whereDate('end_date', '>=', date('Y-m-d'));
    }
    public function scopeUpcomming($query)
    {
        return $query->whereDate('start_date', '>' , date('Y-m-d'));
    }
    public function scopeFinished($query)
    {
        return $query->whereDate('end_date', '<' , date('Y-m-d'));
    }
    public function scopeLatestUpcomming($query)
    {
        return $query->whereDate('start_date', '>' , date('Y-m-d'))
        ->whereDate('start_date', '<=', Carbon::today()->addDays(self::DAY));
    }
    public function scopeEarliestFinish($query)
    {
        return $query->whereDate('end_date', '<' , date('Y-m-d'))
        ->whereDate('end_date', '>=', Carbon::today()->subDays(self::DAY));
    }
}
