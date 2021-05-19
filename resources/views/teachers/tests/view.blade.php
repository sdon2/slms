@extends('layouts.app-teachers')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Test Result') }}</div>
                        <div><a class="btn btn-primary" href="{{ route('students.tests.results') }}">Back</a></div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <h4>Student Name: {{ $test->student_name }}</h4>
                        <h4>Test: {{ $test->title }}</h4>
                    </div>

                    <div class="py-2">
                        <div class="d-flex justify-content-between align-items-center pb-2">
                            <h4 class="pb-2">Questions</h4>
                        </div>
                        @foreach ($test->questions as $question)
                            <div class="px-2 py-2 border rounded mb-2 bg-dark text-white">
                                <div class="d-flex justify-content-between align-items-center pb-2">
                                    <div>Question <strong>#{{ $loop->index + 1 }}</strong></div>
                                </div>
                                <div class="form-group">
                                    <strong>{{ $question->question }}</strong>
                                </div>
                                <div class="form-group px-2 py-2" style="background: #ffffff;color:#222222;">
                                    <div>Student's Answer: <span style="font-weight:bold; font-size: 1rem" class="@if($question->marks_obtained > 0) text-success @else text-danger @endif"> {{ $question->your_answer }}</span></div>
                                    <div>Correct Answer: {{ $question->correct_answer }}</div>
                                    <div>Marks: {{ $question->marks_obtained }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4">
                        <h4>Total Marks Obtained: {{ $test->total_marks }}</h4>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
