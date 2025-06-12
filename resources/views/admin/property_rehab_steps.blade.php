@extends('admin.layout.main')
@section('title', 'Rehab Progress');
@section('body')

    <section class="section rehab-steps">
        <div class="status">
            <h4>{{ session('status') }}</h4>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <h4 class="error">{{ $error }}</h4>
                @endforeach
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4 class="card-title">Rehab Progress</h4>

                    <div class="row">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="selectproperty" class="form-label">Property</label>
                            <select disabled class="form-select multiselect" id="selectproperty" required>
                                <option value="">Select Property</option>
                                @foreach ($properties as $property)
                                    <option {{ session('R_Pid') == $property->property_id ? 'selected' : '' }}
                                        value="{{ $property->property_id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Please select a property
                            </div>
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="selectreason" class="form-label">Reason</label>
                            <select disabled class="form-select multiselect" id="selectreason" required>
                                <option value="">Select Reason</option>
                                @foreach ($reasons as $reason)
                                    <option {{ session('R_Reason') == $reason->reason ? 'selected' : '' }}
                                        value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                                @endforeach
                                <option {{ session('R_Reason') == 'Other' ? 'selected' : '' }} value="Other">Other
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a reason
                            </div>
                        </div>
                        <div @if (!session()->has('R_OReason')) style="display: none" @endif
                            class="row other-reason-main mt-4">
                            <div class="col-lg-6 position-relative  form-input-wrap">
                                <label for="selectreason" class="form-label">Other Reason</label>
                                <span class="other-reason-inner">
                                    <input disabled value="{{ session('R_OReason') }}" type="text"
                                        placeholder="Please enter rehab reason." class="form-control" id="other_reason">
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4 class="card-title">Steps</h4>
                </div>
                <form id="mainForm" method="POST" action="{{ route('Admin.SaveRehabProgress') }}" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf

                    <div id="stepsContainer">

                        <div class="progress-step border p-3 mb-4">

                            <div class="row mt-3">
                                <h5 class="step-value">Step: 1</h5>
                                <div class="col-lg-6">
                                    <div class="position-relative form-input-wrap">
                                        <label class="form-label">Progress %</label>
                                        <input type="text" class="form-control progress_percent number-input"
                                            name="progress_percent[]" required>
                                        <div class="invalid-feedback">The progress percentage is required</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="position-relative form-input-wrap">
                                        <label class="form-label">Progress Title</label>
                                        <input type="text" class="form-control" name="progress_title[]" required>
                                        <div class="invalid-feedback">The progress title is required</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="position-relative form-input-wrap">
                                        <label class="form-label">Budgeted Amount</label>
                                        <input type="text" class="form-control number-input" name="budgeted_amount[]"
                                            required>
                                        <div class="invalid-feedback">Budgeted Amount is required</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="position-relative form-input-wrap">
                                        <label class="form-label">Deadline</label>
                                        <input type="date" class="form-control" name="deadline[]" required>
                                        <div class="invalid-feedback">The deadline is required</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 image-preview-main">
                                <div class="col-lg-6">
                                    <div class="position-relative form-input-wrap">
                                        <label class="form-label">Summary</label>
                                        <textarea class="form-control" name="summary[]" required></textarea>
                                        <div class="invalid-feedback">Summary is required</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="position-relative form-input-wrap">
                                        <label class="form-label">Upload Images</label>
                                        <input type="file" class="form-control image-uploader images_file_upload" name="images_file_0[]"
                                            multiple>
                                        <span style="color: green;">You can select multiple images at once.</span>
                                        <div class="invalid-feedback">Images are required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="image-preview"></div>
                            </div>

                            <div class="text-end mt-2 d-none remove-step-wrap">
                                <button class="btn btn-danger remove-step">Remove Step</button>
                            </div>

                        </div>

                    </div>

                    <div class="row mt-3 text-center">
                        <div class="col-lg-12">
                            <button type="button" id="addNewStep" class="btn btn-secondary">Add New Step</button>
                            <button type="submit" class="btn btn-primary">Save Data</button>

                        </div>
                    </div>
                </form>


            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        var imageindex = 1;
        var pageMode = "insert";
    </script>
@endpush
