$(document).ready(function () {
    $('.multiselect').select2({
        placeholder: "Choose...",
        // allowClear: true
    })
})

//  Edit Main category Js

$(document).ready(function () {
    $('.edit-main-category').click(function () {
        var btnid = $(this).data('id');
        var btnname = $(this).data('name');
        $('.category-modal-data .category-name-input').val(btnname);
        $('.category-modal-data .category-id-input').val(btnid);

    })
})

var cropper;
var cropperModal;
$('#property_image').on('change', function (e) {
    cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));

    const file = e.target.files[0];
    if (!file || !file.type.startsWith('image/')) return;

    const reader = new FileReader();
    reader.onload = function (event) {
        const image = $('#image_to_crop');
        image.attr('src', event.target.result);

        // Wait until modal is fully shown to init Cropper
        $('#cropperModal').on('shown.bs.modal', function () {
            if (cropper) cropper.destroy();
            cropper = new Cropper(image[0], {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                zoomable: true,
                cropBoxResizable: false,
            });
        });

        cropperModal.show();
    };
    reader.readAsDataURL(file);
});

$('#crop_button').on('click', function () {
    const canvas = cropper.getCroppedCanvas({
        width: 350,
        height: 350
    });

    const croppedImage = canvas.toDataURL('image/png');
    $('#final_cropped_image').attr('src', croppedImage).show();

    cropperModal.hide();
});

$(function () {
    $('#sortable-properties').sortable({
        update: function (event, ui) {
            var order = [];
            $('.sortable-item').each(function () {
                order.push($(this).data('id'));
            });

            // Send AJAX to update order in DB
            $.ajax({
                url: orderurl,
                method: 'POST',
                data: {
                    order: order,
                    _token: csrf_token
                },
                success: function (response) {
                    // console.log('Order updated:', response);
                },
                error: function () {
                    alert('Something went wrong!');
                }
            });
        }
    });
});

/////////////////////////// Add Partner Form Js Start ///////////////////////////////////
$(document).ready(function () {
    $('#selectusertype').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue.includes('1')) {
            $('.investor-property').css('display', 'grid');
            $('#investorproperty').trigger('change');
        } else {
            $('.investor-property').hide();
        }
        if (selectedValue.includes('2')) {
            $('.partner-property').css('display', 'grid');
            $('#partnerproperty').trigger('change');
        } else {
            $('.partner-property').hide();
        }
    })
})


$(document).ready(function () {
    var max_fields = 10; //maximum input boxes allowed
    var subscriber_wrapper = $(".add-subscriber-input"); //Fields wrapper
    var subscriber_add_button = $(".add_subscriber_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(subscriber_add_button).click(function (e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(subscriber_wrapper).append('<div class="row"><div class="col-lg-9"><div class="position-relative form-input-wrap"><label for="subscriber" class="form-label">Subscriber Name</label><input type="text" placeholder="Subscriber Name" class="form-control" name="subscriber[]" id="subscriber"></div></div><div class="col-lg-3 mt-4"><button type="button" class="remove_subscriber_field_button"><i class="ri-delete-bin-6-line"></i></button></div></div>');
        }
    });

    $(subscriber_wrapper).on("click", ".remove_subscriber_field_button", function (e) { //user click on remove text
        e.preventDefault(); $(this).parent().parent('div').remove(); x--;
    })
});

$(document).ready(function () {
    var max_fields = 10; //maximum input boxes allowed
    var tag_wrapper = $(".add-tag-input"); //Fields wrapper
    var tag_add_button = $(".add_tag_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(tag_add_button).click(function (e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(tag_wrapper).append('<div class="row"><div class="col-lg-9"><div class="position-relative form-input-wrap"><label for="tags" class="form-label">Tags</label><input type="text" placeholder="Eg. (Company Name)" class="form-control" name="tags[]" id="tags"></div></div><div class="col-lg-3 mt-4"><button type="button" class="remove_tag_field_button"><i class="ri-delete-bin-6-line"></i></button></div></div>');
        }
    });

    $(tag_wrapper).on("click", ".remove_tag_field_button", function (e) { //user click on remove text
        e.preventDefault(); $(this).parent().parent('div').remove(); x--;
    })
});
/////////////////////////// Add Partner Form Js End ///////////////////////////////////

///////////////// Property Rehab Progress Js Start //////////////////////////////////

$(document).ready(function () {

    $('#selectreason').change(function () {
        var reason = $(this).val();
        if (reason == "Other") {
            $('.other-reason-inner').append('<input type="text" placeholder="Please enter rehab reason." class="form-control" name="other_reason" id="other_reason" required>');
            $('.other-reason-main').show();
        } else {
            $('.other-reason-inner').empty();
            $('.other-reason-main').hide();
        }

    })

})

///////////////// Property Rehab Progress Js End //////////////////////////////////

///////////////// Image Preview code Js Start //////////////////////////////////
const fileStore = {};

$(document).on('change', '.images_file_upload', function () {
    const inputElement = $(this);
    const files = this.files;
    const stepId = inputElement.attr('name'); // like images_file_0[]

    // Find preview container
    const previewContainer = inputElement
        .closest('.image-preview-main')
        .next('.row')
        .find('.image-preview');

    if (!fileStore[stepId]) {
        fileStore[stepId] = [];
    }

    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            fileStore[stepId].push(file);

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = $('<img height="100" width="100" class="m-1 border rounded">')
                    .attr('src', e.target.result);
                previewContainer.append(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // Clear actual input to prevent overwriting
    inputElement.val('');
});

// Before form submit — add files as Blob inputs
$('#mainForm').on('submit', function (e) {
    Object.keys(fileStore).forEach(stepKey => {
        const files = fileStore[stepKey];
        files.forEach((file, index) => {
            const fileInput = new File([file], file.name, { type: file.type });
            const dt = new DataTransfer();
            dt.items.add(fileInput);

            const input = $('<input type="file" multiple style="display:none;">')
                .attr('name', stepKey)
                .prop('files', dt.files);

            $('#mainForm').append(input);
        });
    });
});

$(document).ready(function () {
       let stepIndex = (typeof imageindex !== 'undefined') ? imageindex : 0;
    // Add new step
    $('#addNewStep').click(function (e) {
        
        e.preventDefault();

        let $original = $('.progress-step').first();
        let $clone = $original.clone();

        // Clear input values
        $clone.find('input, textarea').val('');
        $clone.find('.image-preview').empty();
        $clone.find('.invalid-feedback').hide();

        // Unique file input name for image array
        $clone.find('input[type="file"]').attr('name', 'images_file_' + stepIndex + '[]');
        $clone.find('.remove-step-old').removeClass('remove-step-old').addClass('remove-step');
        // Show remove button if hidden
        $clone.find('.remove-step-wrap').removeClass('d-none');

        $('#stepsContainer').append($clone);
        stepIndex++;

        updateStepNumbers();
    });

    // Remove step
    $(document).on('click', '.remove-step', function (e) {
        e.preventDefault();

        $(this).closest('.progress-step').remove();
        updateStepNumbers();
    });
    $(document).on('click', '.remove-step-old', function (e) {
        e.preventDefault();
        $(this).closest('.progress-step-wrap').remove();

        updateStepNumbers();
    });
    // Update step header numbers
    function updateStepNumbers() {
        $('.progress-step').each(function (index) {
            $(this).find('.step-value').text('Step: ' + (index + 1));
        });
    }
});


///////////////// Image Preview code Js End //////////////////////////////////
$(document).ready(function () {
    var currentPath = window.location.pathname;

    // Loop through all sidebar links
    $('#sidebar-nav a').each(function () {
        var linkPath = new URL(this.href).pathname;

        // Check for exact path match
        if (currentPath === linkPath) {
            $(this).addClass('active');

            // Expand the parent .collapse menu if it's nested
            var parentCollapse = $(this).closest('.collapse');
            if (parentCollapse.length) {
                parentCollapse.addClass('show');
                parentCollapse.prev('a').removeClass('collapsed');
            }
        }
    });
});
