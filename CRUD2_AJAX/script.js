const tbody = $("#product_body").html();

const api_url = "http://php_pr.test/CRUD2_AJAX/api/"


function fetchdata() {
    $.ajax({
        url: api_url + "/view.php",
        method: "Get",
        success: function (res) {
            let response = JSON.parse(res);
            // console.log(response);


            if (response.status == 200) {
                let innerHtml = '';
                // console.log(response);

                response.data.forEach(product => {
                    innerHtml += `<tr id="product_${product.p_id}">
						<td><img  src="./uploads/thumbnails/${product.p_thumbnail || ""}" width="50" /></td>
						<td>${product.categoryName || ""}</td>
						<td>${product.subcategoryName || ""}</td>
						<td>${product.p_name}</td>
						<td>${product.qty}</td>
						<td>${product.p_description || ""}</td>
						<td>${product.p_price}</td>
						<td>${product.s_price}</td>
						<td>${product.tax}</td>
						<td><span class="badge bg-primary">${product.is_active == 1 ? "Active" : "Inactive"}</span></td>
						<td>
                            <button class="btn btn-info btn-sm"  onclick="editdata(${product.p_id});">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
					</tr>
                    `;
                });

                $("#product_body").html(innerHtml);

            };
        }
    });

};

fetchdata();

function fetchcategory(category_id = "") {
    $.ajax({
        url: api_url + "/fetch-modal.php",
        method: "GET",
        data: { "c": "fetchCategory" },
        success: function (res) {
            let response = JSON.parse(res);
            // console.log(response);
            // console.log("calling fetchcategories==>",category_id);
            if (response.status == 200) {
                let html = '<option value="">Select Category</option>';
                response.data.forEach(category => {
                    let selected = category_id == category.c_id ? "selected" : "";
                    html += `
                        <option value="${category.c_id}" ${selected}>${category.c_name}</option>
                    `;
                });

                // console.log(html);

                $("#productCats").html(html);

            }
        }
    })
}





function fetchSubcategories(category_id, subcategory_id = "") {
    $.ajax({
        url: api_url + "/fetch-modal.php",
        method: "GET",
        data: {
            "c": "fetchSubcat",
            "category_id": category_id
        },
        success: function (res) {
            let response = JSON.parse(res);
            // console.log(response);
            if (response.status == 200) {
                let html = '<option value="">Select Subcategory</option>';
                response.data.forEach(subcat => {
                    // console.log(subcat);

                    let selected = (subcat.c_id == subcategory_id) ? "selected" : "";
                    html += `
                        <option value="${subcat.c_id}" ${selected}>${subcat.c_name}</option>
                    `;
                });
                $("#productSubcats").html(html);
            }
        }
    });
}





$("#productCats").on("change", function () {
    let category_id = $(this).val();
    // console.log(category_id);
    fetchSubcategories(category_id);

});


$("#p_submit").on("click", function (e) {
    e.preventDefault();

    let form = document.querySelector("#product_form");
    let formData = new FormData(form);
    // console.log(formData);

    $.ajax({
        url: api_url + "/add.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            let response = JSON.parse(res);
            if (response.status == 200) {
                $("#product_form")[0].reset();
                $("#productModal").modal("hide");
                fetchdata();

            }
        }
    });
});


function editdata(Id) {
    if (Id) {
        $.ajax({
            url: api_url + "/fetch-modal.php",
            method: "GET",
            data: { "c": "fetchdata", "product_id": Id },
            success: function (res) {
                let response = JSON.parse(res);
                let product = response.data;
                // console.log(product);

                if (response.status == 200) {

                    $("#productModal").modal("show");
                    $("#productModal").modal("show");
                    $("#productModalLabel").text("Update Product");

                    $("#preview_box").html('');

                    $("#product_id").val(product.p_id);
                    $("#p_submit").text("Update");

                    fetchcategory(product.category_id);


                    fetchSubcategories(product.category_id, product.subcategory_id);

                    $("#editIndex").val(product.p_id);
                    $("#product_name").val(product.p_name);
                    $("#qty").val(product.qty);
                    $("#p_description").val(product.p_description);
                    $("#p_price").val(product.p_price);
                    $("#s_price").val(product.s_price);
                    $("#tax").val(product.tax);

                    $('input[name="is_active"][value="' + product.is_active + '"]').prop("checked", true);

                    if (product.p_thumbnail) {
                        $("#preview_box").html(`
                            <div>
                                <img src="./uploads/thumbnails/${product.p_thumbnail}" 
                                     width="80" 
                                     style="border:1px solid #ddd;">
                            </div>
                        `);
                    }
                }
            }
        });
    }
}




$('#productModal').on('hidden.bs.modal', function () {
    $("#product_form")[0].reset();
    $("#preview_box").html('');
    $("#p_thumbnail").val('');

    $("#productCats").val("");
    $("#p_submit").text("Submit");
    $("#productSubcats").html('');
    $("#productModalLabel").text("Add Product");
});