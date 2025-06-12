@extends('admin.layout.main')
@section('title', 'Mail Body Content');
@section('body')

    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Mail Body Content</h5>
                <div class="row">
                    <div class="col-lg-12">
                        <form method="post" action="{{ route('Admin.SaveMailContent') }}" class="row g-3 needs-validation"
                            novalidate>
                            @csrf
                            <div class="position-relative form-input-wrap">
                                <label for="header_note" class="form-label">Header</label>
                                <textarea class="form-control summernote-editor" name="header_note" id="header_note">{!! isset($data['content_1']) ? $data['content_1'] : '' !!}</textarea>
                            </div>
                            <div class="position-relative form-input-wrap">
                                <label for="footer_note" class="form-label">Footer</label>
                                <textarea class="form-control summernote-editor" name="footer_note" id="footer_note">{!! isset($data['content_2']) ? $data['content_2'] : '' !!}</textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </section>

@endsection
