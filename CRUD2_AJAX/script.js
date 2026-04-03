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
                response.data.forEach(product => {
                    innerHtml += `<tr id="product_${product.p_id}">
						<td>Image</td>
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
                            <button class="btn btn-info btn-sm">Edit</button>
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

function fetchcategory() {
    $.ajax({
        url: api_url + "/fetch-modal.php",
        method: "GET",
        data: { "c": "fetchCategory" },
        success: function (res) {
            let response = JSON.parse(res);
            // console.log(response);
            if (response.status == 200) {
                let html = '<option value="">Select Category</option>';
                response.data.forEach(category => {
                    html += `
                        <option value="${category.c_id}">${category.c_name}</option>
                    `;
                });

                console.log(html);

                $("#productCats").html(html);
            }
        }
    })
}


$('#productModal').on('shown.bs.modal', function () {
    fetchcategory();
});


function fetchSubcategories(category_id) {
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
                    html += `
                        <option value="${subcat.c_id}">${subcat.c_name}</option>
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

    if (category_id) {
        fetchSubcategories(category_id);
    } else {
        $("#productSubcats").html('<option value="">Select Subcategory</option>');
    }
});


$("#p_submit").on("click", function (e) {
    e.preventDefault();

    let form = document.querySelector("#product_form");
    let formData = new FormData(form);
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