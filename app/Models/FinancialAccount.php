<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FinancialAccount extends Model { protected $fillable=['name','type','initial_balance','color','is_archived']; protected function casts(): array { return ['initial_balance'=>'decimal:2','is_archived'=>'boolean']; } public function user(){return $this->belongsTo(User::class);} }
