@extends('admin.layout.main')
@section('title', 'Set Property Order');
@section('body')
    <div class="page-title">
        <h1>Set Property Order</h1>
    </div>
    @if ($properties->isNotEmpty())

        <ul id="sortable-properties" class="list-unstyled">
            @foreach ($properties as $property)
                <li class="sortable-item" data-id="{{ $property->id }}">
                    <a href="#" class="card mb-3 border">
                        <div class="card-body">
                            <div class="row category-item mb-2">
                                <div class="col-md-8">
                                    <div class="property-title">{{ $property->name }} ({{ $property->category_name }})</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

    @endif

@endsection
@push('js')
    <script>
        var orderurl = "{{ route('Admin.UpdatePropertyOrder') }}";
    </script>
@endpush
