<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model { protected $fillable=['name','type','color','is_archived']; protected function casts(): array { return ['is_archived'=>'boolean']; } public function user(){return $this->belongsTo(User::class);} }
