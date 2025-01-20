<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageContent extends Model
{
    protected $fillable = [
        'main_title',
        'subtitle',
        'getting_started_title',
        'steps',
        'book_call_button_text'
    ];

    protected $casts = [
        'steps' => 'array'
    ];

    public function getFormattedSteps()
    {
        return collect($this->steps)->map(function ($step, $index) {
            return [
                'number' => $index + 1,
                'title' => $step['title'],
                'description' => $step['description']
            ];
        });
    }
}
