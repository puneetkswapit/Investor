@extends('admin.layout.main')
@section('title', 'Add Property');
@section('body')

    <section class="section">
        <div class="status">
            <h4>{{ session('status') }}</h4>
            @error('property_image')
                <div style="color: red" class="error">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <h5 class="card-title">Add Property</h5>

        <form method="post" action="{{ route('Admin.SaveProperty') }}" class="row g-3 needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body mt-4">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="propertyname" class="form-label">Property Name</label>
                                    <input type="text" placeholder="Enter Property Name" class="form-control"
                                        name="name" id="propertyname" required>
                                    <div class="invalid-feedback">
                                        The property name is required
                                    </div>
                                </div>
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="propertysubtitle" class="form-label">Property Sub Title</label>
                                    <input type="text" placeholder="Enter Property Subtitle" class="form-control"
                                        name="subtitle" id="propertysubtitle">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row ">
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="propertydate" class="form-label">Close Date</label>
                                    <input type="date" class="form-control" name="closedate" id="propertydate">
                                </div>
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="propertyyearbuilt" class="form-label">Year Built</label>
                                    <input type="text" class="form-control" name="yearbuilt" id="propertyyearbuilt">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="position-relative form-input-wrap">
                                <label for="propertylocation" class="form-label">Property Location</label>
                                <input type="text" placeholder="Property Location" class="form-control" name="location"
                                    id="propertylocation" required>
                                <div class="invalid-feedback">
                                    The property location is required
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="equityraise" class="form-label">Equity Raise</label>
                                    <input type="text" placeholder="Equity Raise" class="form-control number-input"
                                        name="equityraise" id="equityraise">
                                </div>
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="minimuminvestment" class="form-label">Minimum Investment</label>
                                    <input type="text" class="form-control number-input" placeholder="Minimum Investment"
                                        name="minimuminvestment" id="minimuminvestment">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" placeholder="Unit" class="form-control" name="unit"
                                        id="unit">
                                </div>
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="occupancy" class="form-label">Occupancy</label>
                                    <input type="text" placeholder="Occupancy" class="form-control" name="occupancy"
                                        id="occupancy">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative form-input-wrap">
                                <label for="rehabrepairs" class="form-label">Rehab and Immediate Repairs</label>
                                <input type="text" class="form-control number-input"
                                    placeholder="Rehab and Immediate Repairs" name="rehabrepairs" id="rehabrepairs">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="position-relative form-input-wrap">
                                <label for="propertydescription" class="form-label">Property Description</label>
                                <textarea placeholder="Enter Property Description" class="form-control" name="description" id="propertydescription"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mt-3">
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="generalpartnershare" class="form-label">General Partner Share %</label>
                                    <input type="text" value="20" placeholder="General Partner Share %:"
                                        class="form-control number-input" name="generalpartnershare"
                                        id="generalpartnershare" required>
                                    <div class="invalid-feedback">
                                        General Partner Share % is required
                                    </div>
                                </div>
                                <div class="col-lg-6 position-relative form-input-wrap">
                                    <label for="investorshare" value="80" class="form-label">Investor Share %</label>
                                    <input type="text" placeholder="Investor Share %"
                                        class="form-control number-input" name="investorshare" id="investorshare"
                                        required>
                                    <div class="invalid-feedback">
                                        Investor Share % is required
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="position-relative form-input-wrap">
                                <label for="websiteurl" class="form-label">Website_url</label>
                                <input type="text" placeholder="Website_url" class="form-control" name="website_url"
                                    id="websiteurl">
                            </div>
                        </div>
                        <div class="col-lg-6">
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="mt-4">Value</h5>
                    <div class="row mt-3">
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="purchaseprice" class="form-label">Purchase Price</label>
                            <input type="text" placeholder="Purchase Price" class="form-control number-input"
                                name="purchaseprice" id="purchaseprice" required>
                            <div class="invalid-feedback">
                                Purchase price is required
                            </div>
                        </div>
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="valueasrenovated" class="form-label">Value "As If Renovated"</label>
                            <input type="text" placeholder='Value "As If Renovated"' class="form-control number-input"
                                name="valueasrenovated" id="valueasrenovated">
                        </div>
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="noiamount" class="form-label">NOI Amount</label>
                            <input type="text" placeholder="NOI Amount" class="form-control number-input"
                                name="noiamount" id="noiamount">
                        </div>
                        <div class="col-lg-3 position-relative form-input-wrap">
                            <label for="noidescription" class="form-label">NOI Description (Proforma)</label>
                            <input type="text" placeholder="NOI(Proforma)" class="form-control" name="noidescription"
                                id="noidescription">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="mt-4">Loan Details</h5>
                    <div class="row mt-3">
                        <div class="col-lg-4 position-relative form-input-wrap">
                            <label for="lender" class="form-label">Lender:</label>
                            <input type="text" placeholder="Lender" class="form-control" name="lender"
                                id="lender">
                        </div>
                        <div class="col-lg-4 position-relative form-input-wrap">
                            <label for="loanamount" class="form-label">Loan Amount:</label>
                            <input type="text" placeholder="Loan Amount" class="form-control number-input"
                                name="loanamount" id="loanamount">
                        </div>
                        <div class="col-lg-4 position-relative form-input-wrap">
                            <label for="typeofloan" class="form-label">Type of loan:</label>
                            <input type="text" placeholder="Type Of Loan" class="form-control" name="typeofloan"
                                id="typeofloan">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="loanterm" class="form-label">Loan Term:</label>
                            <input type="text" placeholder="E.G. 12 Years Fixed" class="form-control" name="loanterm"
                                id="loanterm">
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="interestrate" class="form-label">Interest Rate:</label>
                            <input type="text" placeholder="Interest Rate" class="form-control" name="interestrate"
                                id="interestrate">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="interestonly" class="form-label">Interest Only:</label>
                            <input type="text" placeholder="Interest Only" class="form-control" name="interestonly"
                                id="interestonly">

                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="interestonlyexpires" class="form-label">Interest Only Expires (mm/yyyy)</label>
                            <input type="text" placeholder="Interest Only Expires" class="form-control"
                                name="interestonlyexpires" id="interestonlyexpires">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="annualdebtservices1" class="form-label">Annual Debt Services (mm/yyyy -
                                mm/yyyy)</label>
                            <input type="text" placeholder="Services" class="form-control" name="annualdebtservices1"
                                id="annualdebtservices1">
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="interestonlyamount" class="form-label">Interest Only Amount</label>
                            <input type="text" placeholder="Amount" class="form-control" name="interestonlyamount"
                                id="interestonlyamount">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="annualdebtservices2" class="form-label">Annual Debt Services (mm/yyyy -
                                mm/yyyy)</label>
                            <input type="text" placeholder="Services" class="form-control" name="annualdebtservices2"
                                id="annualdebtservices2">
                        </div>
                        <div class="col-lg-6 position-relative form-input-wrap">
                            <label for="amortizedamount" class="form-label">Amortized Amount</label>
                            <input type="text" placeholder="Amount" class="form-control" name="amortizedamount"
                                id="amortizedamount">
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body mt-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="position-relative form-input-wrap">
                                <label class="form-label">Asset Managers :</label>
                                <div>
                                    <input type="text" placeholder="Line1" class="form-control"
                                        name="asset_manager_line1">
                                </div>
                                <div class="mt-2">
                                    <input type="text" placeholder="Line2" class="form-control"
                                        name="asset_manager_line2">
                                </div>
                                <div class="mt-2">
                                    <input type="text" placeholder="Line3" class="form-control"
                                        name="asset_manager_line3">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative form-input-wrap">
                                <label class="form-label">Ownership Entity :</label>
                                <div>
                                    <input type="text" placeholder="Line1" class="form-control"
                                        name="ownership_entity_line1">
                                </div>
                                <div class="mt-2">
                                    <input type="text" placeholder="Line2" class="form-control"
                                        name="ownership_entity_line2">
                                </div>
                                <div class="mt-2">
                                    <input type="text" placeholder="Line3" class="form-control"
                                        name="ownership_entity_line3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body mt-4">
                    <div class="position-relative form-input-wrap">
                        <label for="property_note" class="form-label">Note</label>
                        <textarea class="form-control summernote-editor" name="property_note" id="property_note"></textarea>
                    </div>

                    <div class="position-relative form-input-wrap mt-3">
                        <label for="property_iframe" class="form-label">Iframe</label>
                        <textarea class="form-control" name="property_iframe" id="property_iframe"></textarea>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-3">
                            <div class="position-relative">
                                <label for="selectcategory" class="form-label">Add Category</label>
                                <select name="category" class="form-select " id="selectcategory" required="">
                                    <option selected="" disabled="" value="">Choose...</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback">
                                    The property category is required.
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="position-relative">
                                <label for="selectsubcategory" class="form-label">Add Subcategories</label>
                                <select name="subcategory[]" class="form-select multiselect" id="selectsubcategory"
                                    multiple>

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative form-input-wrap">
                                <label for="property_image" class="form-label">
                                    Property Image (Upload Image Size 350X350):
                                </label>
                                <input type="file" class="form-control" name="property_image" id="property_image"
                                    accept="image/*">

                                <br>
                                <img id="final_cropped_image" src="" alt="Final Preview"
                                    class="img-thumbnail mt-3" style="display:none; width: 350px; height: 350px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bootstrap Modal for cropping -->
            <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Crop Property Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div style="max-width: 100%; max-height: 500px;">
                                <img id="image_to_crop" style="max-width: 100%; display: block; margin: 0 auto;" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="crop_button" class="btn btn-primary">Crop & Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>

        </form>



    </section>

@endsection
@push('js')
    <script>
        var catgurl = "{{ route('Admin.GetSubCategories') }}";
    </script>
@endpush
