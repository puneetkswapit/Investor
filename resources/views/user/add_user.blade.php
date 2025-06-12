@extends('user.layout.main')
@section('title', 'Add User');
@section('body')

    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
        </div>


        <h5 class="card-title">Add User</h5>

        <form method="post" action="{{ route('User.SaveUser') }}" class="row g-3 needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="username" class="form-label">Name</label>
                            <input type="text" placeholder="Name" class="form-control" name="username" id="username"
                                required>
                            <div class="invalid-feedback">
                                Name is required
                            </div>
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="email" placeholder="Email Address" class="form-control" name="useremail"
                                id="useremail" required>
                            <div class="invalid-feedback">
                                Email is required
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="phonenumber" class="form-label">Phone No.</label>
                            <input type="text" placeholder="Phone Number" class="form-control number-input"
                                name="phonenumber" id="phonenumber">
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="altphonenumber" class="form-label">Alt. Phone No.</label>
                            <input type="text" placeholder="Alternate phone number" class="form-control number-input"
                                name="altphonenumber" id="altphonenumber">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-4 position-relative form-input-wrap">
                            <label for="mailingaddress" class="form-label">Mailing Address</label>
                            <input type="text" placeholder="Mailing Address" class="form-control" name="mailingaddress"
                                id="mailingaddress">
                        </div>
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="usercity" class="form-label">City</label>
                            <input type="text" placeholder="City" class="form-control" name="usercity" id="usercity">
                        </div>
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="userstate" class="form-label">State</label>
                            <input type="text" placeholder="State" class="form-control" name="userstate" id="userstate">
                        </div>
                        <div class="col-lg-2 position-relative form-input-wrap">
                            <label for="zipcode" class="form-label">Zip Code</label>
                            <input type="text" placeholder="Zip Code" class="form-control number-input" name="zipcode"
                                id="zipcode">
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
                                    <option value="1">Investor</option>
                                    <option value="2">Partner </option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select user type.
                                </div>
                            </div>

                            <div style="display: none" class="position-relative form-input-wrap investor-property mt-3">
                                <label for="investorproperty" class="form-label">Choose Investor Property</label>
                                <select name="investorproperty[]" class="form-select multiselect" id="investorproperty"
                                    multiple>
                                    @if ($properties->isNotEmpty())
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->property_id }}">{{ $property->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div style="display: none" class="position-relative form-input-wrap partner-property mt-3">
                                <label for="partnerproperty" class="form-label">Choose Partner Property</label>
                                <select name="partnerproperty[]" class="form-select multiselect" id="partnerproperty"
                                    multiple>
                                    @if ($properties->isNotEmpty())
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->property_id }}">{{ $property->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 add-subscriber-input">
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
                        <div class="col-lg-4 add-tag-input">
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
                    <div class="col-lg-12 text-center">
                        <div class="position-relative form-input-wrap">
                             <input type="checkbox" value="1" name="mail"
                                id="mail">
                            <label for="mail" class="form-label">Do you want to send an email to the user?</label>
                           
                        </div>
                    </div>

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
