<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['title','description','user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
    protected function getHumanReadableDateAttribute()
    {
        return $this->created_at->format('j-F-Y, g:i A');
    }
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string|null $value) => $value?asset('storage/'.$value):null,
//            set: fn (string $value) => Storage::disk('public')->putFile('images',$value)
            set: fn (string $value) => $value
        );
//        if ($this->image && Storage::disk('public')->exists($this->image))
//            return asset('storage/'.$this->image);
//        return null;

    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }



}
