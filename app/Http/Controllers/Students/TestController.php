<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\StudentTest;
use App\Models\StudentTestQuestion;
use App\Models\Test;
use App\Models\TestQuestion;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use PDOException;
use stdClass;

class TestController extends Controller
{
    public function index()
    {
        $completed = StudentTest::where('student_id', Auth::user()->id)->pluck('test_id')->toArray();

        $tests = Test::whereNotIn('id', $completed)->latest()->get()->transform(function ($test) {
            $result = new stdClass;
            $result->id = $test->id;
            $result->test_title = $test->test_title;
            $result->questions = $test->questions->count();
            $result->marks = $test->questions->sum('marks');
            $result->created_at = $test->created_at->diffForHumans();
            return $result;
        });
        return view('students.tests.index', ['tests' => $tests]);
    }

    public function results()
    {
        $completed = StudentTest::where('student_id', Auth::user()->id)->pluck('test_id')->toArray();

        $tests = Test::whereIn('id', $completed)->latest()->get()->transform(function ($test) {
            $result = new stdClass;
            $result->id = $test->id;
            $result->test_title = $test->test_title;
            $result->questions = $test->questions->count();
            $result->marks = $test->questions->sum('marks');

            $student_test = StudentTest::where('test_id', $test->id)->first();
            $result->student_test_id = $student_test->id;
            $result->created_at = $student_test->created_at->diffForHumans();
            $result->marks_obtained = 0;
            foreach($student_test->questions as $q) $result->marks_obtained += $q->marks();

            return $result;
        });
        return view('students.tests.results', ['tests' => $tests]);
    }

    public function take(Request $request, $id)
    {
        $test = Test::findOrFail($id);
        return view('students.tests.take-test', ['test' => $test]);
    }

    public function view(Request $request, $id)
    {
        $student_test = StudentTest::findOrFail($id);

        $test = new stdClass;

        $test->id = $student_test->test_id;
        $test->title = $student_test->test->test_title;

        $test->questions = $student_test->questions->transform(function ($question) {
            $result = new stdClass;
            $result->id = $question->question_id;
            $result->question = $question->question->question;
            $result->marks = $question->question->marks;
            $result->your_answer = $question->answer;
            $result->correct_answer = $question->question->correct_answer;
            $result->marks_obtained = $question->marks();
            return $result;
        });

        $test->total_marks = collect($test->questions)->sum('marks_obtained');

        return view('students.tests.view', ['test' => $test]);
    }

    public function store(Request $request, $id)
    {
        $test = Test::findOrFail($id);

        $questions = $test->questions;

        $data = $this->validate($request, [
            'answers.*' => ['required', 'string', 'min:5', 'max:255'],
        ]);

        if (count($data['answers']) !== $questions->count()) {
            throw new Exception('Invalid request', 500);
        }

        try {
            DB::beginTransaction();

            $student_test = StudentTest::create([
                'test_id' => $test->id,
                'student_id' => Auth::user()->id,
            ]);

            $answers = $this->prepareAnswers($student_test->id, $questions->pluck('id'), $data['answers']);

            StudentTestQuestion::insert($answers);

            DB::commit();

            $request->session()->flash('status', 'Test saved successfully');
            return redirect()->route('students.tests.index');
        }
        catch (Exception $ex) {
            DB::rollBack();

            throw $ex;
        }
    }

    protected function prepareAnswers($test_id, $question_ids, $answers)
    {
        $result = [];

        for($i = 0; $i < count($question_ids); $i++) {
            $question = [
                'student_test_id' => $test_id,
                'question_id' => $question_ids[$i],
                'answer' => $answers[$i],
            ];
            array_push($result, $question);
        }

        return $result;
    }
}
