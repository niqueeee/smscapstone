$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = "/admin/school";
    var id = '';
    var url2 = "/admin/school/checkbox";
    var table = $('#school-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: dataurl,
        "columnDefs": [
        { "width": "130px", "targets": 4 },
        { "width": "70px", "targets": 3 }
        ],
        columns: [
        { data: 'abbreviation', name: 'schools.abbreviation' },
        { data: 'description', name: 'schools.description' },
        { data: 'academic_gradings_description', name: 'gradings.description' },
        { data: 'is_active', name: 'schools.is_active', searchable: false },
        { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
    $('#add_school').on('hide.bs.modal', function() {
        $('#frmSchool').parsley().destroy();
        $('#frmSchool').trigger("reset");
    });
    $('#school-list').on('change', '#isActive', function() {
        var link_id = $(this).val();
        var is_active = 0;
        if ($(this).prop('checked')) {
            var is_active = 1;
        }
        var formData = {
            is_active: is_active
        }
        $.ajax({
            url: url2 + '/' + link_id,
            type: "PUT",
            data: formData,
            success: function(data) {
                Pace.restart();
                if (data == "Deleted") {
                    refresh();
                }
            },
            error: function(data) {
            }
        });
    });

    function refresh() {
        swal({
            title: "Record Deleted!",
            type: "warning",
            text: "<center>Refresh Records?</center>",
            html: true,
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Refresh",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,
            allowOutsideClick: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                table.draw();
            }
        });
    }
    //display modal form for task editing
    $('#school-list').on('click', '.open-modal', function() {
        var link_id = $(this).val();
        id = link_id;
        $.get(url + '/' + link_id + '/edit', function(data) {
            if (data == "Deleted") {
                refresh();
            } else {
                var textToFind = data.academic_gradings_description;
                var dd = document.getElementById('intSystID');
                for (var i = 0; i < dd.options.length; i++) {
                    if (dd.options[i].text === textToFind) {
                        dd.selectedIndex = i;
                        break;
                    }
                }
                $('h4').text('Edit School');
                $('#abbreviation').val(data.abbreviation);
                $('#strSchoDesc').val(data.description);
                $('#btn-save').val("update");
                $('#add_school').modal('show');
            }
        })
    });
    //display modal form for creating new task
    $('#btn-add').click(function() {
        $('h4').text('Add School');
        $('#btn-save').val("add");
        $('#frmSchool').trigger("reset");
        $('#add_school').modal('show');
    });
    //delete task and remove it from list
    $('#school-list').on('click', '.btn-delete', function() {
        var link_id = $(this).val();
        swal({
            title: "Are you sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            allowOutsideClick: true,
            showLoaderOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm) {
            setTimeout(function() {
                if (isConfirm) {
                    $.ajax({
                        url: url + '/' + link_id,
                        type: "DELETE",
                        success: function(data) {
                            if (data == "Deleted") {
                                refresh();
                            } else {
                                if (data[0] == "true") {
                                    swal({
                                        title: "Failed!",
                                        text: "<center>Data in use</center>",
                                        type: "error",
                                        showConfirmButton: false,
                                        allowOutsideClick: true,
                                        html: true
                                    });
                                } else {
                                    table.draw();
                                    swal({
                                        title: "Deleted!",
                                        text: "<center>Data Deleted</center>",
                                        type: "success",
                                        timer: 1000,
                                        showConfirmButton: false,
                                        html: true
                                    });
                                }
                            }
                        },
                        error: function(data) {
                        }
                    });
                }
            }, 500);
        });
    });
    //create new task / update existing task
    $("#btn-save").click(function() {
        $('#frmSchool').parsley().destroy();
        if ($('#frmSchool').parsley().isValid()) {
            $("#btn-save").attr('disabled', 'disabled');
            setTimeout(function() {
                $("#btn-save").removeAttr('disabled');
            }, 1000);
            var formData = {
                intSystID: $('#intSystID').val(),
                strSchoDesc: $('#strSchoDesc').parsley('data-parsley-whitespace', 'squish').getValue(),
                abbreviation: $('#abbreviation').parsley('data-parsley-whitespace', 'squish').getValue()
            }
                //used to determine the http verb to use [add=POST], [update=PUT]
                var state = $('#btn-save').val();
            var type = "POST"; //for creating new resource
            var my_url = url;
            if (state == "update") {
                type = "PUT"; //for updating existing resource
                my_url += '/' + id;
            }
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    $('#add_school').modal('hide');
                    table.draw();
                    swal({
                        title: "Success!",
                        text: "<center>Data Stored</center>",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false,
                        html: true
                    });
                },
                error: function(data) {
                    $.notify({
                        icon: 'fa fa-warning',
                        message: data.responseText.replace(/['"]+/g, '')
                    }, {
                        type: 'warning',
                        z_index: 2000,
                        delay: 5000,
                    });
                }
            });
        }
    });
});
