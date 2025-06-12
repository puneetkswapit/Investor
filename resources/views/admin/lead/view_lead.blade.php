@extends('admin.layout.main')
@section('title', 'View Lead Details')
@section('body')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="section">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                <div class="main-title-wrap">
                    <h5 class="card-title">Lead Details</h5>
                    <div>
                        <a class="btn btn-primary" title="Back" href="{{ route('Admin.LeadList') }}">Back</a>
                    </div>
                </div>
                
            </div>

            <div class="card-body px-4 py-3">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="row gy-4">

                    {{-- Basic Info --}}
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">Basic Info</h6>
                        <hr>
                        <p><strong>Name:</strong> {{ $lead->name }}</p>
                        <p><strong>Company:</strong> {{ $lead->company ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> <a href="mailto:{{ $lead->email }}">{{ $lead->email ?? 'N/A' }}</a></p>
                        <p><strong>Phone:</strong> <a href="tel:{{ $lead->phone }}">{{ $lead->phone ?? 'N/A' }}</a></p>
                    </div>

                    {{-- Location Info --}}
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">Location</h6>
                        <hr>
                        <p><strong>City:</strong> {{ $lead->city ?? 'N/A' }}</p>
                        <p><strong>State:</strong> {{ $lead->state ?? 'N/A' }}</p>
                        <p><strong>ZIP Code:</strong> {{ $lead->zip_code ?? 'N/A' }}</p>
                        <p><strong>Country:</strong> {{ $lead->country ?? 'N/A' }}</p>
                    </div>

                    {{-- Status & Tags --}}
                    <div class="col-md-6">
                        <h6 class="text-uppercase text-muted">Status & Tags</h6>
                        <hr>
                        <p>
                            <strong>Status:</strong>
                            <span class="badge bg-info">{{ $lead->status }}</span>
                        </p>
                        <p><strong>Source:</strong> {{ $lead->source ?? 'N/A' }}</p>
                        <p><strong>Industry:</strong> {{ $lead->industry ?? 'N/A' }}</p>
                        <p><strong>Tags:</strong>
                            @php $tags = is_array($lead->tags) ? $lead->tags : json_decode($lead->tags, true); @endphp
                            @if (!empty($tags))
                                @foreach ($tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No tags</span>
                            @endif
                        </p>
                    </div>

                    {{-- Attachments --}}
                    @if ($lead->attachments && count($lead->attachments))
                        <div class="col-md-12">
                            <h6 class="text-uppercase text-muted">Attachments</h6>
                            <hr>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach ($lead->attachments as $file)
                                    @php $isImage = in_array(pathinfo($file->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif','webp']); @endphp
                                    <div class="text-center">
                                        @if ($isImage)
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $file->file_path) }}"
                                                    class="rounded border"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                class="btn btn-outline-dark btn-sm">
                                                <i class="bi bi-file-earmark-text"></i> View File
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Notes --}}
                    <div class="col-md-12">
                        <div class="notes-wrap">
                            <h6 class="text-uppercase text-muted">Notes</h6>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddNewNote">Add New Note</button>
                        </div>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Note</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lead->lead_note as $note)
                                    <tr class="align-middle">
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ carbon\carbon::parse($note->created_at)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            <p class="">{{ $note->title }}</p>
                                        </td>
                                        <td>
                                            <p class="bg-light p-3 rounded">{{ $note->note }}</p>
                                        </td>
                                        <td>
                                            @if ($note->file_path != '')
                                                @php $isImage2 = in_array(pathinfo($note->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif','webp']); @endphp
                                                <div class="text-center">
                                                    @if ($isImage2)
                                                        <a href="{{ asset('storage/' . $note->file_path) }}"
                                                            target="_blank">
                                                            <img src="{{ asset('storage/' . $note->file_path) }}"
                                                                class="rounded border"
                                                                style="width: 100px; height: 100px; object-fit: cover;">
                                                        </a>
                                                    @else
                                                        <a href="{{ asset('storage/' . $note->file_path) }}"
                                                            target="_blank" class="btn btn-outline-dark btn-sm">
                                                            <i class="bi bi-file-earmark-text"></i> View File
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Meta Info --}}
                    <div class="col-md-12 mt-4">
                        <hr>
                        <p class="text-muted mb-1">
                            <i class="bi bi-calendar-plus me-1"></i> Created at:
                            {{ $lead->created_at->format('d M Y, h:i A') }}
                        </p>
                        <p class="text-muted">
                            <i class="bi bi-clock-history me-1"></i> Last updated:
                            {{ $lead->updated_at->format('d M Y, h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add New Note modal -->

        <div class="modal fade" id="AddNewNote" tabindex="-1" aria-labelledby="AddNewNoteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="AddNewNoteLabel">Modal title</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="{{ route('Admin.AddNewNote') }}" class="row g-3 needs-validation"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="modal-body">
                            <div class="col-md-12 position-relative">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title" required>
                                <div class="invalid-feedback">The note title is required</div>
                            </div>

                            <div class="col-md-12 position-relative">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" name="note" id="notes" rows="4" required></textarea>
                                <div class="invalid-feedback">The note field is required</div>
                            </div>
                            <input type="hidden" value="{{ $lead->id }}" name="lead_id">
                            <div class="col-md-12 position-relative">
                                <label for="file" class="form-label">File</label>
                                <input type="file" class="form-control" name="file_path" id="file">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
