@extends('layouts.app-students')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Take Test') }}</div>
                        <div><a class="btn btn-primary" href="{{ route('students.tests.index') }}">Back</a></div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('students.tests.store', ['id' => $test->id]) }}">
                        @csrf
                        <div class="form-group">
                            <h4>{{ $test->test_title }}</h4>
                        </div>

                        <div class="py-2">
                            <div class="d-flex justify-content-between align-items-center pb-2">
                                <h4 class="pb-2">Questions</h4>
                            </div>
                            @foreach ($test->questions as $question)
                                <div class="px-2 py-2 border rounded mb-2 @if($loop->index % 2 === 0) bg-dark text-white @else bg-light text-black @endif">
                                    <div class="d-flex justify-content-between align-items-center pb-2">
                                        <div>Question <strong>#{{ $loop->index + 1 }}</strong></div>
                                    </div>
                                    <div class="form-group">
                                        <strong>{{ $question->question }}</strong>
                                    </div>
                                    <div class="form-group">
                                        <label>Answer</label>
                                        <input type="text" name="answers[]" class="form-control" placeholder="Your Answer">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
