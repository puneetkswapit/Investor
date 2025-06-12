@extends('user.layout.main')
@section('title', 'Edit User');
@section('body')

    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>


        <h5 class="card-title">Edit User</h5>

        <form method="post" action="{{ route('User.UpdateUser') }}" class="row g-3 needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="username" class="form-label">Name</label>
                            <input type="text" placeholder="Name" value="{{ $user->name ?? '' }}" class="form-control"
                                name="username" id="username" required>
                            <div class="invalid-feedback">
                                Name is required
                            </div>
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="email" value="{{ $user->email ?? '' }}" placeholder="Email Address"
                                class="form-control" name="useremail" id="useremail" required>
                            <div class="invalid-feedback">
                                Email is required
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="phonenumber" class="form-label">Phone No.</label>
                            <input value="{{ $user->mobile ?? '' }}" type="text" placeholder="Phone Number"
                                class="form-control number-input" name="phonenumber" id="phonenumber">
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="altphonenumber" class="form-label">Alt. Phone No.</label>
                            <input type="text" value="{{ $user->alt_phone ?? '' }}" placeholder="Alternate phone number"
                                class="form-control number-input" name="altphonenumber" id="altphonenumber">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-4 position-relative form-input-wrap">
                            <label for="mailingaddress" class="form-label">Mailing Address</label>
                            <input type="text" value="{{ $user->mailing_address ?? '' }}" placeholder="Mailing Address"
                                class="form-control" name="mailingaddress" id="mailingaddress">
                        </div>
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="usercity" class="form-label">City</label>
                            <input type="text" value="{{ $user->city ?? '' }}" placeholder="City" class="form-control"
                                name="usercity" id="usercity">
                        </div>
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="userstate" class="form-label">State</label>
                            <input type="text" value="{{ $user->state ?? '' }}" placeholder="State" class="form-control"
                                name="userstate" id="userstate">
                        </div>
                        <div class="col-lg-2 position-relative form-input-wrap">
                            <label for="zipcode" class="form-label">Zip Code</label>
                            <input type="text" value="{{ $user->zip_code ?? '' }}" placeholder="Zip Code"
                                class="form-control number-input" name="zipcode" id="zipcode">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <div class="position-relative form-input-wrap">
                                <label for="usertype" class="form-label">User Type</label>
                                <select name="usertype[]" class="form-select multiselect" id="selectusertype" required=""
                                    multiple>
                                    <option {{ $user->investor == 1 ? 'selected' : '' }} value="1">Investor</option>
                                    <option {{ $user->partner == 1 ? 'selected' : '' }} value="2">Partner </option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select user type.
                                </div>
                            </div>

                            <div @if ($user->investor == 0) style="display: none" @endif
                                class="position-relative form-input-wrap investor-property mt-3">
                                <label for="investorproperty" class="form-label">Choose Investor Property</label>
                                <select name="investorproperty[]" class="form-select multiselect" id="investorproperty"
                                    multiple>
                                    @if ($properties->isNotEmpty())
                                        @php
                                            $old_investor_prop = [];
                                            if ($investorprop->isNotEmpty()) {
                                                foreach ($investorprop as $iprop) {
                                                    $old_investor_prop[] = $iprop->property_id;
                                                }
                                            }
                                        @endphp
                                        @foreach ($properties as $property)
                                            <option
                                                {{ in_array($property->property_id, $old_investor_prop) ? 'selected' : '' }}
                                                value="{{ $property->property_id }}">{{ $property->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div @if ($user->partner == 0) style="display: none" @endif
                                class="position-relative form-input-wrap partner-property mt-3">
                                <label for="partnerproperty" class="form-label">Choose Partner Property</label>
                                <select name="partnerproperty[]" class="form-select multiselect" id="partnerproperty"
                                    multiple>
                                    @if ($properties->isNotEmpty())
                                        @php
                                            $old_partner_prop = [];
                                            if ($partnerprop->isNotEmpty()) {
                                                foreach ($partnerprop as $pprop) {
                                                    $old_partner_prop[] = $pprop->property_id;
                                                }
                                            }
                                        @endphp
                                        @foreach ($properties as $property)
                                            <option
                                                {{ in_array($property->property_id, $old_partner_prop) ? 'selected' : '' }}
                                                value="{{ $property->property_id }}">{{ $property->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 add-subscriber-input">
                            @php
                                $subscribers = explode(',', $user->subscriber);
                            @endphp
                            @foreach ($subscribers as $subscriber)
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="position-relative form-input-wrap"><label for="subscriber"
                                                class="form-label">Subscriber Name</label><input type="text"
                                                placeholder="Subscriber Name" value="{{ $subscriber }}"
                                                class="form-control" name="subscriber[]" id="subscriber"></div>
                                    </div>
                                    <div class="col-lg-3 mt-4"><button type="button"
                                            class="remove_subscriber_field_button"><i
                                                class="ri-delete-bin-6-line"></i></button></div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="position-relative form-input-wrap">
                                        <label for="subscriber" class="form-label">Subscriber Name</label>
                                        <input type="text" placeholder="Subscriber Name" class="form-control"
                                            name="subscriber[]" id="subscriber">
                                    </div>
                                </div>
                                <div class="col-lg-3 mt-4">
                                    <button type="button" class="add_subscriber_field_button"><i
                                            class="ri-add-box-line"></i></button>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="uid" value="{{ base64_encode($user->user_id) }}">
                        <div class="col-lg-4 add-tag-input">
                            @php
                                $tags = explode(',', $user->tags);
                            @endphp
                            @foreach ($tags as $tag)
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="position-relative form-input-wrap"><label for="tags"
                                                class="form-label">Tags</label><input type="text"
                                                placeholder="Eg. (Company Name)" value="{{ $tag }}"
                                                class="form-control" name="tags[]" id="tags"></div>
                                    </div>
                                    <div class="col-lg-3 mt-4"><button type="button" class="remove_tag_field_button"><i
                                                class="ri-delete-bin-6-line"></i></button></div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="position-relative form-input-wrap">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" placeholder="Eg. (Company Name)" class="form-control"
                                            name="tags[]" id="tags">
                                    </div>
                                </div>

                                <div class="col-lg-3 mt-4">
                                    <button type="button" class="add_tag_field_button"><i
                                            class="ri-add-box-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                </div>
        </form>
    </section>

@endsection
@push('js')
@endpush
