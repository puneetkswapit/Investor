$(document).ready(function () {
    $('#selectcategory').on('input', function () {
        var catgid = $(this).val();
        $('.multiselect').val(null).trigger('change');
        $.ajax({
            type: "POST",
            url: catgurl,
            data: {
                _token: csrf_token,
                catgid: catgid
            },
            cache: false,
            success: function (data) {
                $("#selectsubcategory").html(data);
            }
        });
    })
})

$(document).ready(function () {
    $('.number-input').on('input', function () {
        // Allow only digits and one decimal point
        let value = $(this).val();
        value = value.replace(/[^0-9.]/g, '');         // Remove non-numeric characters
        value = value.replace(/(\..*?)\..*/g, '$1');    // Allow only one decimal point
        $(this).val(value);
    });
});

//////////////////////// User Search Ajax ///////////////////////

$(document).ready(function () {
    $('#usersearch').on('input', function () {
        var keyword = $(this).val();
        $.ajax({
            type: "POST",
            url: search_url,
            data: {
                _token: csrf_token,
                keyword: keyword
            },
            cache: false,
            success: function (data) {
                $(".new-value").html(data);
            }
        });
    })
})

//////////////////////// User Search Ajax End ///////////////////////

//////////////////////// Get User Property Ajax ///////////////////////

$(document).ready(function () {
    $('#choiceuser').on('change', function () {
        $('#selectuserproperty').val(null).trigger('change');
        var uid = $(this).val();
        $.ajax({
            type: "POST",
            url: propurl,
            data: {
                _token: csrf_token,
                uid: uid
            },
            cache: false,
            success: function (data) {
                $("#selectuserproperty").html(data);
            }
        });
    })
})

//////////////////////// Get User Property Ajax End ///////////////////////

//////////////////////// Rehab Property Ajax Start ///////////////////////

$(document).ready(function () {
    $('.add-new-rehab').click(function () {

        function showError(element, message) {
            element.addClass('is-invalid');
            element.next('.invalid-feedback').text(message).show();
        }

        function clearError(element) {
            element.removeClass('is-invalid');
            element.next('.invalid-feedback').hide();
        }

        $('#selectreason').on('change', function () {
            if ($(this).val() === 'Other') {
                $('.other-reason-main').show();
            } else {
                $('.other-reason-main').hide();
                $('#other_reason').val('').removeClass('is-invalid');
            }
        });


        let isValid = true;

        // Property validation
        const property = $('#selectproperty');
        if (property.val() === '') {
            showError(property, 'Please select a property');
            isValid = false;
        } else {
            clearError(property);
        }

        // Reason validation
        const reason = $('#selectreason');
        if (reason.val() === '') {
            showError(reason, 'Please select a reason');
            isValid = false;
        } else {
            clearError(reason);
        }
        var other_reason = '';
        // Other Reason validation
        if (reason.val() === 'Other') {
            other_reason = $('#other_reason').val();
            const otherReason = $('#other_reason');
            if (otherReason.val().trim() === '') {
                showError(otherReason, 'Please provide other reason');
                isValid = false;
            } else {
                clearError(otherReason);
            }
        }

        if (!isValid) {
            e.preventDefault();
        }
        var selectproperty = $('#selectproperty').val();
        var rehab_reason = $('#selectreason').val();


        console.log(rehab_reason);
        $.ajax({
            type: "POST",
            url: saverehab,
            data: {
                _token: csrf_token,
                property_id: selectproperty,
                reason: rehab_reason,
                other_reason: other_reason
            },
            cache: false,
            success: function (data) {
                if (data == '1') {
                    $('#rehabModal').modal('show');
                } else {
                    window.location.href = newrehab;
                }

                // $("#selectuserproperty").html(data);
            }
        });
    });
})


//////////////////////// Rehab Property Ajax End ///////////////////////