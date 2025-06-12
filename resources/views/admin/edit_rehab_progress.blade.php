@extends('admin.layout.main')
@section('title', 'Edit Rehab Progress');
@section('body')
    @php
        $percentage = $rehab->percentage;
    @endphp
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
                    <div>
                        <div class="row">
                            <div class="col-lg-6 position-relative form-input-wrap">
                                <label for="selectproperty" class="form-label">Property</label>
                                <select disabled class="form-select multiselect" id="selectproperty">
                                    <option value="">Select Property</option>
                                    @foreach ($properties as $property)
                                        <option {{ $rehab->property_id == $property->property_id ? 'selected' : '' }}
                                            value="{{ $property->property_id }}">{{ $property->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-lg-6 position-relative form-input-wrap">
                                <label for="selectreason" class="form-label">Reason</label>
                                <select disabled class="form-select multiselect" id="selectreason">
                                    <option value="">Select Reason</option>
                                    @foreach ($reasons as $reason)
                                        <option {{ $rehab->reason == $reason->reason ? 'selected' : '' }}
                                            value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                                    @endforeach
                                    <option {{ session('R_Reason') == 'Other' ? 'selected' : '' }} value="Other">Other
                                    </option>
                                </select>

                            </div>
                            <div @if ($rehab->other_reason == '') style="display: none" @endif
                                class="row other-reason-main mt-4">
                                <div class="col-lg-6 position-relative  form-input-wrap">
                                    <label for="selectreason" class="form-label">Other Reason</label>
                                    <span class="other-reason-inner">
                                        <input disabled value="{{ $rehab->other_reason }}" type="text"
                                            placeholder="Please enter rehab reason." class="form-control" id="other_reason">
                                    </span>
                                </div>
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
                <form id="mainForm" method="POST" action="{{ route('Admin.UpdateRehabProgress') }}"
                    class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div id="stepsContainer">
                        @php
                            $x = 1;
                            $y = 0;
                            $stepscount = [];
                            $percentagecount = [];
                            $budgetscount = [];
                        $completecount = 0; @endphp
                        @if ($steps->isNotEmpty())
                            @foreach ($steps as $step)
                                @php
                                    $images = App\Models\RehabImage::where('rehab_id', $step->rehab_id)
                                        ->where('step_id', $step->id)
                                        ->get();
                                    $stepscount[] = $x;
                                    $percentagecount[] = $step->percentage;
                                    $budgetscount[] = $step->amount;
                                    $completecount = $step->percentage;
                                @endphp
                                <div class="progress-step-wrap old-div-wrap" >
                                    <div class="progress-step border p-3 mb-4">
                                        <div class="row mt-3">
                                            <h5 class="step-value">Step: {{ $x }}</h5>
                                            <div class="col-lg-6">
                                                <div class="position-relative form-input-wrap">
                                                    <label class="form-label">Progress %</label>
                                                    <input type="text" value="{{ $step->percentage }}"
                                                        class="form-control progress_percent number-input"
                                                        name="progress_percent[]" required>
                                                    <div class="invalid-feedback">The progress percentage is required</div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="step_id[]" value="{{ $step->id }}">

                                            <div class="col-lg-6">
                                                <div class="position-relative form-input-wrap">
                                                    <label class="form-label">Progress Title</label>
                                                    <input type="text" class="form-control" value="{{ $step->title }}"
                                                        name="progress_title[]" required>
                                                    <div class="invalid-feedback">The progress title is required</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                                <div class="position-relative form-input-wrap">
                                                    <label class="form-label">Budgeted Amount</label>
                                                    <input type="text" value="{{ $step->amount }}"
                                                        class="form-control number-input" name="budgeted_amount[]" required>
                                                    <div class="invalid-feedback">Budgeted Amount is required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="position-relative form-input-wrap">
                                                    <label class="form-label">Deadline</label>
                                                    <input type="date" class="form-control"
                                                        value="{{ $step->deadline }}" name="deadline[]" required>
                                                    <div class="invalid-feedback">The deadline is required</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3 image-preview-main">
                                            <div class="col-lg-6">
                                                <div class="position-relative form-input-wrap">
                                                    <label class="form-label">Summary</label>
                                                    <textarea class="form-control" name="summary[]" required>{{ $step->summary }}</textarea>
                                                    <div class="invalid-feedback">Summary is required</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="position-relative form-input-wrap">
                                                    <label class="form-label">Upload Images</label>
                                                    <input type="file"
                                                        class="form-control image-uploader images_file_upload"
                                                        name="images_file_{{ $y }}[]" multiple>
                                                    <span style="color: green;">You can select multiple images at
                                                        once.</span>
                                                    <div class="invalid-feedback">Images are required.</div>

                                                    <!-- Unique Preview Area -->
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-3 old-image-main">
                                            <div class="image-preview"></div>
                                        </div>

                                        <div class="text-end mt-2 remove-step-wrap">
                                            <button class="btn btn-danger remove-step-old">Remove Step</button>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-lg-12">

                                            <div class="old-images " style="display: flex; flex-wrap: wrap;">
                                                @foreach ($images as $image)
                                                    <div class="old-images-inner">
                                                        <a onclick="return confirm('Are you sure you want to delete this image?')"
                                                            href="{{ route('Admin.DeleteRehabProgressImage', ['iid' => $image->id]) }}"><span><i
                                                                    class="ri-delete-bin-6-line"></i></span></a>
                                                        <a class="m-3" href="{{ url('storage/' . $image->image) }}"
                                                            target="_blank">
                                                            <img height="200" width="200"
                                                                src="{{ asset('storage/' . $image->image) }}"
                                                                alt="image_{{ $x }}">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $x++;
                                    $y++;
                                @endphp
                            @endforeach
                        @else
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
                                            <input type="text" class="form-control number-input"
                                                name="budgeted_amount[]" required>
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
                                            <input type="file" class="form-control images_file_upload"
                                                name="images_file_0[]" multiple>
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
                                <input type="hidden" name="step_id[]" value="">
                            </div>
                        @endif
                        <input type="hidden" name="rehab_id" value="{{ $rehab->id }}">
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
        <div class="card">
            <div class="card-body">

                <!-- Bar Chart -->
                @php
                    // Create labels like Step-1, Step-2, ...
                    $xLabels = array_map(fn($step) => 'Step-' . $step, $stepscount);
                @endphp

                <canvas id="barChart" style="max-height: 400px; display: block; box-sizing: border-box;"></canvas>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const ctx = document.getElementById('barChart').getContext('2d');

                        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(75,192,192,0.6)');
                        gradient.addColorStop(1, 'rgba(153,102,255,0.6)');

                        const budgets = @json($budgetscount);
                        const steps = @json($xLabels);
                        const percentages = @json($percentagecount);
                        const completeCount = @json($completecount);

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: steps, // X-axis: Step-1, Step-2, etc.
                                datasets: [{
                                    label: 'Rehab Progress Complete (' + completeCount + '%)',
                                    data: percentages,
                                    backgroundColor: gradient,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 2,
                                    borderRadius: 5,
                                    hoverBackgroundColor: 'rgba(75,192,192,0.8)'
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true,
                                        labels: {
                                            font: {
                                                size: 14,
                                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                                            },
                                            color: '#333'
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Rehab Progress Completion by Budget',
                                        font: {
                                            size: 18
                                        },
                                        color: '#111'
                                    },
                                    tooltip: {
                                        displayColors: false,
                                        callbacks: {
                                            title: function(context) {
                                                const index = context[0].dataIndex;
                                                return 'Budget: ' + budgets[index].toLocaleString();
                                            },
                                            label: function(context) {
                                                return ' Progress: ' + context.parsed.y + '%';
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        ticks: {
                                            font: {
                                                size: 12
                                            },
                                            color: '#333'
                                        },
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        ticks: {
                                            font: {
                                                size: 12
                                            },
                                            color: '#333',
                                            callback: function(value) {
                                                return value + '%';
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0,0,0,0.05)'
                                        }
                                    }
                                },
                                animation: {
                                    duration: 1000,
                                    easing: 'easeOutBounce'
                                }
                            }
                        });
                    });
                </script>


                <!-- End Bar CHart -->

            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        var imageindex = "{{ $y }}";
        var pageMode = "edit";
    </script>
@endpush
