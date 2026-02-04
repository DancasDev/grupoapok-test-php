<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Carbon\Carbon;

class Node extends Model
{
    use HasRecursiveRelationships;

    protected $fillable = ['parent'];
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    public function getParentKeyName() {
        return 'parent';
    }

    protected static function booted() {
        static::creating(function ($node) {            
            $nextId = (static::max('id') ?? 0) + 1;
            $node->title = __("numbers.{$nextId}", [], 'en');
        });
    }

    protected function title(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => __("numbers.{$attributes['id']}"),
        );
    }

    protected function createdAt(): Attribute {
        return Attribute::make(
            get: function ($value) {
                if (!$value) return null;

                $tz = request()->header('X-Timezone', 'UTC');
                return Carbon::parse($value, 'UTC')
                    ->setTimezone($tz)
                    ->format('Y-m-d H:i:s');
            },
        );
    }
}
