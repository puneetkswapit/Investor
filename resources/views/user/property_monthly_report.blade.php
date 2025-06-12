@extends('user.layout.main')
@section('title', 'Add Property Monthly Report');
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

        <form method="post" action="{{ route('User.SavePropertyMonthlyReport') }}" class="row g-3 needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Property Monthly Report</h5>
                    <div class="row">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="selectproperty" class="form-label">Property</label>
                            <select name="property" class="form-select multiselect" id="selectproperty" required>
                                <option value="">Select Property</option>
                                @foreach ($properties as $property)
                                    <option value="{{ $property->property_id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a property
                            </div>
                        </div>
                         <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="propertytitle" class="form-label">Title</label>
                            <input type="text" placeholder="Enter personal report title" class="form-control"
                                name="propertytitle" id="propertytitle" required>
                            <div class="invalid-feedback">
                                Please enter title
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="file" class="form-label">Documents</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                            <div class="invalid-feedback">
                                Please upload Document
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
        var propurl = "{{ route('User.GetUserProperties') }}";
    </script>
@endpush
