<html>
<head>
    <!-- <base href="https://demos.telerik.com/kendo-ui/pdf-export/page-layout">
    <style>html { font-size: 14px; font-family: Arial, Helvetica, sans-serif; } --></style>
    <title></title>
   <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.1.223/styles/kendo.common.min.css" />
<!--      <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.1.223/styles/kendo.black.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.1.223/styles/kendo.black.mobile.min.css" /> -->

    <script src="https://kendo.cdn.telerik.com/2017.1.223/js/jquery.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2017.1.223/js/jszip.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2017.1.223/js/kendo.all.min.js"></script>
</head>
<body>
<div id="example">
    <div class="box wide hidden-on-narrow">
        <div class="box-col">
            <h4>Select Page size</h4>
            <select id="paper" style="width: 100px;">
                <option value="size-a4" selected>A4</option>
                <option value="size-letter">Letter</option>
                <option value="size-executive">Executive</option>
            </select>
        </div>
        <div class="box-col">
            <h4>Get PDF</h4>
            <button class="export-pdf k-button" onclick="getPDF('.pdf-page')">Export</button>
        </div>
    </div>

    <div class="page-container hidden-on-narrow">
        <div class="pdf-page size-a4">
            <div class="pdf-header">
                <span class="company-logo">
                    <img src="../content/web/framework/company-logo.png" /> Blauer See Delikatessen
                </span>
                <span class="invoice-number">Invoice #23543</span>
            </div>
            <div class="pdf-footer">
                <p>Blauer See Delikatessen<br />
                    Lützowplatz 456<br />
                    Berlin, Germany,  10785
                </p>
            </div>
            <div class="for">
                <h3>Invoice For</h3>
                <p>Antonio Moreno<br />
                    Naucalpan de Juárez<br />
                    México D.F., Mexico, 53500
                </p>
            </div>

            <div class="from">
                <h3>From</h3>
                <p style="padding-bottom: 20px; border-bottom: 1px solid #e5e5e5;">Hanna Moos <br />
                    Lützowplatz 456<br />
                    Berlin, Germany,  10785
                </p>
                <p style="padding-top: 20px;">
                    Invoice ID: 23543<br />
                   Invoice Date: 12.03.2014<br />
                   Due Date: 27.03.2014
                </p>
            </div>
            <div class="pdf-body">
                <div id="grid"></div>
                <p class="signature">
                    Signature: ________________ <br /><br />
                    Date: 12.03.2014
                </p>
            </div>
        </div>
    </div>
    
    <div class="responsive-message"></div>

    <style>
        /*
            Use the DejaVu Sans font for display and embedding in the PDF file.
            The standard PDF fonts have no support for Unicode characters.
        */
        .pdf-page {
            font-family: "DejaVu Sans", "Arial", sans-serif;
        }
    </style>

    <script>
        // Import DejaVu Sans font for embedding

        // NOTE: Only required if the Kendo UI stylesheets are loaded
        // from a different origin, e.g. cdn.kendostatic.com
        kendo.pdf.defineFont({
            "DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
            "DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
            "DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
            "DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf"
        });
    </script>

    <!-- Load Pako ZLIB library to enable PDF compression -->
    <script src="../content/shared/js/pako.min.js"></script>

    <script>
      function getPDF(selector) {
        kendo.drawing.drawDOM($(selector)).then(function(group){
          kendo.drawing.pdf.saveAs(group, "Invoice.pdf");
        });
      }

    $(document).ready(function() {
        var data = [
          { productName: "QUESO CABRALES", unitPrice: 21, qty: 5 },
          { productName: "ALICE MUTTON", unitPrice: 39, qty: 7 },
          { productName: "GENEN SHOUYU", unitPrice: 15.50, qty: 3 },
          { productName: "CHARTREUSE VERTE", unitPrice: 18, qty: 1 },
          { productName: "MASCARPONE FABIOLI", unitPrice: 32, qty: 2 },
          { productName: "VALKOINEN SUKLAA", unitPrice: 16.25, qty: 3 }
        ];
        var schema = {
          model: {
            productName: { type: "string" },
            unitPrice: { type: "number", editable: false },
            qty: { type: "number" }
          },
          parse: function (data) {
                $.each(data, function(){
                    this.total = this.qty * this.unitPrice;
                });
                return data;
          }
        };
        var aggregate = [
          { field: "qty", aggregate: "sum" },
          { field: "total", aggregate: "sum" }
        ];
        var columns = [
          { field: "productName", title: "Product", footerTemplate: "Total"},
          { field: "unitPrice", title: "Price", width: 120},
          { field: "qty", title: "Pcs.", width: 120, aggregates: ["sum"], footerTemplate: "#=sum#" },
          { field: "total", title: "Total", width: 120, aggregates: ["sum"], footerTemplate: "#=sum#" }
        ];
        var grid = $("#grid").kendoGrid({
          editable: false,
          sortable: true,
          dataSource: {
            data: data,
            aggregate: aggregate,
            schema: schema,
          },
          columns: columns
        });

        $("#paper").kendoDropDownList({
          change: function() {
            $(".pdf-page")
              .removeClass("size-a4")
              .removeClass("size-letter")
              .removeClass("size-executive")
              .addClass(this.value());
          }
        });
    });
    </script>
    <style>
        .pdf-page {
            margin: 0 auto;
            box-sizing: border-box;
            box-shadow: 0 5px 10px 0 rgba(0,0,0,.3);
            background-color: #fff;
            color: #333;
            position: relative;
        }
        .pdf-header {
            position: absolute;
            top: .5in;
            height: .6in;
            left: .5in;
            right: .5in;
            border-bottom: 1px solid #e5e5e5;
        }
        .invoice-number {
            padding-top: .17in;
            float: right;
        }
        .pdf-footer {
            position: absolute;
            bottom: .5in;
            height: .6in;
            left: .5in;
            right: .5in;
            padding-top: 10px;
            border-top: 1px solid #e5e5e5;
            text-align: left;
            color: #787878;
            font-size: 12px;
        }
        .pdf-body {
            position: absolute;
            top: 3.7in;
            bottom: 1.2in;
            left: .5in;
            right: .5in;
        }

        .size-a4 { width: 8.3in; height: 11.7in; }
        .size-letter { width: 8.5in; height: 11in; }
        .size-executive { width: 7.25in; height: 10.5in; }

        .company-logo {
            font-size: 30px;
            font-weight: bold;
            color: #3aabf0;
        }
        .for {
            position: absolute;
            top: 1.5in;
            left: .5in;
            width: 2.5in;
        }
        .from {
            position: absolute;
            top: 1.5in;
            right: .5in;
            width: 2.5in;
        }
        .from p, .for p {
            color: #787878;
        }
        .signature {
            padding-top: .5in;
        }
    </style>

</div>


</body>
