function getPDF(selector) {
    kendo.drawing.drawDOM($(selector)).then(function (group) {
        kendo.drawing.pdf.saveAs(group, "Invoice.pdf");
    });
}

$(document).ready(function () {
    $("#paper").kendoDropDownList({
        change: function () {
            $(".pdf-page")
                .removeClass("size-a4")
                .removeClass("size-letter")
                .removeClass("size-executive")
                .addClass(this.value());
        },
    });
});