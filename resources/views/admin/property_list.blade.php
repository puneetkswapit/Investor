@extends('admin.layout.main')
@section('title', 'Property List');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Property List</h4>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No.</th>
                            <th scope="col">Property Title</th>
                            <th scope="col">Property Image</th>
                            <th scope="col">Property Location</th>
                            <th scope="col">Property Type</th>
                            <th scope="col">Purchase Price</th>
                            <th scope="col">Close Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($properties->isNotEmpty())
                            @foreach ($properties as $property)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $property->name }}</td>
                                    <td><img width="90" height="90"
                                            src="{{ asset('storage/' . $property->property_image) }}"
                                            alt="{{ $property->name }}"></td>
                                    <td>{{ $property->location }}</td>
                                    <td>{{ $property->category_name }}</td>
                                    <td>{{ $property->purchaseprice }}</td>
                                    <td>{{ $property->closedate }}</td>
                                    <td>
                                        <span class="badge rounded-pill">
                                            <a href="{{route('Admin.EditProperty',['pid' => $property->property_id  ])}}" type="button" title="Edit Property" class="btn btn-success edit-main-category">
                                                <i class="ri-edit-box-line"></i>
                                            </a>
                                            <a href="{{ route('Admin.DeleteProperty', ['pid' => $property->property_id  ]) }}"
                                                class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this Property')">
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

            </div>
        </div>


    </section>
@endsection

@push('js')
@endpush
