@extends('admin.layout.main')
@section('title', 'Property Monthly Report');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4 class="card-title">Select Property</h4>
                    <div>
                        <form method="POST" action="">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 position-relative form-input-wrap">
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

                                <div class="col-lg-4 position-relative form-input-wrap">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (isset($reports))
            <div class="card ">
                <div class="card-body">
                    <h4 class="card-title">Monthly Reports</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="new-value">
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $report->title }}
                                    </td>
                                    <td>{{ carbon\carbon::parse($report->report_date)->format('d-m-Y') }}</td>
                                    <td>
                                         <a href="{{ url('storage/' . $report->file) }}" target="_blank"
                                            title="{{ $report->title }}"><i class="ri-eye-line"></i></a>
                                        <a href="{{ route('Admin.DeletePropertyMonthlyReport', ['pid' => base64_encode($report->id)]) }}"
                                            class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this report?')">
                                            <i class="ri-delete-bin-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Bordered Table -->

                </div>
            </div>
        @endif
    </section>

@endsection
@push('js')
@endpush
