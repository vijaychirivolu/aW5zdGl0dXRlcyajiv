/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ajaxFlag = false;
var abortAjaxFlag = '';
var dataTable = '';
$(window).load(function () {
    $("#spinner").fadeOut("slow");
});
$(document).ready(function () {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $("#btnToggleSelect").click(function () {
        $("#tree2").dynatree("getRoot").visit(function (node) {
            node.toggleSelect();
        });
        return false;
    });
    $("#btnDeselectAll").click(function () {
        $("#tree2").dynatree("getRoot").visit(function (node) {
            node.select(false);
        });
        return false;
    });
    $("#btnSelectAll").click(function () {
        $("#tree2").dynatree("getRoot").visit(function (node) {
            node.select(true);
        });
        return false;
    });
});
$(
        function () {
            Admin.init();
        }
);
function updateCountdown() {
    // 140 is the max message length
    var remaining = 500 - $('.help_text').val().length;
    jQuery('.countdown').text(remaining + ' characters remaining.');
}

function numbersonly(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode
    if (unicode != 8 && unicode != 9) { //if the key isn't the backspace key (which we should allow)
        if (unicode != 45 && unicode != 46 && (unicode < 48 || unicode > 57)) //if not a number
            return false //disable key press
    }

}

var Admin = function () {
    var validationRules = getValidationRules();
    return {
        init: init,
        ajaxInit: ajaxInit,
        confirmMessageAlerts: confirmMessageAlerts
    };

    /*
     * This function will call when page loading
     * 
     */

    function init()
    {
        initCustomBrowseButton();
        initFileSelect();
        ajaxFormSubmit();
        confirmMessageAlerts();
        initSchoolAjaxDataTables();
        initJqueryDataTable();
        initImageAnimateHover();
        initSummernote();
        initCitiesByStateId();
        initAddressByCityState();
        initSchoolByAddress();
        initRole();
        displayHiddenValues();
        initGalleryUpload();
        initSchoolWizardSteps();
        initUserAjaxDataTables();
        initDateRangePicker();
        initDatePicker();
        initStudentAjaxDataTables();
        initClassSectionMultiple();
        initInstituteTimings();
        instituteChangingHours();
    }


    /*
     * This function will call for ajax actions
     * 
     */

    function ajaxInit()
    {
        initFileSelect();
        ajaxFormSubmit();
        initCustomBrowseButton();
    }

    /**
     * 
     * @returns {undefined}
     */
    function initDateRangePicker() {
        $('.input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"
        });
    }

    /**
     * 
     * @returns {undefined}
     */
    function initDatePicker() {
        $('.date-picker').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"
        });
    }

    /**
     * 
     * @returns {undefined}
     */
    function initCharacterLimit()
    {
        $(".help_text").each(function () {
            updateCountdown();
            $(this).change(updateCountdown);
            $(this).keyup(updateCountdown);
        });
    }

    /**
     * 
     * @returns {undefined}
     */
    function initCustomBrowseButton()
    {
        $('.custom_file_button').filestyle({
            buttonName: 'btn-primary btn-file',
            buttonText: "Browse",
            icon: false
        });
    }

    function displayHiddenValues() {
        var userrole = $(".user-role").val();
        if (userrole != "" && userrole != null && userrole != 1001 && userrole != 1002) {
            $('.role-based-hide').show();
        }
    }

    /*
     * Custom validation rules
     * 
     */
    function getValidationRules()
    {
        var custom = {
            focusCleanup: false,
            wrapper: 'div',
            errorElement: 'span',
            highlight: function (element) {
                $(element).parents('.form-group').removeClass('success').addClass('error');
                $(element).removeClass('success').addClass('error');
            },
            success: function (element) {
                $(element).parents('.form-group').removeClass('error').addClass('success');
                $(element).removeClass('error').addClass('success');
                $(element).parents('.form-group:not(:has(.clean))').find('div:last').before('<div class="clean"></div>');
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parents('.form-group'));
                //element.attr("placeholder", error.text());
            }

        };

        return custom;
    }

    /**
     * 
     * @returns {undefined}
     */
    function initCitiesByStateId() {
        $(".citi-by-state").each(function () {
            $(this).change(function () {
                var state = $(this).val();
                if (state != null && state != 'undefined') {
                    if (ajaxFlag == false) {
                        ajaxFlag = true;
                        var formdata = {state: state};
                        $.ajax({
                            url: SITEURL + "admin/users/fetchCitiesByState",
                            type: 'POST',
                            data: formdata,
                            dataType: "json",
                            success: function (data, textStatus, jqXHR)
                            {
                                var append_data = "<option value=''>Select City</option>";
                                for (var i = 0; i < data.length; i++) {
                                    append_data += '<option value="'+data[i]+'">' + data[i] + '</option>';
                                }
                                ajaxFlag = false;
                                $("#UserAccessLevelUserCity").html(append_data);
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                ajaxFlag = false;
                            }
                        });
                    }
                }
            });
        });
    }
    /**
     * 
     * @returns {undefined}
     */
    function initAddressByCityState() {
        $(".city-state-address").each(function () {
            $(this).change(function () {
                var city = $(this).val();
                var state = $("#UserAccessLevelUserState").val();
                if ((state != null && state != 'undefined') && (city != null && city != 'undefined')) {
                    if (ajaxFlag == false) {
                        ajaxFlag = true;
                        var formdata = {state: state, city: city};
                        $.ajax({
                            url: SITEURL + "admin/users/fetchAddressByCityState",
                            type: 'POST',
                            data: formdata,
                            dataType: "json",
                            success: function (data, textStatus, jqXHR)
                            {
                                var append_data = "<option value=''>Select Address</option>";
                                for (var i = 0; i < data.length; i++) {
                                    append_data += '<option value="'+data[i]+'">' + data[i] + '</option>';
                                }
                                ajaxFlag = false;
                                $("#UserAccessLevelUserAddress").html(append_data);
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                ajaxFlag = false;
                            }
                        });
                    }
                }
            });
        });
    }


    function initSchoolByAddress() {
        $(".school-address").each(function () {
            $(this).change(function () {
                var address = $(this).val();
                var state = $("#UserAccessLevelUserState").val();
                var city = $("#UserAccessLevelUserCity").val();
                if ((state != null && state != 'undefined') && (city != null && city != 'undefined') && (address != null && address != 'undefined')) {
                    if (ajaxFlag == false) {
                        ajaxFlag = true;
                        var formdata = {state: state, city: city, address: address};
                        $.ajax({
                            url: SITEURL + "admin/users/fetchInstituteByAddress",
                            type: 'POST',
                            data: formdata,
                            dataType: "json",
                            success: function (data, textStatus, jqXHR)
                            {
                                var append_data = "<option value=''>Select School</option>";
                                for (var i = 0; i < data.length; i++) {
                                    append_data += '<option value="'+data[i]["id"]+'">' + data[i]["name"] + '</option>';
                                }
                                ajaxFlag = false;
                                $("#UserAccessLevelInstituteId").html(append_data);
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                ajaxFlag = false;
                            }
                        });
                    }
                }
            });
        });
    }


    function initRole() {
        $(".user-role").each(function () {
            $(this).change(function () {
                var role = $(this).val();
                if (role != "" && role != 1001 && role != 1002) {
                    $(".role-based-hide").show();
                } else {
                    $(".role-based-hide").hide();
                }
            });
        });
    }
    /**
     * 
     */
    function initFileSelect()
    {
        $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (input.length) {
                input.val(log);
            } else {
                if (log)
                    alert(log);
            }

        });
    }

    function initIcheck()
    {

    }

    function ajaxFormSubmit()
    {
        $('.ajax-form').each(function (ele) {
            var formObj = $(this);
            var buttonObj = formObj.find(':submit:last');
            var callback = typeof formObj.attr('callback') != 'undefined' ? formObj.attr('callback') : null;
            $(this).submit(function (e)
            {
                if (!formObj.valid()) {
                    return false;
                }
                //formObj.parent().html("Loading....");
                var OldButtonValue = (buttonObj.val() != '') ? buttonObj.val() : buttonObj.html();
                buttonObj.val('Loading...').html('Loading...');
                buttonObj.attr('disabled', true);
                var formURL = formObj.attr("action");

                if (window.FormData !== undefined)  // for HTML5 browsers
                {
                    var formData = new FormData(this);
                    $.ajax({
                        url: formURL,
                        type: 'POST',
                        data: formData,
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data, textStatus, jqXHR)
                        {
                            var isJSON = true;
                            try {
                                var jsonData = jQuery.parseJSON(data);
                            } catch (err) {
                                isJSON = false;
                            }
                            if (isJSON) {
                                if (typeof (jsonData.status) != 'undefined' && jsonData.status == 'success') {
                                    if (callback != null) {
                                        window[callback]();
                                    } else {
                                        if (typeof (jsonData.message) != 'undefined') {
                                            swal({
                                                title: "Success!",
                                                text: jsonData.message,
                                                type: "success"
                                            },
                                            function () {
                                                if (jsonData.callback.prefix) {
                                                    window.location.href = SITEURL + "admin/" + jsonData.callback.controller + "/" + jsonData.callback.action;
                                                } else {
                                                    window.location.href = SITEURL + jsonData.callback.controller + "/" + jsonData.callback.action;
                                                }

                                            });
                                            buttonObj.val(OldButtonValue).html(OldButtonValue);
                                            buttonObj.attr('disabled', true);
                                        }
                                    }
                                }
                            } else {
                                /*swal({
                                 title: "Success!",
                                 text: 'Saving failed due to errors!',
                                 type: "success"
                                 });*/
                                formObj.parent().html(data);
                                ajaxInit();
                                buttonObj.val(OldButtonValue).html(OldButtonValue);
                                buttonObj.attr('disabled', false);


                            }

                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal({
                                title: "Success!",
                                text: 'AJAX Request Failed',
                                type: "success"
                            });
                            buttonObj.val(OldButtonValue).html(OldButtonValue);
                            buttonObj.attr('disabled', false);
                        }
                    });
                    e.preventDefault();
                }
            });
        });
    }

    /**
     * Confirm message alerts
     * @returns {redirect the url}
     */
    function confirmMessageAlerts() {
        $('.delete-confirm-alert').each(function () {
            $(this).click(function (e) {
                e.preventDefault();
                var deleteMessage = $(this).attr("data-message");
                var deleteUrl = $(this).attr('href');
                deleteMessage = (deleteMessage != '' && deleteMessage != 'undefined') ? deleteMessage : 'You are permenantly deleting this record!';
                swal({
                    title: "Are you sure?",
                    text: deleteMessage,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, I'm sure.",
                    closeOnConfirm: false
                }, function () {
                    if (ajaxFlag == false) {
                        ajaxFlag = true;
                        $.ajax({
                            url: deleteUrl,
                            type: 'GET',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data, textStatus, jqXHR)
                            {
                                ajaxFlag = false;
                                var isJSON = true;
                                try {
                                    var jsonData = jQuery.parseJSON(data);
                                } catch (err) {
                                    isJSON = false;
                                }
                                if (isJSON) {
                                    if (typeof (jsonData.status) != 'undefined' && jsonData.status == 'success') {
                                        if (typeof (jsonData.message) != 'undefined') {
                                            swal({
                                                title: "Success!",
                                                text: jsonData.message,
                                                type: "success"
                                            },
                                            function () {
                                                location.reload(true);
                                            });
                                        }
                                    }
                                } else {
                                    swal({
                                        title: "Failed!",
                                        text: 'AJAX Request Failed',
                                        type: "success"
                                    });
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                ajaxFlag = false;
                                swal({
                                    title: "Failed!",
                                    text: 'AJAX Request Failed',
                                    type: "success"
                                });
                            }
                        });
                        e.preventDefault();
                    }

                });
            });
        });

    }
    function MultipleSelect() {
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    }
    /**
     * 
     * @param {INT} num
     * @returns {unresolved}
     */
    function formatNumber(num) {
        if (num != null && num != 'undefined') {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        } else {
            return 0;
        }
    }
    /**
     * 
     * @param {type} str
     * @returns {String}
     */
    function ucwords(str) {
        //  discuss at: http://phpjs.org/functions/ucwords/
        // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
        // improved by: Waldo Malqui Silva
        // improved by: Robin
        // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // bugfixed by: Onno Marsman
        //    input by: James (http://www.james-bell.co.uk/)
        //   example 1: ucwords('kevin van  zonneveld');
        //   returns 1: 'Kevin Van  Zonneveld'
        //   example 2: ucwords('HELLO WORLD');
        //   returns 2: 'HELLO WORLD'

        return (str + '')
                .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function ($1) {
                    return $1.toUpperCase();
                });
    }

    /**
     * 
     * @param {type} i
     * @returns {String}
     */
    function ordinal_suffix_of(i) {
        var j = i % 10,
                k = i % 100;
        if (j == 1 && k != 11) {
            return i + "st";
        }
        if (j == 2 && k != 12) {
            return i + "nd";
        }
        if (j == 3 && k != 13) {
            return i + "rd";
        }
        return i + "th";
    }


    /**
     * initAjaxDataTable
     * @returns void
     */
    function initUserAjaxDataTables() {
        $(".user-ajax-dataTable").each(function () {
            var ajaxUrl = $(this).attr("data-href");
            var orderColumn = ($(this).attr("data-order") != null && $(this).attr("data-order") != "undefined") ? $(this).attr("data-order") : "";
            $(this).DataTable({
                "dom": 'T<"clear">lfrtip',
                "oTableTools": {
                    "sSwfPath": SITEURL + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf",
                    "aButtons": [
                        {
                            "sExtends": "copy",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "csv",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "xls",
                            "sFileName": "*.xls",
                            "bFooter": false,
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "pdf",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4]
                        }
                    ]
                },
                "responsive": true,
                "iDisplayLength": 10,
                'bProcessing': true,
                'bServerSide': true,
                "order": [[0, "asc"]],
                "oLanguage": {
                    "oPaginate": {
                        "sNext": "<i class='fa fa-arrow-right custom-right'></i>",
                        "sPrevious": "<i class='fa fa-arrow-left custom-right'></i>"
                    }
                },
                'sAjaxSource': SITEURL + 'admin/users/manage.json',
                "aoColumns": [
                    {mData: "User.first_name"},
                    {mData: "User.email"},
                    {mData: "GroupValue.name"},
                    {mData: "Institute.name"}
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    //$('td:eq(0)', nRow).html(aData.State.state_name);
                    //$('td:eq(1)', nRow).html(aData.State.abbrevations);
                    //$('td:eq(2)', nRow).html((aData.State.population !=0 && aData.State.population !=null)?formatNumber(aData.State.population):"N/A");
                    //$('td:eq(3)', nRow).html((aData.State.website_url !="" && aData.State.website_url !=null)?aData.State.website_url:"N/A");
                    //$('td:eq(4)', nRow).html('<div class="btn-group"><a class="btn" href="'+SITEURL+'admin/states/setup/'+aData.State.id+'">Edit</a><a class="btn btn-white delete-confirm-alert" href="'+SITEURL+'admin/states/delete/'+aData.State.id+'" data-message = "You are permenantly deleting this state!">Delete</a></div>');
                },
                "fnDrawCallback": function () {
                    confirmMessageAlerts();
                }
            });
        });
    }


    /**
     * initAjaxDataTable
     * @returns void
     */
    function initSchoolAjaxDataTables() {
        $(".school-ajax-dataTable").each(function () {
            var ajaxUrl = $(this).attr("data-href");
            var orderColumn = ($(this).attr("data-order") != null && $(this).attr("data-order") != "undefined") ? $(this).attr("data-order") : "";
            if (orderColumn == "users") {
                var order = [[9, "desc"]];
            } else {
                var order = [[0, "desc"]];
            }
            $(this).DataTable({
                "dom": 'T<"clear">lfrtip',
                "oTableTools": {
                    "sSwfPath": SITEURL + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf",
                    "aButtons": [
                        {
                            "sExtends": "copy",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "csv",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "xls",
                            "sFileName": "*.xls",
                            "bFooter": false,
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "pdf",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4]
                        }
                    ]
                },
                "responsive": true,
                "iDisplayLength": 10,
                'bProcessing': true,
                'bServerSide': true,
                "order": [[0, "asc"]],
                "oLanguage": {
                    "oPaginate": {
                        "sNext": "<i class='fa fa-arrow-right custom-right'></i>",
                        "sPrevious": "<i class='fa fa-arrow-left custom-right'></i>"
                    }
                },
                'sAjaxSource': SITEURL + 'admin/institutes/index.json',
                "aoColumns": [
                    {mData: "Institute.name"},
                    {mData: "Institute.registration_no"},
                    {mData: "Institute.street_address"},
                    {mData: "Institute.city"},
                    {mData: "Institute.id"}
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                },
                "fnDrawCallback": function () {
                    confirmMessageAlerts();
                }
            });
        });
    }
    
    /**
     * initAjaxDataTable
     * @returns void
     */
    function initStudentAjaxDataTables() {
        $("#studentSearchFilterForm").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form) {
                $("#student-table-results").removeClass("table-none");
                $("#studentsResultsByFilters").dataTable().fnDestroy();
                //do something here
                $("#studentsResultsByFilters").DataTable({
                    "dom": 'T<"clear">lfrtip',
                    "oTableTools": {
                        "sSwfPath": SITEURL + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf",
                        "aButtons": [
                            {
                                "sExtends": "copy",
                                "mColumns": [0, 1, 2, 3, 4]
                            },
                            {
                                "sExtends": "csv",
                                "mColumns": [0, 1, 2, 3, 4]
                            },
                            {
                                "sExtends": "xls",
                                "sFileName": "*.xls",
                                "bFooter": false,
                                "mColumns": [0, 1, 2, 3, 4]
                            },
                            {
                                "sExtends": "pdf",
                                "mColumns": [0, 1, 2, 3, 4]
                            },
                            {
                                "sExtends": "print",
                                "mColumns": [0, 1, 2, 3, 4]
                            }
                        ]
                    },
                    "responsive": true,
                    "iDisplayLength": 10,
                    'bProcessing': true,
                    'bServerSide': true,
                    "order": [[0, "asc"]],
                    "oLanguage": {
                        "oPaginate": {
                            "sNext": "<i class='fa fa-arrow-right custom-right'></i>",
                            "sPrevious": "<i class='fa fa-arrow-left custom-right'></i>"
                        }
                    },
                    'sAjaxSource': SITEURL + 'students/resultsByFilters.json',
                    "fnServerParams": function (aoData) {
                        aoData.push({name: "Student", value: $('#studentSearchFilterForm').serialize()});
                    },
                    "aoColumns": [
                        {mData: "Student.name"},
                        {mData: "Student.admission_no"},
                        {mData: "ClassInfo.name"},
                        {mData: "Section.name"},
                        {mData: "Student.date_of_joining"},
                        {mData: "Student.id"}
                    ],
                    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    },
                    "fnDrawCallback": function () {
                        confirmMessageAlerts();
                    }
                });
                return false;
            }
        });


    }

    function initStudentResultsByFilters() {

    }

    /**
     * Init Data table
     * 
     */

    function initJqueryDataTable()
    {
        $(".jquery-dataTable").each(function () {
            var dataTable = $(this).DataTable({
                "dom": 'T<"clear">lfrtip',
                "oTableTools": {
                    "sSwfPath": SITEURL + "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf",
                    "aButtons": [
                        {
                            "sExtends": "copy",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "csv",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "xls",
                            "sFileName": "*.xls",
                            "bFooter": false,
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "pdf",
                            "mColumns": [0, 1, 2, 3, 4]
                        },
                        {
                            "sExtends": "print",
                            "mColumns": [0, 1, 2, 3, 4]
                        }
                    ]
                },
                "bInfo": false,
                "bLengthChange": false,
                "iDisplayLength": 10,
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='fa fa-angle-double-left'></i>",
                        "sLast": "<i class='fa fa-angle-double-right'></i>",
                        "sNext": "<i class='fa fa-angle-right'></i>",
                        "sPrevious": "<i class='fa fa-angle-left'></i>"
                    }
                },
                "fnDrawCallback": function () {
                    confirmMessageAlerts();
                }
            });
        });
    }

    /**
     * 
     * @returns {undefined}
     */
    function initImageAnimateHover() {
        $('.file-box').each(function () {
            animationHover(this, 'pulse');
        });
    }

    /**
     * Summerynote
     */
    function initSummernote()
    {
        $('.summernote').summernote();
        var edit = function () {
            $('.click2edit').summernote({focus: true});
        };
        var save = function () {
            var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
            $('.click2edit').destroy();
        };
    }


    /**
     * InitGalleryUpload
     * @returns {undefined}
     */
    function initGalleryUpload() {
        Dropzone.options.myAwesomeDropzone = {
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            // Dropzone settings
            init: function () {
                var myDropzone = this;

                this.element.querySelector("button[type=submit]").addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on("sendingmultiple", function () {
                });
                this.on("successmultiple", function (files, response) {
                    var jsonData = $.parseJSON(response);
                    swal({
                        title: "Success!",
                        text: jsonData.message,
                        type: "success"
                    },
                    function () {
                        window.location.href = SITEURL + jsonData.callback.controller + "/" + jsonData.callback.action + "/" + jsonData.callback.id;
                    });
                });
                this.on("errormultiple", function (files, response) {
                });
            }

        }
    }

    /**
     * InitSchoolWizardSteps
     * @returns {undefined}
     */
    function initSchoolWizardSteps() {
        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                if (currentIndex === 2 && priorIndex === 3)
                {
                    $(this).steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                var form = $(this);

                // Submit form input
                form.submit();
            }
        }).validate({
            errorPlacement: function (error, element)
            {
                element.before(error);
            }
        });
    }

    function initClassSectionMultiple() {
        var treeData = [
            {title: "item1 with key and tooltip", tooltip: "Look, a tool tip!"},
            {title: "item2: selected on init", select: true},
            {title: "Folder", isFolder: true, key: "id3",
                children: [
                    {title: "Sub-item 3.1",
                        children: [
                            {title: "Sub-item 3.1.1", key: "id3.1.1"},
                            {title: "Sub-item 3.1.2", key: "id3.1.2"}
                        ]
                    },
                    {title: "Sub-item 3.2",
                        children: [
                            {title: "Sub-item 3.2.1", key: "id3.2.1"},
                            {title: "Sub-item 3.2.2", key: "id3.2.2"}
                        ]
                    }
                ]
            },
            {title: "Document with some children (expanded on init)", key: "id4", expand: true,
                children: [
                    {title: "Sub-item 4.1 (active on init)", activate: true,
                        children: [
                            {title: "Sub-item 4.1.1", key: "id4.1.1"},
                            {title: "Sub-item 4.1.2", key: "id4.1.2"}
                        ]
                    },
                    {title: "Sub-item 4.2 (selected on init)", select: true,
                        children: [
                            {title: "Sub-item 4.2.1", key: "id4.2.1"},
                            {title: "Sub-item 4.2.2", key: "id4.2.2"}
                        ]
                    },
                    {title: "Sub-item 4.3 (hideCheckbox)", hideCheckbox: true},
                    {title: "Sub-item 4.4 (unselectable)", unselectable: true}
                ]
            }
        ];
        $('#tree').checktree();
        /*
         $("#tree2").dynatree({
         checkbox: true,
         selectMode: 2,
         children: treeData,
         onSelect: function(select, node) {
         // Display list of selected nodes
         var selNodes = node.tree.getSelectedNodes();
         // convert to title/key array
         var selKeys = $.map(selNodes, function(node){
         return "[" + node.data.key + "]: '" + node.data.title + "'";
         });
         $("#echoSelection2").text(selKeys.join(", "));
         },
         onClick: function(node, event) {
         // We should not toggle, if target was "checkbox", because this
         // would result in double-toggle (i.e. no toggle)
         if( node.getEventTargetType(event) == "title" )
         node.toggleSelect();
         },
         onKeydown: function(node, event) {
         if( event.which == 32 ) {
         node.toggleSelect();
         return false;
         }
         },
         // The following options are only required, if we have more than one tree on one page:
         cookieId: "dynatree-Cb2",
         idPrefix: "dynatree-Cb2-"
         });*/
    }

    function initInstituteTimings() {
        $(".institute_timings").each(function () {
            var val = this.value;
            if ($('#' + val + '_week').is(':checked') == true) {
                $('#' + val + '-opening_hours').attr('disabled', false);
                $('#' + val + '-closing_hours').attr('disabled', false);
            } else {
                $('#' + val + '-opening_hours').attr('disabled', true);
                $('#' + val + '-closing_hours').attr('disabled', true);
                $("select#" + val + "-opening_hours option[value='00:00']").attr("selected", "selected");
                $("select#" + val + "-closing_hours option[value='00:00']").attr("selected", "selected");
            }
        });


        $(".institute_timings").each(function () {
            $(this).on('ifChecked', function () {
                var val = this.value;
                $('#' + val + '-opening_hours').attr('disabled', false);
                $('#' + val + '-closing_hours').attr('disabled', false);
            });
            $(this).on('ifUnchecked', function () {
                var val = this.value;
                $('#' + val + '-opening_hours').attr('disabled', true);
                $('#' + val + '-closing_hours').attr('disabled', true);
                $("select#" + val + "-opening_hours option[value='00:00']").attr("selected", "selected");
                $("select#" + val + "-closing_hours option[value='00:00']").attr("selected", "selected");
            });
        });
    }

    function instituteChangingHours() {
        $(".ajax-changing-timings").each(function () {
            $(this).change(function () {
                var data = $(this).attr("id");
                data = data.split("-");
                var id = data[0];
                var selected_value = $(this).val();
                if (data[1] == "opening_hours") {
                    var toValue = $("#" + id + "-closing_hours").val();
                    if (toValue < selected_value) {
                        $("#" + id + "-closing_hours").val(selected_value);
                    }
                } else {
                    var fromValue = $("#" + id + "-opening_hours").val();
                    if (fromValue > selected_value) {
                        $("#" + id + "-opening_hours").val(selected_value);
                    }

                }
            });
        });
    }
}();