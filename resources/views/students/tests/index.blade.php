@extends('layouts.app-students')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Tests') }}</div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (count($tests) > 0)

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">No. of Questions</th>
                                <th scope="col">Total Marks</th>
                                <th scope="col">Created</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tests as $test)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $test->test_title }}</td>
                                    <td>{{ $test->questions }}</td>
                                    <td>{{ $test->marks }}</td>
                                    <td>{{ $test->created_at }}</td>
                                    <td>
                                        <a href="{{ route('students.tests.take', ['id' => $test->id]) }}" title="Take Test">
                                            <img src="{{ asset('images/test.png') }}" alt="Take Test" style="width:2rem;height:2rem;"/>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @else
                        {{ __('No tests found!') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


