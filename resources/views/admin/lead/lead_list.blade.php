@extends('admin.layout.main')
@section('title', 'Lead List');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <div class="main-title-wrap">
                        <h4 class="card-title">Lead List</h4>
                        <div>
                            <a class="btn btn-primary" title="Add Lead" href="{{ route('Admin.AddLead') }}">Add Lead</a>
                        </div>
                    </div>
                    <div class="search-filter-form">
                        <form method="GET" action="{{ route('Admin.LeadList') }}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                                        class="form-control" placeholder="Keyword">
                                </div>
                                <div class="col-lg-4">
                                    <select name="status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="Contacted" {{ request('status') == 'Contacted' ? 'selected' : '' }}>
                                            Contacted</option>
                                        <option value="Qualified" {{ request('status') == 'Qualified' ? 'selected' : '' }}>
                                            Qualified</option>
                                        <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Lost
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <button type="submit" class="btn btn-primary">Search/Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No.</th>
                            <th>
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                    Name
                                    @if (request('sort_by') == 'name')
                                        {{ request('order') == 'asc' ? '🔼' : '🔽' }}
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                    Email
                                    @if (request('sort_by') == 'email')
                                        {{ request('order') == 'asc' ? '🔼' : '🔽' }}
                                    @endif
                                </a>
                            </th>
                            <th scope="col">Mobile</th>
                            <th>
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort_by' => 'status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                    Status
                                    @if (request('sort_by') == 'status')
                                        {{ request('order') == 'asc' ? '🔼' : '🔽' }}
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a
                                    href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}">
                                    Date
                                    @if (request('sort_by') == 'created_at')
                                        {{ request('order') == 'asc' ? '🔼' : '🔽' }}
                                    @endif
                                </a>
                            </th>
                            <th scope="col">View</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="new-value">
                        @if ($leads->isNotEmpty())
                            @foreach ($leads as $lead)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->phone }}</td>
                                    <td>{{ $lead->status }}</td>
                                    <td>{{ Carbon\Carbon::parse($lead->created_at)->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('Admin.ViewLead', ['lid' => base64_encode($lead->id)]) }}"
                                            type="button" title="Edit Property" class="btn btn-primary edit-main-category">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill">
                                            <a href="{{ route('Admin.EditLead', ['lid' => base64_encode($lead->id)]) }}"
                                                type="button" title="Edit Property"
                                                class="btn btn-success edit-main-category">
                                                <i class="ri-edit-box-line"></i>
                                            </a>
                                            <a href="{{ route('Admin.DeleteLead', ['lid' => base64_encode($lead->id)]) }}"
                                                class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <!-- End Bordered Table -->
                <div class="paginate">{{ $leads->links() }}</div>
            </div>
        </div>


    </section>

@endsection
@push('js')
    <script>
        var search_url = "{{ route('Admin.UserSearch') }}";
    </script>
@endpush
