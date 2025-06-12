@extends('admin.layout.main')
@section('title', 'Add User Personal Report');
@section('body')

    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <h4 class="error">{{ $error }}</h4>
                @endforeach
            @endif
        </div>

        <form method="post" action="{{ route('Admin.SaveUserPersonalReport') }}" class="row g-3 needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf

            <div class="card card-sec-bg-main">
                <div class="card-body">
                    <h2 class="card-title">Add User Personal Report</h2>
                    <div class="row">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="choiceuser" class="form-label">Users</label>
                            <select name="name" class="form-select multiselect" id="choiceuser" required>
                                <option value="">Select User</option>
                                @foreach ($allusers as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a user
                            </div>
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="userstate" class="form-label">Property</label>
                            <select name="property" class="form-select multiselect" id="selectuserproperty" required>


                            </select>
                            <div class="invalid-feedback">
                                Please select a property
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="propertytitle" class="form-label">Title</label>
                            <input type="text" placeholder="Enter personal report title" class="form-control"
                                name="propertytitle" id="propertytitle" required>
                            <div class="invalid-feedback">
                                Please enter title
                            </div>
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="reporttype" class="form-label">Type</label>
                            @php
                                $reporttypes = App\Models\PersonalReportType::get();
                            @endphp
                            <select name="reporttype" class="form-select" id="reporttype" required>
                                <option value="">Select Type</option>
                                @foreach ($reporttypes as $reporttype)
                                    <option>{{ $reporttype->type }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select type
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="file" class="form-label">File</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                            <div class="invalid-feedback">
                                Please upload file
                            </div>
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                            <div class="invalid-feedback">
                                Please Select date
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
        </form>
    </section>

@endsection
@push('js')
    <script>
        var propurl = "{{ route('Admin.GetUserProperties') }}";
    </script>
@endpush
