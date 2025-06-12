@extends('admin.layout.main')
@section('title', 'Add Category');
@section('body')

    <section class="section main">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Category</h5>
                        <form method="post" action="{{ route('Admin.SaveCategory') }}" class="row g-3 needs-validation"
                            novalidate>
                            @csrf
                            <div class="position-relative">
                                <label for="categoryname" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category" id="categoryname" required>
                                <div class="invalid-feedback">
                                    The category name is required
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Sub Category</h5>

                        <!-- Vertical Form -->
                        <form method="post" action="{{route('Admin.SaveSubCategory')}}" class="row g-3 needs-validation" novalidate>
                            @csrf
                            <div class="position-relative">
                                <label for="subcategoryname" class="form-label">Sub Category Name</label>
                                <input type="text" class="form-control" name="subcategory" id="subcategoryname" required>
                                <div class="invalid-feedback">
                                    The subcategory name is required
                                </div>
                            </div>

                            <div class="position-relative">
                                <label for="selectparentcategory" class="form-label">Parent Category</label>
                                <select name="parentcategory" class="form-select multiselect" id="selectparentcategory" required="">
                                    <option selected="" disabled="" value="">Choose...</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    Please select parent category.
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>



            </div>
        </div>
    </section>

@endsection
