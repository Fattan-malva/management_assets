<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VeLaris')</title>

    <link rel="icon" href="{{ asset('assets/img/assetslogo.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Additional CSS -->
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
        }

        .form-group input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .dataTables_wrapper .dataTables_length select {
            display: inline-block;
            width: auto;
            height: 30px;
            padding: 0 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 0.875rem;
            line-height: 1.5;
            color: #495057;
        }

        div.dataTables_wrapper div.dataTables_filter {
            text-align: right;
            margin-bottom: 20px;
            margin-right: 20px;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            margin-left: .2em;
            padding: 12px 20px 12px 50px;
            width: 100%;
            border-radius: 50px;
            font-size: 16px;
            background: url('https://cdn-icons-png.flaticon.com/512/149/149852.png') no-repeat 20px center;
            background-size: 20px;
            border: 1px solid #ced4da;
            transition: border 0.2s ease;
        }

        div.dataTables_wrapper div.dataTables_filter input:focus {
            outline: none;
            box-shadow: none !important;
            /* Hapus shadow biru */
            border: 1px solid #999;
            /* Opsi tambahan jika Anda ingin menambahkan border fokus yang lebih halus */
        }

        div.dataTables_wrapper div.dataTables_filter input {
            margin-left: .2em;
            padding: 12px 20px 12px 50px;
            width: 100%;
            border-radius: 50px;
            font-size: 16px;
            background: url('https://cdn-icons-png.flaticon.com/512/149/149852.png') no-repeat 20px center;
            background-size: 20px;
            border: 1px solid #ced4da;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        .dataTables_wrapper .dataTables_length {
            display: flex;
            align-items: center;
            float: right;
            margin-right: 40px;
            margin-top: 10px;
        }

        .dataTables_filter input::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
        }

        .dataTables_length select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: transparent;
            border: none;
            font-size: 14px;
        }

        .dataTables_length select:focus {
            outline: none;
        }

        /* TABLE HOVER ROW */
        .table-hover tbody tr td,
        .table-hover thead tr th {
            border-bottom: 1px solid #ebedf2;
            /* Add a border to the bottom of each row */
            background-color: #fff;
        }

        .table-hover tbody tr td {
            font-weight: 300;
        }

        .table-hover thead tr th {
            font-weight: 600;
        }

        /* Remove any cell borders */
        .table-hover th,
        .table-hover td {
            border: none;
            /* Remove borders from cells */
            padding: 10px;
            /* Keep padding for cells */
        }

        /* Spacing around the colon in legends */
        .legend-colon {
            margin: 0 5px;
            /* Space around the colon */
        }

        /* Hide colon on mobile devices */
        @media (max-width: 576px) {
            .legend-colon {
                display: none;
                /* Hide colon */
            }
        }
    </style>

</head>

<body>
    
    @php
        $userRole = session('user_role');
    @endphp

    @yield('content')

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function () {
            // Initialize DataTables
            $('.table-responsive').each(function () {
                $(this).find('table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: false,
                    info: true,
                    lengthChange: true,
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, -1],  // Options: 10, 25, 50, Show All (-1)
                        [10, 25, 50, "All"]  // Display text for the options
                    ],
                    language: {
                        search: "",
                        searchPlaceholder: "Search...",
                        lengthMenu: "_MENU_",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries available",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        paginate: {
                            previous: "Prev",  // Customize previous button text
                            next: "Next"       // Customize next button text
                        }
                    },
                    dom: '<"top"f>rt<"bottom"lp><"clear">', // Search on top, paginate on bottom
                    createdRow: function (row, data, dataIndex) {
                        // Apply 'text-center' and 'align-middle' class to every cell in the row
                        $(row).find('td').addClass('text-center align-middle');
                    },
                    initComplete: function () {
                        // Apply 'text-center' and 'align-middle' class to the header columns
                        $(this).closest('.table').find('th').addClass('text-center align-middle');
                    }
                });
            });

            // Initialize Select2
            $('#asset_tagging').select2({
                placeholder: "Select asset tagging",
                allowClear: true
            }).on('change', function () {
                updateSelectedAssets();
            });

            function updateSelectedAssets() {
                var selectedOptions = $('#asset_tagging').val();
                $('#selected-assets-list').empty();

                if (selectedOptions) {
                    selectedOptions.forEach(function (option) {
                        var optionText = $('#asset_tagging option[value="' + option + '"]').text();
                        addAssetToList(option, optionText);
                    });
                }
            }

            function addAssetToList(assetId, assetText) {
                if ($('#selected-assets-list').find(`li[data-id="${assetId}"]`).length === 0) {
                    $('#selected-assets-list').append(`<li class="list-group-item" data-id="${assetId}">${assetText}</li>`);
                }
            }

            // Double-click to remove item from list
            $('#selected-assets-list').on('dblclick', 'li', function () {
                var assetId = $(this).data('id');
                var selectElement = $('#asset_tagging');

                var currentValues = selectElement.val();
                currentValues = currentValues.filter(function (value) {
                    return value !== assetId.toString();
                });
                selectElement.val(currentValues).trigger('change');
                $(this).remove();
            });
            $(document).ready(function () {
                $('#tagging').select2({
                    placeholder: 'Select assets to scrap',
                    allowClear: true
                });
            });
        });
        // BACK ICON LOGIC
        document.getElementById('back-icon').addEventListener('click', function () {
            window.history.back();
        });


    </script>
    @if(isset($assetData) && isset($locationData))
        <script>
            // Fetch and format asset and location data
            const assetLabels = @json($assetData->pluck('jenis_aset'));
            const assetCounts = @json($assetData->pluck('total'));

            const locationLabels = @json($locationData->pluck('lokasi'));
            const locationCounts = @json($locationData->pluck('total'));

            // Function to format labels by truncating text at the first comma
            function formatLabels(labels) {
                return labels.map(label => {
                    const commaIndex = label.indexOf(',');
                    return commaIndex !== -1 ? label.substring(0, commaIndex) : label;
                });
            }

            // Format labels for the legend
            const formattedLocationLabels = formatLabels(locationLabels);

            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false, // This ensures that the chart will adjust its size on mobile
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom', // Position legend at the bottom
                        labels: {
                            boxWidth: 20,
                            padding: 15,
                            font: {
                                size: 14
                            },
                            // Custom CSS class for legend
                            usePointStyle: true,
                            pointStyle: 'rectRounded'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        display: true,
                        formatter: function (value) {
                            return value;
                        },
                        anchor: 'center',
                        align: 'center',
                        offset: 0
                    }
                }
            };

            // Initialize asset pie chart
            const ctxAsset = document.getElementById('assetPieChart').getContext('2d');
            new Chart(ctxAsset, {
                type: 'doughnut',
                data: {
                    labels: assetLabels,
                    datasets: [{
                        data: assetCounts,
                        backgroundColor: ['#b66dff', '#ffdc3b', '#1bcfb4', '#4BC0C0', '#9966FF'],
                    }]
                },
                options: {
                    cutout: '60%', // Tentukan ukuran lubang di tengah
                    ...commonOptions  // Tambahkan opsi dari variabel commonOptions
                }
            });

            // Initialize location pie chart with formatted labels
            const ctxLocation = document.getElementById('locationPieChart').getContext('2d');
            new Chart(ctxLocation, {
                type: 'pie',
                data: {
                    labels: formattedLocationLabels, // Use formatted labels
                    datasets: [{
                        data: locationCounts,
                        backgroundColor: ['#b66dff', '#ffdc3b', '#1bcfb4', '#4BC0C0', '#9966FF'],
                    }]
                },
                options: commonOptions
            });
        </script>

        <style>
            /* Custom styles for legend */
            .chart-container {
                position: relative;
            }

            .chart-container .chart-legend {
                display: flex;
                flex-direction: column;
                /* Arrange items in a column */
                align-items: center;
                /* Center items horizontally */
                margin-top: 40px;
                /* Increased space between chart and legend */
                /* Space between chart and legend */
            }

            .chart-container .chart-legend ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .chart-container .chart-legend li {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                /* Space between legend items */
            }

            .chart-container .chart-legend li span {
                display: inline-block;
                width: 20px;
                height: 20px;
                margin-right: 10px;
                border-radius: 4px;
                /* Rounded corners for color boxes */
            }

            .card {
                border: 1px solid #dee2e6;
                /* Border color */
            }

            .card-title {
                font-weight: bold;
                margin-bottom: 30px;
            }

            @media (max-width: 768px) {
                .assettotal-padding {
                    padding-top: 25px !important;
                }
            }
        </style>

    @endif
</body>

</html>