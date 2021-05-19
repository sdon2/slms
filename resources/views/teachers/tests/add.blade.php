@extends('layouts.app-teachers')

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Add Test') }}</div>
                        <div><a class="btn btn-primary" href="{{ route('teachers.tests.index') }}">Back</a></div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('teachers.tests.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Test Title</label>
                            <input type="text" class="form-control @error('test_title') is-invalid @enderror" name="test_title" value="{{ old('test_title') }}" required>
                             @error('test_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="py-2">
                            <div class="d-flex justify-content-between align-items-center pb-2">
                                <h4 class="pb-2">Questions</h4>
                                <div>
                                    <a class="btn btn-sm btn-success btn-circle" @click="addQuestion" title="Add Question">+</a>
                                </div>
                            </div>
                            <div v-for="(question, index) in questions" :key="question.question + index" class="px-2 py-2 border rounded mb-2" :class="[index % 2 === 0 ? 'bg-dark' : 'bg-light', index % 2 === 0 ? 'text-white' : 'text-black']">
                                <div class="d-flex justify-content-between align-items-center pb-2">
                                    <div>Question <strong>#<span v-text="index + 1"></span></strong></div>
                                    <div v-if="index !== 0">
                                        <a class="btn btn-sm btn-danger btn-circle" @click="removeQuestion(index)" title="Remove">x</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="questions[]" class="form-control" placeholder="Question">
                                </div>
                                <div class="form-group">
                                    <label>Answer</label>
                                    <input type="text" name="answers[]" class="form-control" placeholder="Answer">
                                </div>
                                <div class="form-group">
                                    <label>Marks</label>
                                    <select class="form-control" name="marks[]">
                                        <option value="">Select Marks</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
.btn-circle.btn-sm {
    width: 30px;
    height: 30px;
    padding: 4px 0px;
    border-radius: 15px;
    text-align: center;
}
</style>
@endsection

@section('scripts')
<script src="{{ asset('vendor/vue.js') }}"></script>

<script>
    const app = new Vue({
        el: '#app',
        data: {
            questions: [],
            question: {
                question: '',
                correct_answer: '',
                marks: 0,
            },
            errors: {},
        },
        methods: {
            addQuestion: function () {
                this.questions.push(Object.assign({}, this.question));
            },
            removeQuestion: function (index) {
                this.questions.splice(index, 1);
            },
        },
        created: function () {
            this.questions.push(Object.assign({}, this.question));
        },
    });
</script>
@endsection
