<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }
}
