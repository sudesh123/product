$(".custom-file-input").on("change", function() {
    let fileName = $(this).val().split("\\").pop();
    let label = $(this).siblings(".custom-file-label");

    if (label.data("default-title") === undefined) {
        label.data("default-title", label.html());
    }

    if (fileName === "") {
        label.removeClass("selected").html(label.data("default-title"));
    } else {
        label.addClass("selected").html(fileName);
    }
});
$("#addRecords").on("hide.bs.modal", function(e) {
    // do something...
    $("#addRecordForm")[0].reset();
    $(".custom-file-label").html("Product Images");
});
$("#editRecords").on("hide.bs.modal", function(e) {
    // do something...
    $("#editForm")[0].reset();
    $(".custom-file-label").html("Product Images");
});
var base_url = $("#base_url").val();
$(document).on("click", "#add", function(e) {
    e.preventDefault();

    var product_name = $("#product_name").val();
    var product_price = $("#product_price").val();
    var product_description = $("#product_description").val();
    var product_images = $("#product_images")[0].files[0];
   

    if (product_name == "" || product_price == "" || product_description == "" || product_images.name == "") {
        alert("All field are required");
    } else {
        var fd = new FormData();

        fd.append("product_name", product_name);
        fd.append("product_price", product_price);
        fd.append("product_description", product_description);
        fd.append("product_images", product_images);
        var ins = document.getElementById('product_image').files.length;
        for (var x = 0; x < ins; x++) {
            fd.append("product_image[]", document.getElementById('product_image').files[x]);
        }

        $.ajax({
            type: "post",
            url: base_url + "/insert",
            data: fd,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.res == "success") {
                    toastr["success"](response.message);
                    $("#addRecords").modal("hide");
                    $("#addRecordForm")[0].reset();
                    $(".add-file-label").html("Product Images");
                    $("#recordTable").DataTable().destroy();
                    fetch();
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }
});
function fetch() {
    $.ajax({
        type: "get",
        url: base_url + "fetch",
        dataType: "json",
        success: function(response) {
            var i = "1";
            $("#recordTable").DataTable({
                data: response,
                responsive: true,
                pageLength : 5,
                buttons: ["copy", "excel", "pdf", "csv", "print"],
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columns: [{
                        data: "id",
                        render: function(data, type, row, meta) {
                            return i++;
                        },
                    },
                    {
                        data: "product_name",
                    },
                    {
                        data: "product_price",
                    },
                    {
                        data: "product_description",
                    },
                    {
                        data: "product_image",
                        render: function(data, type, row, meta) {
                            var a = `
                                <img src="${base_url}/assets/uploads/${row.product_image}" width="50" height="50" />
                            `;
                            return a;
                        },
                    },
                    {
                        orderable: false,
                        searchable: false,
                        data: function(row, type, set) {
                            return `
                                <a href="#" id="del" class="btn btn-sm btn-outline-danger" value="${row.id}"><i class="fas fa-trash-alt"></i></a>
                                <a href="#" id="edit" class="btn btn-sm btn-outline-info" value="${row.id}"><i class="fas fa-edit"></i></a>
                            `;
                        },
                    },
                ],
            });
        },
    });
}
fetch();
$(document).on("click", "#del", function(e) {
    e.preventDefault();

    var del_id = $(this).attr("value");

    Swal.fire({
        title: "Are you sure?",
        text: "You wont to delete this product?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: base_url + "delete",
                data: {
                    del_id: del_id,
                },
                dataType: "json",
                success: function(response) {
                    if (response.res == "success") {
                        Swal.fire(
                            "Deleted!",
                            "Your product has been deleted.",
                            "success"
                        );
                        $("#recordTable").DataTable().destroy();
                        fetch();
                    }
                },
            });
        }
    });
});
$(document).on("click", "#edit", function(e) {
    e.preventDefault();

    var edit_id = $(this).attr("value");

    $.ajax({
        url: base_url + "edit",
        type: "get",
        dataType: "JSON",
        data: {
            edit_id: edit_id,
        },
        success: function(data) {
            if (data.res === "success") {
                $("#editRecords").modal("show");
                $("#edit_record_id").val(data.post.id);
                $("#edit_product_name").val(data.post.product_name);
                $("#edit_product_price").val(data.post.product_price);
                $("#edit_product_description").val(data.post.product_description);
                $("#show_img").html(`
                    <img src="${base_url}assets/uploads/${data.post.product_image}" width="150" height="150" class="rounded img-thumbnail">
                `);
            } else {
                toastr["error"](data.message, "Error");
            }
        },
    });
});
$(document).on("click", "#update", function(e) {
    e.preventDefault();

    var edit_id = $("#edit_record_id").val();
    var edit_product_name = $("#edit_product_name").val();
    var edit_product_price = $("#edit_product_price").val();
    var edit_product_description = $("#edit_product_description").val();
    var edit_product_images = $("#edit_product_images")[0].files[0];

    if (edit_product_name == "" || edit_product_price == "" || edit_product_description == "") {
        alert("All field are required");
    } else {
        var fd = new FormData();

        fd.append("edit_id", edit_id);
        fd.append("edit_product_name", edit_product_name);
        fd.append("edit_product_price", edit_product_price);
        fd.append("edit_product_description", edit_product_description);
        if ($("#edit_product_images")[0].files.length > 0) {
            fd.append("edit_product_images", edit_product_images);
        }
        var ins = document.getElementById('edit_product_image').files.length;
        for (var x = 0; x < ins; x++) {
            fd.append("product_image[]", document.getElementById('edit_product_image').files[x]);
        }

        $.ajax({
            type: "post",
            url: base_url + "update",
            data: fd,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.res == "success") {
                    toastr["success"](response.message);
                    $("#editRecords").modal("hide");
                    $("#editForm")[0].reset();
                    $(".edit-file-label").html("Product Images");
                    $("#recordTable").DataTable().destroy();
                    fetch();
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }
});