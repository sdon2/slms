<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTestQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function student_test()
    {
        return $this->belongsTo(StudentTest::class, 'student_test_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(TestQuestion::class, 'question_id', 'id');
    }

    public function marks()
    {
        $is_correct_answer = strcasecmp($this->question->correct_answer, $this->attributes['answer']) === 0;
        return $is_correct_answer ? $this->question->marks : 0;
    }
}
