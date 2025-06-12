@extends('admin.layout.main')
@section('title', 'Edit Lead');
@section('body')

    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="main-title-wrap">
                    <h5 class="card-title">Edit Lead</h5>
                    <div>
                        <a class="btn btn-primary" title="Back" href="{{ route('Admin.LeadList') }}">Back</a>
                    </div>
                </div>
                <form method="POST" action="{{ route('Admin.UpdateLead') }}" class="row g-3 needs-validation"
                    enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- Name --}}
                    <div class="col-md-6 position-relative">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="{{ $lead->name }}" name="name" id="name"
                            required>
                        <div class="invalid-feedback">The name is required</div>
                    </div>

                    {{-- Company --}}
                    <div class="col-md-6 position-relative">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control" value="{{ $lead->company }}" name="company"
                            id="company">
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 position-relative">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $lead->email }}" name="email"
                            id="email">
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 position-relative">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control number-input" value="{{ $lead->phone }}" name="phone"
                            id="phone">
                    </div>

                    {{-- City --}}
                    <div class="col-md-4 position-relative">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ $lead->city }}"
                            id="city">
                    </div>

                    {{-- State --}}
                    <div class="col-md-4 position-relative">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" name="state" value="{{ $lead->state }}"
                            id="state">
                    </div>

                    {{-- Zip Code --}}
                    <div class="col-md-4 position-relative">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control " name="zip_code" value="{{ $lead->zip_code }}"
                            id="zip_code">
                    </div>

                    {{-- Country --}}
                    <div class="col-md-6 position-relative">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" value="{{ $lead->country }}" name="country"
                            id="country">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 position-relative">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option {{ $lead->status == 'New' ? 'selected' : '' }} value="New" selected>New</option>
                            <option {{ $lead->status == 'Contacted' ? 'selected' : '' }} value="Contacted">Contacted
                            </option>
                            <option {{ $lead->status == 'Qualified' ? 'selected' : '' }} value="Qualified">Qualified
                            </option>
                            <option {{ $lead->status == 'Lost' ? 'selected' : '' }} value="Lost">Lost</option>
                        </select>
                    </div>

                    {{-- Source --}}
                    <div class="col-md-6 position-relative">
                        <label for="source" class="form-label">Source</label>
                        <input type="text" value="{{ $lead->source }}" class="form-control" name="source"
                            id="source">
                    </div>

                    {{-- Industry --}}
                    <div class="col-md-6 position-relative">
                        <label for="industry" class="form-label">Industry</label>
                        <input type="text" value="{{ $lead->industry }}" class="form-control" name="industry"
                            id="industry">
                    </div>

                    {{-- Tags --}}
                    <div class="col-md-12 position-relative">
                        @php
                            $tags = is_array($lead->tags) ? $lead->tags : json_decode($lead->tags, true);
                            $tags = implode(',', $tags);
                        @endphp
                        <label for="tags" class="form-label">Tags (comma-separated)</label>
                        <input type="text" value="{{ $tags }}" class="form-control" name="tags"
                            id="tags" placeholder="e.g. hot,priority,important">
                    </div>

                    {{-- Notes --}}
                    {{-- <div class="col-md-12 position-relative">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" id="notes" rows="4">{{ $lead->notes }}</textarea>
                    </div> --}}

                    {{-- Attachments --}}
                    <div class="col-md-12 position-relative">
                        <label for="attachments" class="form-label">Attachments</label>
                        <input type="file" class="form-control" id="attachments" multiple>
                        <input type="hidden" name="lid" value="{{ base64_encode($lead->id) }}">
                        <small class="text-muted">You can upload multiple files.</small>

                        <!-- Hidden actual input to submit files -->
                        <input type="file" name="attachments[]" id="hiddenAttachments" multiple
                            style="display: none;">

                        <!-- Preview container -->
                        <div id="previewContainer" class="mt-3 row g-2"></div>
                        @if ($lead->attachments && count($lead->attachments))
                            <div class="col-md-12">
                                <h6 class="text-uppercase text-muted">Attachments</h6>
                                <hr>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($lead->attachments as $file)
                                        @php $isImage = in_array(pathinfo($file->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif','webp']); @endphp
                                        <div class="text-center file-delete-wrap">
                                            @if ($isImage)
                                                <img src="{{ asset('storage/' . $file->file_path) }}"
                                                    class="rounded border"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                                <a onclick="return confirm('Are you sure you want to delete this attachment?')"
                                                    href="{{ route('Admin.DeleteLeadImage', ['iid' => base64_encode($file->id)]) }}"><i
                                                        class="ri-delete-bin-6-line"></i></a>
                                            @else
                                                <span class="btn btn-outline-dark btn-sm">
                                                    <i class="bi bi-file-earmark-text"></i> View File
                                                </span>
                                                <a onclick="return confirm('Are you sure you want to delete this attachment?')"
                                                    href="{{ route('Admin.DeleteLeadImage', ['iid' => base64_encode($file->id)]) }}"><i
                                                        class="ri-delete-bin-6-line"><i class="ri-delete-bin-6-line"></i>
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>


            </div>


        </div>
    </section>

@endsection
@push('js')
    <script>
        let selectedFiles = [];

        $('#attachments').on('change', function(e) {
            const newFiles = Array.from(e.target.files);

            newFiles.forEach(file => {
                // Avoid duplicates
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });

            // Clear preview container and redraw
            $('#previewContainer').html('');
            selectedFiles.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewContainer').append(`
                        <div class="col-auto">
                            <img src="${e.target.result}" class="img-thumbnail" style="width:100px; height: 100px;">
                        </div>
                    `);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Sync all selected files to hidden input (for form submission)
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('hiddenAttachments').files = dataTransfer.files;
        });
    </script>
@endpush
