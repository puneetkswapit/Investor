@extends('user.layout.main')
@section('title', 'User List');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4 class="card-title">User List</h4>
                    <div>
                        <a class="btn btn-primary" title="Add User" href="{{ route('User.AddUser') }}">Add User</a>
                    </div>


                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="partners-tab" data-bs-toggle="tab" data-bs-target="#partners"
                            type="button" role="tab" aria-controls="partners" aria-selected="true">Partners</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="investors-tab" data-bs-toggle="tab" data-bs-target="#investors"
                            type="button" role="tab" aria-controls="investors" aria-selected="false">Investors</button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="partners" role="tabpanel" aria-labelledby="partners-tab">

                        <table class="table table-bordered datatable" id="table-1">
                            <thead>
                                <tr>
                                    <th scope="col">Sr.No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">Date</th>

                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="new-value">
                                @if ($partnerusers->isNotEmpty())
                                    @foreach ($partnerusers as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>

                                            <td>
                                                {{ $user->investor == 1 ? 'Investor' : '' }}{{ $user->investor == 1 && $user->partner == 1 ? ' | ' : '' }}{{ $user->partner == 1 ? 'Partner' : '' }}
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                                            <td>
                                                <span class="badge rounded-pill">
                                                    @hasPermission('edit_user')
                                                        <a href="{{ route('User.EditUser', ['uid' => base64_encode($user->user_id)]) }}"
                                                            type="button" title="Edit Property"
                                                            class="btn btn-success edit-main-category">
                                                            <i class="ri-edit-box-line"></i>
                                                        </a>
                                                    @endhasPermission
                                                    @hasPermission('delete_user')
                                                        <a href="{{ route('User.DeleteUser', ['uid' => $user->user_id]) }}"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a>
                                                    @endhasPermission
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade " id="investors" role="tabpanel" aria-labelledby="investors-tab">
                        <table class="table table-bordered datatable" id="table-2">
                            <thead>
                                <tr>
                                    <th scope="col">Sr.No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="new-value">
                                @if ($invsetorusers->isNotEmpty())
                                    @foreach ($invsetorusers as $iuser)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $iuser->name }}</td>
                                            <td>{{ $iuser->email }}</td>

                                            <td>
                                                {{ $iuser->investor == 1 ? 'Investor' : '' }}{{ $iuser->investor == 1 && $iuser->partner == 1 ? ' | ' : '' }}{{ $iuser->partner == 1 ? 'Partner' : '' }}
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($iuser->created_at)->format('d-m-Y') }}</td>

                                            <td>
                                                @hasPermission('edit_user')
                                                    <span class="badge rounded-pill">
                                                        <a href="{{ route('User.EditUser', ['uid' => base64_encode($iuser->user_id)]) }}"
                                                            type="button" title="Edit Property"
                                                            class="btn btn-success edit-main-category">
                                                            <i class="ri-edit-box-line"></i>
                                                        </a>
                                                    @endhasPermission
                                                    @hasPermission('delete_user')
                                                        <a href="{{ route('User.DeleteUser', ['uid' => $iuser->user_id]) }}"
                                                            class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </a>
                                                    @endhasPermission
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
                <!-- End Bordered Table -->

            </div>
        </div>


    </section>

@endsection
@push('js')
    <script>
        var search_url = "{{ route('User.UserSearch') }}";
    </script>
@endpush
