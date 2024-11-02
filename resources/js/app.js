import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import jQuery from 'jquery';
window.$ = jQuery;

import Chart from 'chart.js/auto';
window.Chart = Chart;

import Swal from 'sweetalert2';
window.Swal = Swal;

// import 'laravel-datatables-vite'; // SIKA JY HAN NGA AGPAGAN GANA TI BOOTSTRAP JS >:(
// import DataTable from 'datatables.net-dt';
// import 'datatables.net-searchbuilder-dt';
// import 'datatables.net-buttons-dt';

import jszip from 'jszip';
window.jszip = jszip;
import pdfmake from 'pdfmake';
// import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfmake.fonts = {
  Roboto: {
      normal:
        "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Regular.ttf",
      bold: "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Medium.ttf",
      italics:
        "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Italic.ttf",
      bolditalics:
        "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-MediumItalic.ttf",
    },
};
window.pdfmake = pdfmake;

import DataTable from 'datatables.net-bs5';
// import 'datatables.net-buttons';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-searchbuilder-bs5';
import 'datatables.net-fixedcolumns-bs5';
import 'datatables.net-select-bs5';
window.DataTable = DataTable;

