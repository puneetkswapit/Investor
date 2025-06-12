@extends('admin.layout.main')
@section('title', 'Add Rehab Progress');
@section('body')
    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="page-title">
                    <h4 class="card-title">Select Property</h4>
                    <div>
                        <form method="POST" action="{{ route('Admin.SavePropertyRehabProgress') }}" class="needs-validation"
                            novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="selectproperty" class="form-label">Property</label>
                                    <select name="property_id" class="form-select multiselect" id="selectproperty" required>
                                        <option value="">Select Property</option>
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->property_id }}">{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a property
                                    </div>
                                </div>
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="selectreason" class="form-label">Reason</label>
                                    <select name="reason" class="form-select multiselect" id="selectreason" required>
                                        <option value="">Select Reason</option>
                                        @foreach ($reasons as $reason)
                                            <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                                        @endforeach
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a reason
                                    </div>
                                </div>
                                <div style="display: none" class="row other-reason-main mt-4">
                                    <div class="col-lg-6 position-relative  form-input-wrap">
                                        <label for="selectreason" class="form-label">Other Reason</label>
                                        <span class="other-reason-inner">

                                        </span>

                                        <div class="invalid-feedback">
                                            Please select a property
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 position-relative form-input-wrap">
                                <button type="button" class="btn btn-primary add-new-rehab">Start Rehab</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- Modal -->
    <div class="modal fade" id="rehabModal" tabindex="-1" aria-labelledby="rehabModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="rehabModalLabel">Rehab Progress</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="rehabForm">
                    <div class="modal-body">
                        <p>You have an incomplete rehab progress. Would you like to continue editing it, or start a new one?
                        </p>
                    </div>

                    <div class="modal-footer">
                        <a href="{{ route('Admin.RehabProgressList') }}" class="btn btn-secondary" id="continueEdit">Continue Editing</a>
                        <a href="{{route('Admin.NewRehabProgress')}}" class="btn btn-primary" id="createNew">Create New</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        var saverehab = '{{ route("Admin.SavePropertyRehabProgress") }}';
        var newrehab = '{{route("Admin.NewRehabProgress")}}';
    </script>
@endpush
