@extends('user.layout.main')
@section('title', 'User Personal Report');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>

        <div class="card ">
            <div class="card-body">
                <h4 class="card-title">Personal Report</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Property</th>
                            <th scope="col">View Report</th>
                            <th scope="col">Type</th>
                            <th scope="col">Date</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="new-value">
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report->name }}</td>
                                <td>
                                    <a href="{{ url('storage/' . $report->file) }}" class="btn btn-outline-primary btn-sm"
                                        target="_blank" title="{{ $report->title }}">
                                        <i class="bi bi-file-earmark-text"></i> {{ $report->title }}
                                    </a>
                                </td>
                                <td>{{ $report->type }}</td>
                                <td>{{ carbon\carbon::parse($report->report_date)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('Admin.DeleteUserPersonalReport', ['rid' => base64_encode($report->id)]) }}"
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
    </section>
@endsection
