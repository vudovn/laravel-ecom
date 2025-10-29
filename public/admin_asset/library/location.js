(function ($) {
    "use strict";
    var ADU = {};

    ADU.getWards = () => {
        $(document).on("change", ".select_province", function () {
            let _this = $(this);
            $.ajax({
                url: "/api/wards",
                type: "GET",
                data: {
                    province_id: _this.val(),
                },
                success: function (response) {
                    if (response.status) {
                        // làm 1  cục select
                        let html = "";
                        response.data.forEach((element) => {
                            html += `<option value="${element.id}">${element.name}</option>`;
                        });
                        // thêm cục đó vào select_ward
                        $(".select_ward").append(html);
                        $(".select_ward").removeAttr("disabled");
                    }
                },
            });
        });
    };

    $(document).ready(function () {
        ADU.getWards();
    });
})(jQuery);
