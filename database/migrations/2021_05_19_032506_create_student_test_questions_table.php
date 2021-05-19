<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_test_id')->references('id')->on('student_tests')->cascadeOnDelete();
            $table->foreignId('question_id')->references('id')->on('test_questions')->cascadeOnDelete();
            $table->string('answer', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_test_questions');
    }
}
