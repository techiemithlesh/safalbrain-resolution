<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    
    protected $fillable = [
        'page_name',
        'subtitle',
        'non_target_text',
        'main_title',
        'highlighted_text'
    ];

    
}
