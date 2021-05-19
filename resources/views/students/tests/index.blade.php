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
                                            <svg viewBox="0 0 64 64" style="width:2rem;height:2rem;" xmlns="http://www.w3.org/2000/svg"><g data-name="Layer 7"><path d="M2 2h46v60H2z" fill="#c7e2fb"/><path d="M2 46.63A30.28 30.28 0 0011 48c18.78 0 34-17.24 34-38.5a44 44 0 00-.65-7.5H2z" fill="#ebf7fe"/><path d="M7 6h36v16H7z" fill="#c1c8d1"/><g fill="#f7d881"><path d="M6 28h6v6H6zM6 38h6v6H6zM6 48h6v6H6z"/></g><path d="M33.988 43.002l23.996-23.996 4.002 4.002L37.99 47.004z" fill="#a0a8b2"/><path d="M34 43l-3 7 7-3zM53.985 23.005l4.002-4.002 4.002 4.002-4.002 4.002z" fill="#c1c8d1"/><path d="M10 11h2v8h2v-8h2V9h-6zM34 11h2v8h2v-8h2V9h-6zM18 10v8a1 1 0 001 1h5v-2h-4v-2h4v-2h-4v-2h4V9h-5a1 1 0 00-1 1zM26 12a3 3 0 003 3 1 1 0 010 2h-3v2h3a3 3 0 000-6 1 1 0 010-2h3V9h-3a3 3 0 00-3 3z"/><path d="M7 23h36a1 1 0 001-1V6a1 1 0 00-1-1H7a1 1 0 00-1 1v16a1 1 0 001 1zM8 7h34v14H8zM6 35h6a1 1 0 001-1v-5.59l2.71-2.7-1.42-1.42-2.7 2.71H6a1 1 0 00-1 1v6a1 1 0 001 1zm5-2H8.41L11 30.41zm-1.41-4L7 31.59V29zM12 47H6a1 1 0 00-1 1v6a1 1 0 001 1h6a1 1 0 001-1v-6a1 1 0 00-1-1zm-1 6H7v-4h4zM13.29 35.29L11.59 37H6a1 1 0 00-1 1v6a1 1 0 001 1h6a1 1 0 001-1v-5.59l1.71-1.7zM9.59 39L7 41.59V39zM11 43H8.41L11 40.41zM15 28h29v2H15zM15 48h13v2H15zM15 52h29v2H15z"/><path d="M62.71 22.29l-4-4a1 1 0 00-1.42 0L49 26.59V2a1 1 0 00-1-1H2a1 1 0 00-1 1v60a1 1 0 001 1h46a1 1 0 001-1V37.41l13.71-13.7a1 1 0 000-1.42zM34.34 44.75l1.91 1.91-3.35 1.44zM35.41 43L54 24.41 56.59 27 38 45.59zM47 61H3V3h44v25.59L43.59 32H15v2h26.59l-4 4H15v2h20.59l-2 2H15v2h17.48l-2.4 5.61A1 1 0 0031 51a1 1 0 00.39-.08l7-3a1.11 1.11 0 00.32-.21l8.29-8.3zm11-35.41L55.41 23 58 20.41 60.59 23z"/></g></svg>
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


