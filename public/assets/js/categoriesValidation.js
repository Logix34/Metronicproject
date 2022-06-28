"use strict";

// Class Definition
var KTLogin = function() {
    var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

    var _handleEditForm = function() {
        var form = KTUtil.getById('kt_category_edit_form');
        var form = KTUtil.getById('kt_category_add_form');
        var formSubmitUrl = KTUtil.attr(form, 'action');
        var formSubmitButton = KTUtil.getById('kt_category_submit');
        var formSubmitButton = KTUtil.getById('kt_category_update_submit');

        if (!form) {
            return;
        }
        FormValidation
            .formValidation(
                form,
                {
                    fields: {
                        name: {
                            validators: {
                                notEmpty: {
                                    message: 'Name is required'
                                }
                            }
                        },
                        banner_image: {
                            validators: {
                                notEmpty: {
                                    message: 'Banner Image is required'
                                }
                            }
                        },
                        square_image: {
                            validators: {
                                notEmpty: {
                                    message: 'Square Image is required'
                                }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                        bootstrap: new FormValidation.plugins.Bootstrap({
                            //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                            //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                        })
                    }
                }
            )

            // .on('core.form.invalid', function() {
            //     Swal.fire({
            //         text: "Sorry, fill all fields, please try again.",
            //         icon: "error",
            //         buttonsStyling: false,
            //         confirmButtonText: "Ok, got it!",
            //         customClass: {
            //             confirmButton: "btn font-weight-bold btn-light-primary"
            //         }
            //     }).then(function() {
            //         KTUtil.scrollTop();
            //     });
            // });
    }



    // Public Functions
    return {
        init: function() {
            _handleEditForm();

        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLogin.init();
});



