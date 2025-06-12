@extends('admin.layout.main')
@section('title', 'All Categories');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Category List</h4>

                <!-- Category Table -->

                @if ($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        @php
                            $subcatgs = App\Models\Category::where('parent', $category->id)->get();
                        @endphp
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row category-item mb-2">
                                    <div class="col-md-8">
                                        <div class="category-title">{{ $category->category }}</div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <button type="button" class="btn btn-success edit-main-category"
                                            data-id="{{ $category->id }}" data-name="{{ $category->category }}"
                                            data-bs-toggle="modal" data-bs-target="#CategoryModal">
                                            <i class="ri-edit-box-line"></i>
                                        </button>
                                        <a href="{{ route('Admin.DeleteCategory', ['cid' => $category->id]) }}"
                                            class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this category')">
                                            <i class="ri-delete-bin-line"></i>
                                        </a>
                                    </div>
                                </div>

                                @if ($subcatgs->isNotEmpty())
                                    <ul class="list-group ms-3">
                                        @foreach ($subcatgs as $subcatg)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $subcatg->category }}
                                                <span class="badge rounded-pill">
                                                    <button type="button" class="btn btn-success edit-main-category"
                                                        data-id="{{ $subcatg->id }}" data-name="{{ $subcatg->category }}"
                                                        data-bs-toggle="modal" data-bs-target="#CategoryModal">
                                                        <i class="ri-edit-box-line"></i>
                                                    </button>
                                                    <a href="{{ route('Admin.DeleteCategory', ['cid' => $subcatg->id]) }}"
                                                        class="btn btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this subcategory')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif


                <!-- End Category Table -->

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="CategoryModal" tabindex="-1" aria-labelledby="CategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="CategoryModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body category-modal-data">
                        <form method="post" action="{{ route('Admin.EditCategory') }}" class="row g-3 needs-validation"
                            novalidate>
                            @csrf
                            <div class="position-relative">
                                <label for="categoryname" class="form-label">Category Name</label>
                                <input type="text" class="form-control category-name-input"
                                    name="category"id="categoryname" required>
                                <div class="invalid-feedback">
                                    The category name is required
                                </div>
                            </div>
                            <input type="hidden" class="category-id-input" name="category_id">

                            <div class="text-center">
                                <button type="submit"
                                    class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script></script>
@endpush
