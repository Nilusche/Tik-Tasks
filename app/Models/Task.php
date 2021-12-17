<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    
    use HasFactory;
    use \Conner\Tagging\Taggable;
    protected $fillable = ['id', 'title', 'description', 
    'comment', 'priority', 'estimatedEffort', 
    'totalEffort','completed', 'visibility', 'created_at',
     'updated_at', 'deadline', 'alarmdate','users_id','calendarICS',
     'calendarGoogle','calendarWebOutlook'];

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
  
    public function hasTag($tagId){
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }
}
