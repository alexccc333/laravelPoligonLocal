<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogPost
 *
 * @package App\Models
 *
 * @property \App\Models\BlogCategory $category
 * @property \App\Models\User $user
 * @property string $title
 * @property string $slug
 * @property string $content_html
 * @property string $content_raw
 * @property string $excerpt
 * @property string $published_at
 * @property string $is_published
 */

class BlogPost extends Model
{
    use SoftDeletes;
    const UNKNOWN_USER = 1;
    protected $fillable = ['category_id','user_id','title','slug','content_html','content_raw','excerpt','published_at','is_published'];

    public function  category(){
        return $this->belongsTo(BlogCategory::class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    }
}
