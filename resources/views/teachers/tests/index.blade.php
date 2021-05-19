@extends('layouts.app-teachers')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Tests') }}</div>
                        <div><a class="btn btn-primary" href="{{ route('teachers.tests.add') }}">Add Test</a></div>
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
                                        <a href="#" onclick="confirmDelete({{ $test->id }}, '{{ $test->test_title }}')" style="color: #880000" title="Delete Test">
                                            <svg viewBox="-47 0 512 512" fill="currentColor" style="width:2rem;height:2rem" xmlns="http://www.w3.org/2000/svg"><path d="M416.875 114.441L405.57 80.555a31.527 31.527 0 00-29.941-21.578h-95.012V28.043C280.617 12.582 268.047 0 252.59 0h-87.008c-15.453 0-28.027 12.582-28.027 28.043v30.934H42.547a31.528 31.528 0 00-29.945 21.578L1.297 114.44a25.426 25.426 0 003.484 22.856 25.427 25.427 0 0020.578 10.539h11.817L63.184 469.44C65.117 493.305 85.367 512 109.293 512h204.863c23.922 0 44.176-18.695 46.106-42.563l26.008-321.601h6.543A25.434 25.434 0 00413.39 137.3a25.434 25.434 0 003.484-22.86zM167.555 30h83.062v28.977h-83.062zm162.804 437.02c-.68 8.402-7.796 14.98-16.203 14.98H109.293c-8.406 0-15.523-6.578-16.203-14.98L67.273 147.836h288.899zM31.793 117.836l9.27-27.79c.21-.64.808-1.07 1.484-1.07h333.082c.676 0 1.27.43 1.484 1.07l9.27 27.79zm0 0"/><path d="M282.516 465.957c.265.016.527.02.793.02 7.925 0 14.55-6.211 14.964-14.22L312.36 181.36c.43-8.273-5.93-15.332-14.199-15.761-8.293-.442-15.328 5.925-15.762 14.199l-14.082 270.398c-.43 8.274 5.926 15.332 14.2 15.762zm0 0M120.566 451.793c.438 7.996 7.055 14.184 14.965 14.184.274 0 .555-.008.832-.024 8.27-.45 14.61-7.52 14.16-15.793L135.77 179.762c-.45-8.274-7.52-14.614-15.793-14.16-8.27.449-14.61 7.52-14.16 15.793zm0 0M209.254 465.977c8.285 0 15-6.715 15-15V180.578c0-8.285-6.715-15-15-15s-15 6.715-15 15v270.399c0 8.285 6.715 15 15 15zm0 0"/></svg>
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

    <form id="deleteForm" method="post">
        @csrf
        <input type="hidden" id="test_id" name="id" value="">
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/sweetalert2.js') }}"></script>

<script>
    function confirmDelete(id, test_title) {
        Swal.fire({
        title: 'Do you want to delete this test?',
        text: 'Test: ' + test_title,
        icon: 'error',
        showDenyButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: '#dd6b55',
        denyButtonText: "Don't delete",
        denyButtonColor: '#009900',
        focusDeny: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteForm').attr('action', '{{ route('teachers.tests.delete') }}');
                $('#test_id').val(id);
                $('#deleteForm').submit();
            }
        });
    }
</script>
@endsection



