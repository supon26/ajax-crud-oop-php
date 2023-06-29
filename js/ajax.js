$(document).ready(function(){

    // Employee added
    $('#add_emp').click(function(){
        var name    = $('#emp_name').val();
        var email   = $('#emp_email').val();
        var phone   = $('#emp_phone').val();
        var status  = $('#emp_status').val();

        // AJAX start
        $.ajax({
            url  : "classes/Process.php",
            type : "POST",
            data :{
                emp_name   : name,
                emp_email  : email,
                emp_phone  : phone,
                emp_status : status,
                action     : "insert"
            },
            success : function(response){
                $('.msg').html(`<div class="alert alert-success text-center" role="alert">${response}</div>`);
                $('.msg').fadeOut(2000);

                $('#emp_name').val("");
                $('#emp_email').val("");
                $('#emp_phone').val("");
                $('#emp_status').val("");
                show();
            }
        })

    })

    // Show Employee
    show()
    function show(){
        $.ajax({
            url     : "classes/Process.php",
            type    : "POST",
            data    :{
                action : "show"
            },
            success :function(response){
                // alert(response);
                $('.tbody').html(response);
            }
        });
    }

    // Delete Employee
    $(document).on("click","#deleteBtn",function(){
        var id = $(this).val();
        $("#yesDelete").val(id);
    });

    $(document).on("click","#yesDelete",function(){
        var id = $(this).val();
        $.ajax({
            url     : "classes/Process.php",
            type    : "POST",
            data    :{
                id     : id,
                action : "destroy"
            },
            success :function(response){
                show();
                $("#deleteModal").modal("hide");
            }
        });
    });
    // Active to Inactive
    $(document).on("click","#activeBtn",function(){
        var id = $(this).val();
        $.ajax({
            url     : "classes/Process.php",
            type    : "POST",
            data    :{
                id     : id,
                action : "active_to_inactive"
            },
            success :function(response){
                show();
            }
        });
    });

    // Inactive to Active
    $(document).on("click","#inactiveBtn",function(){
        var id = $(this).val();
        $.ajax({
            url     : "classes/Process.php",
            type    : "POST",
            data    :{
                id     : id,
                action : "inactive_to_active"
            },
            success :function(response){
                show();
            }
        });
    });

    // Edit Employee
    $(document).on("click","#editBtn",function(){
        var id  =  $(this).val();
        $("#yesUpdate").val(id);
        $.ajax({
            url     : "classes/Process.php",
            type    : "POST",
            data    :{
                id     : id,
                action : "edit"
            },
            dataType: "JSON",
            success :function(response){
                $("#uemp_name").val(response.emp_name);
                $("#uemp_email").val(response.emp_email);
                $("#uemp_phone").val(response.emp_phone);
            }
        });
    });

    // Update Employee
    $(document).on("click","#yesUpdate",function(){
        var id = $(this).val();
        var upd_name  = $("#uemp_name").val();
        var upd_email = $("#uemp_email").val();
        var upd_phone = $("#uemp_phone").val();

        $.ajax({
            url     : "classes/Process.php",
            type    : "POST",
            data    :{
                id       : id,
                updName  : upd_name,
                updEmail : upd_email,
                updPhone : upd_phone,
                action : "update"
            },
            success :function(response){
                show();
                $("#editModal").modal("hide");
                $(".msg").html(response);
            }
        });
    });




});