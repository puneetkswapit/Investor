@extends('admin.layout.main')
@section('title', 'User Permission')

@section('body')
    <section class="section">
        <div class="container mt-4">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>User Permissions</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('Admin.UserPermission.Update') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ request()->uid ?? '' }}">
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="permission-main col-lg-4 border p-2">
                                    <div class="permission-title">
                                        <h4>{{ $permission->name }}</h4>
                                    </div>
                                    <div class="permission-data">
                                        @foreach ($permission->permissions as $perm)
                                               
                                        <div class=" mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{ $userpermissions->contains('permission_id', $perm->id) ? 'checked' : '' }} >
                                              <label class="form-check-label" for="perm_{{ $perm->id }}"> 
                                                 {{ $perm->permission_name  }} 
                                                </label>
                                            </div>
                                        </div>
                                         @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                            <a href="{{ route('Admin.UserList') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
@endpush
