@extends('admin.layout.main')
@section('title', 'User Summary Report');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4 class="card-title">User Summary Report</h4>
                    <div>
                        <form method="POST" action="">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 position-relative form-input-wrap">
                                    <label for="userstate" class="form-label">Users</label>
                                    <select name="name" class="form-select multiselect" id="selectusertype">
                                        <option value="all">All User</option>
                                        @foreach ($allusers as $user)
                                            <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 position-relative form-input-wrap">
                                    <label for="userstate" class="form-label">Property</label>
                                    <select name="property" class="form-select multiselect" id="selectusertype">
                                        <option value="">Select Property</option>
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->property_id }}">{{ $property->name }}</option>
                                        @endforeach
                                    </select>
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

        @if (isset($users))
            <div class="card ">
                <div class="card-body">
                    <h4 class="card-title">User Summary Report</h4>
                    <a class="btn btn-primary" title="export" href="{{ route('Admin.UserSummaryExport') }}">Export</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Sr.No.</th>
                                <th scope="col">Investor Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mailing Address</th>
                                <th scope="col">Phone No.</th>
                                <th scope="col">Tag</th>
                                <th scope="col">Invested Properties</th>
                                <th scope="col">Total Properties</th>
                            </tr>
                        </thead>
                        <tbody class="new-value">
                            @foreach ($users as $user)
                                @php
                                    $userprop = App\Models\InvestorProperty::join(
                                        'properties',
                                        'properties.property_id',
                                        'investor_properties.property_id',
                                    )
                                        ->where('investor_properties.user_id', $user->user_id)
                                        ->select('properties.name')
                                        ->get();

                                    $propcount = $userprop->count();
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mailing_address }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>{{ $user->tags }}</td>
                                    <td>
                                        @foreach ($userprop as $userp)
                                            {{ $userp->name }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach

                                    </td>
                                    <td>{{ $propcount }}</td>
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
