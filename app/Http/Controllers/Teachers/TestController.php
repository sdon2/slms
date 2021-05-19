<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Models\StudentTest;
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
        $tests = Test::where('teacher_id', Auth()->user()->id)->latest()->get()->transform(function ($test) {
            $result = new stdClass;
            $result->id = $test->id;
            $result->test_title = $test->test_title;
            $result->questions = $test->questions->count();
            $result->marks = $test->questions->sum('marks');
            $result->created_at = $test->created_at->diffForHumans();
            return $result;
        });
        return view('teachers.tests.index', ['tests' => $tests]);
    }

    public function results()
    {
        $completed = StudentTest::all()->pluck('test_id')->toArray();

        $tests = Test::where('teacher_id', Auth::user()->id)->whereIn('id', $completed)->latest()->get()->transform(function ($test) {
            $result = new stdClass;
            $result->id = $test->id;
            $result->test_title = $test->test_title;
            $result->questions = $test->questions->count();
            $result->marks = $test->questions->sum('marks');

            $student_test = StudentTest::where('test_id', $test->id)->first();
            $result->student_name = $student_test->student->name;
            $result->created_at = $student_test->created_at->diffForHumans();
            $result->marks_obtained = 0;
            foreach($student_test->questions as $q) $result->marks_obtained += $q->marks();

            return $result;
        });
        return view('teachers.tests.results', ['tests' => $tests]);
    }

    public function add()
    {
        return view('teachers.tests.add');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'test_title' => ['required', 'string', 'min:5', 'max:255'],
            'questions.*' => ['required', 'string', 'min:5', 'max:255'],
            'answers.*' => ['required', 'string', 'min:5', 'max:255'],
            'marks.*' => ['required', 'numeric', 'in:5,10'],
        ]);

        try {
            DB::beginTransaction();

            $test = Test::create([
                'test_title' => $data['test_title'],
                'teacher_id' => Auth::user()->id,
            ]);

            $questions = $this->prepareQuestions($test->id, $data['questions'], $data['answers'], $data['marks']);

            TestQuestion::insert($questions);

            DB::commit();

            $request->session()->flash('status', 'Question added successfully');
            return redirect()->route('teachers.tests.index');
        }
        catch (Exception $ex) {
            DB::rollBack();

            throw $ex;
        }
    }

    protected function prepareQuestions($test_id, $questions, $answers, $marks)
    {
        $result = [];

        for($i = 0; $i < count($questions); $i++) {
            $question = [
                'test_id' => $test_id,
                'question' => $questions[$i],
                'correct_answer' => $answers[$i],
                'marks' => $marks[$i],
            ];
            array_push($result, $question);
        }

        return $result;
    }
}
