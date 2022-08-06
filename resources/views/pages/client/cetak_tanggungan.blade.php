<?php

use App\Traits\Helper;
use App\Models\Administrasi\HTransaksi;

?>
<html>

<head>
    <title>Menampilkan List Printer</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

</head>
<style type="text/css">
    @font-face {

        src : url('{{ asset("assets/font/monaco.ttf") }}');
        font-family: 'bankr';
    }

    .content {
        width: 70%;
        margin: auto;
        padding: 2rem;
        line-height: 0.2rem;
        overflow: hidden;
        border-top: none;
        border-right: none;
        border-left: none;

    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom:20px;
    }

    .header img {
        width: 40%;
    }

    .bag1 {
        text-align: center;
        width: 15%;
    }

    .bag2 {
        width: 50%;
    }

    .bag3 {
        width: 35%;
    }

    .bag3 p {
        font-size: 8pt;
        font-family: "bankr";
    }

    .bank-r {
        font-family: bankr;
    }

    .bag2>label {
        font-size: 10pt;
    }

    table {
        font-size: 12pt;
        width: 100%;
        font-family: 'bankr';

    }

    hr {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .terbilang {

        width: 100%;
        font-family: bankr;
        line-height: 1.5rem;
        display: flex;
        align-items: center;
        font-size: 8pt;

    }

    .terbilang-bag1 {
        width: 50%;
        /* background-image: url("{{url('public/assets/img/bg-pattern.png')}}"); */
    }

    .terbilang-bag2 {
        width: 50%;
        text-align: right;
    }

    .terbilang-bag1 .pattern {
        background-image: url('{{  asset("public/assets/img/pattern_line.jpg")  }}');
        background-size: 100px;
        padding: 10px;
    }

    .footer {
        font-size: 8pt;
        font-family: bankr;
        line-height: 1.5rem;
    }

    .ttd {
        width: 100%;
    }

    .ttd1 {
        width: 30%;
        float: right;
        text-align: center;
    }

    .print {
        position: fixed;
        bottom: 0;
        right: 0;
    }

    button {
        background: #084479;
        border: none;
        border-radius: 0.1rem;
        color: white;
        font-weight: bold;
        padding: 0.5rem 1rem 0.5rem 1rem;
        margin: 2rem;
        cursor: pointer;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            /*Chrome, Safari */
            color-adjust: exact !important;
            /*Firefox*/
        }

        .content {
            width: 100%;
            padding: 0;
            padding-bottom: 10px !important;
        }

        .print {
            display: none;
        }

        @page {
            padding: 1rem;
            margin: 1rem;


        }

        @page {
            size: auto;
        }
    }
</style>

<body>
    
    <div class="content">
        <div class="header">
            <div class="bag1">
                <img src="{{ asset('assets/img/logo_sekolah.png') }}">
            </div>
            <div class="bag2 bank-r">
                <h3>SMA ISLAM AL-HIKMAH</h3>
                <label><small>Jl. Raya Tanjungsari Kuwolu Bululawang Malang Jawa Timur</small></label>
            </div>
            <div class="bag3">
                <h5 class="bank-r" style="margin-bottom: 0rem;">BIAYA ADMINISTRASI SISWA</h5>
            </div>
        </div>
        <hr>
        <div class="body">
            <table style="margin-top: 20px">
                <tr>
                    <td colspan="2" style="font-weight: bold; padding-bottom:20px;">Tahun Ajaran : 2021 - 2022</td>
                </tr>
                <tr>
                    <td>SPP</td>
                    <td style="text-align: right">30.000</td>
                </tr>
            </table>

        </div>

    </div>
    <script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/core/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/plugins/autoNumeric.js')}}"></script>
</body>


</html>