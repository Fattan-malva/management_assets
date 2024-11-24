@extends('layouts.app')
@section('title', 'Assets List')

@section('content')
<br>


<div class="container">
    <div>
        <div class="container">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                // Menampilkan pesan sukses setelah redirect dari controller
                @if (session('success'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end', // Posisi toast (bisa diubah sesuai kebutuhan)
                        icon: 'success', // Ikon sukses
                        title: '{{ session('success') }}', // Pesan sukses dari session
                        showConfirmButton: false, // Tidak ada tombol OK
                        timer: 3000, // Durasi tampil (dalam milidetik)
                        timerProgressBar: true // Menampilkan progress bar
                    });
                @endif

                // Menampilkan pesan error validasi
                @if ($errors->any())
                    Swal.fire({
                        title: 'Error!',
                        text: '{!! implode(', ', $errors->all()) !!}', // Menggabungkan semua pesan error
                        icon: 'error', // Ikon error
                        confirmButtonText: 'OK' // Tombol OK
                    });
                @endif
            </script>
            <div class="header-container">
                <div class="back-wrapper">
                    <i class='bx bxs-chevron-left back-icon' id="back-icon"></i>
                    <div class="back-text">
                        <span class="title">Back</span>
                        <span class="small-text">to previous page</span>
                    </div>
                </div>
                <h3 class="assetList-title">
                    Asset List&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-list-ul previous-icon"></i>
                    </span>
                </h3>
            </div>
            <div class="header-container-mobile">
                <h3 class="assetList-title">
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-list-ul previous-icon"></i>
                    </span>
                    &nbsp;&nbsp;Asset List
                </h3>
            </div>
            <br>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="d-flex">
                <button id="generateQRCodeButton" class="btn btn-secondary" style="display: none;">
                    <i class="fa-solid fa-qrcode fa-lg"></i> QR-Code
                </button>
                <button id="exportToExcelButton" class="btn btn-success" style="display: none;">
                    <i class="fa-solid fa-file-excel fa-lg"></i> Export to Excel
                </button>
            </div>
            <div class="table-responsives">
                <table id="assetTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 50px;">No.</th>
                            <th scope="col" style="width: 150px;">Asset Code</th>
                            <th scope="col">S/N</th>
                            <th scope="col" style="width: 100px;">Location</th>
                            <th scope="col" style="width: 130px;">Name Holder</th>
                            <th scope="col" style="width: 130px;">Value (Rp)</th>
                            <th scope="col" style="width: 130px;">Maintenance</th>
                            <th scope="col" style="width: 100px;">Status</th>
                            <th scope="col" style="width: 50px;" class="non-sortable">
                                <input type="checkbox" id="selectAllCheckbox">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assetss as $index => $asset)
                            <tr>
                                <td data-bs-toggle="modal" title="Click to view details" data-bs-target="#detailsModal-{{ $asset->id }}"
                                style="cursor: pointer;">{{ $index + 1 }}</td>
                                <td data-bs-toggle="modal" title="Click to view details" data-bs-target="#detailsModal-{{ $asset->id }}"
                                style="cursor: pointer;">{{ $asset->code }}</td>
                                <td data-bs-toggle="modal" title="Click to view details" data-bs-target="#detailsModal-{{ $asset->id }}"
                                style="cursor: pointer;">{{ $asset->serial_number }}</td>

                                <td data-bs-toggle="modal" title="Click to view details" data-bs-target="#detailsModal-{{ $asset->id }}"
                                style="cursor: pointer;">
                                    @php
                                        $location = $asset->location ?? 'In Inventory';
                                        if ($location !== 'In Inventory') {
                                            $location = strtok($location, ',');
                                        }
                                    @endphp
                                    {{ $location }}
                                </td>
                                <td data-bs-toggle="modal" title="Click to view details" data-bs-target="#detailsModal-{{ $asset->id }}"
                                style="cursor: pointer;">{{ $asset->customer_name ?? 'Not Yet Handover' }}</td>
                                <td data-bs-toggle="modal" title="Click to view details" data-bs-target="#detailsModal-{{ $asset->id }}"
                                style="cursor: pointer;">{{ number_format($asset->depreciation_price, 0, ',', '.') }}</td>

                                <td>
                                    @php
                                        $tanggalMaintenance = $asset->last_maintenance ?? $asset->entry_date;
                                        [$intervalValue, $intervalUnit] = explode(' ', $asset->scheduling_maintenance);
                                        switch (strtolower($intervalUnit)) {
                                            case 'weeks':
                                                $nextMaintenanceDate = \Carbon\Carbon::parse($tanggalMaintenance)->addWeeks($intervalValue);
                                                break;
                                            case 'months':
                                                $nextMaintenanceDate = \Carbon\Carbon::parse($tanggalMaintenance)->addMonths($intervalValue);
                                                break;
                                            case 'years':
                                                $nextMaintenanceDate = \Carbon\Carbon::parse($tanggalMaintenance)->addYears($intervalValue);
                                                break;
                                            default:
                                                $nextMaintenanceDate = \Carbon\Carbon::parse($tanggalMaintenance);
                                                break;
                                        }
                                        $maintenanceDue = now()->greaterThanOrEqualTo($nextMaintenanceDate);
                                    @endphp
                                    @if ($maintenanceDue)
                                        <a href="{{ route('assets.maintenance') }}" title="Click to Maintenance" style="cursor: pointer;">
                                        <span class="badge text-center align-middle"
                                            style="padding: 5px; font-size: 0.9em; background-color:rgba(255, 0, 0, 0.2); color:red;">Need
                                            Maintenance</span>
                                        </a>
                                    @else
                                        <span class="badge text-center align-middle"
                                            style="padding: 5px 44px; font-size: 0.9em; background-color:rgba(180,110,255, 0.3); color:#7505ed;">Done</span>
                                    @endif
                                </td>
                                <td>
                                <a href="{{ route('transactions.index') }}" title="Click to view transactions" style="cursor: pointer;">
                                    @if ($asset->status === 'Inventory')
                                        <span class="badge"
                                            style="padding: 5px 10px; font-size: 0.9em; background-color: rgba(254, 215, 19, 0.4); color:#fca308;">Available</span>
                                    @elseif ($asset->status === 'Operation')
                                        <span class="badge"
                                            style="padding: 5px 18px; font-size: 0.9em; background-color:rgba(2, 237, 61, 0.2); color:#149c87;">In Use</span>
                                    @endif
                                </a>
                                </td>
                                <td>
                                    <input type="checkbox" style="cursor: pointer;" class="assetCheckbox" value="{{ $asset->id }}"
                                        id="checkbox-{{ $asset->id }}" data-serial="{{ $asset->serial_number }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    <ul class="list-unstyled legend-list">
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 32px; color: #fff; margin-right: 5px; background-color: rgba(254, 215, 19, 0.4); color:#fca308;">Available</span>
                            <span class="legend-colon">:</span>
                            <span class="legend-description">Asset is available for use.</span>
                        </li>
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 39px; color: #fff; margin-right: 5px; background-color: rgba(2, 237, 61, 0.2); color:#149c87;">In
                                Use</span>
                            <span class="legend-colon">:</span>
                            <span class="legend-description">Asset is currently in operation.</span>
                        </li>
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 9px; margin-right: 5px; background-color: rgb(255, 0, 0, 0.2); color:red;">Need
                                Maintenance</span>
                            <span class="legend-colon">:</span>
                            <span class="legend-description">Assets need Maintenance.</span>
                        </li>
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 42px; color: #fff; margin-right: 5px; background-color: rgb(180,110,255, 0.3); color:#7505ed;">Done</span>
                            <span class="legend-colon">:</span>
                            <span class="legend-description">Assets have been maintained.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($assetss as $asset)
<div class="modal fade" id="detailsModal-{{ $asset->id }}" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center fw-bold w-100" id="detailsModalLabel">Asset Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Tabel Kiri -->
                    <div class="col-md-6">
                        <table class="table no-border-table">
                            <tbody>
                                <tr>
                                    <th><strong>Category</strong></th>
                                    <td>{{ $asset->category }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Code</strong></th>
                                    <td>{{ $asset->code }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Merk</strong></th>
                                    <td>{{ $asset->merk_name }}</td>
                                </tr>
                                <tr>
                                    <th><strong>S/N</strong></th>
                                    <td>{{ $asset->serial_number }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Specification</strong></th>
                                    <td>{{ $asset->spesification }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Condition</strong></th>
                                    <td>{{ $asset->condition }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Kanan -->
                    <div class="col-md-6">
                        <table class="table no-border-table">
                            <tbody>
                                <tr>
                                    <th><strong>Entry Date</strong></th>
                                    <td class="badge-style" style="background-color:rgba(2, 237, 61, 0.2);">
                                        @php
                                            $tanggalMasuk = $asset->entry_date;
                                            echo date('d M Y', strtotime($tanggalMasuk));
                                        @endphp
                                    </td>
                                </tr>

                                <tr>
                                    <th><strong>Handover Date</strong></th>
                                    <td 
                                        @php
                                            $tanggalDiterima = $asset->handover_date ?? '-';
                                            $bgColor = ($tanggalDiterima === '0000-00-00 00:00:00' || $tanggalDiterima === '-') 
                                                ? 'rgba(128, 128, 128, 0.2)' 
                                                : 'rgba(0, 255, 0, 0.2)';
                                        @endphp
                                        style="background-color: {{ $bgColor }}; border-radius: 20px; padding: 5px 10px; display: inline-block;">
                                        @if ($tanggalDiterima === '0000-00-00 00:00:00' || $tanggalDiterima === '-')
                                            Not Yet Handover
                                        @else
                                            {{ date('d M Y', strtotime($tanggalDiterima)) }}
                                        @endif
                                    </td>
                                </tr>


                                <tr>
                                    <th><strong>Scheduling Maintenance</strong></th>
                                    <td class="badge-style" style="background-color: rgba(63, 153, 232, 0.3);">{{ $asset->scheduling_maintenance }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Last Maintenance</strong></th>
                                    <td class="badge-style" style="background-color: rgba(255, 255, 0, 0.3);">
                                        @php
                                            $last_maintenanceDate = $asset->last_maintenance ?? '-';
                                            echo ($last_maintenanceDate === '0000-00-00 00:00:00' || $last_maintenanceDate === '-') ? '-' : date('d M Y', strtotime($last_maintenanceDate));
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <th><strong>Next Maintenance</strong></th>
                                    <td class="badge-style" style="background-color: rgba(255, 182, 193, 0.3);">
                                        @if ($asset->next_maintenance)
                                            @php
                                                $nextMaintenanceDate = \Carbon\Carbon::parse($asset->next_maintenance);
                                                echo $nextMaintenanceDate->format('d M Y');
                                            @endphp
                                        @else
                                            <span>Not Scheduled</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th><strong>Asset Age</strong></th>
                                    <td id="asset-age-{{ $asset->id }}" 
                                        class="{{ $asset->is_expired ? 'text-danger' : '' }}"
                                        style="border-radius: 20px; background-color: rgba(128, 128, 128, 0.2); padding: 5px 10px; display: inline-block;">
                                        <span class="countdown" data-time-remaining="{{ $asset->time_remaining_seconds }}"></span>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: #FFC107;"
                        data-bs-toggle="offcanvas" data-bs-target="#depreciationOffcanvas-{{ $asset->id }}"
                        onclick="closeDetailsModal('{{ $asset->id }}'); loadDepreciationData('{{ $asset->code }}', '{{ $asset->id }}')">
                    <i class="bi bi-calculator"></i>
                    View Depreciation
                </button>
                <button type="button" class="btn" style="background-color: #9A9A9A;"
                        data-bs-toggle="offcanvas" data-bs-target="#historyOffcanvas-{{ $asset->id }}"
                        onclick="closeDetailsModal('{{ $asset->id }}'); loadTransactionHistory('{{ $asset->code }}', '{{ $asset->id }}')">
                    <i class="bi bi-clock-history"></i>
                    View History
                </button>
            </div>

        </div>
    </div>
</div>


<!-- History Offcanvas -->
<div class="offcanvas offcanvas-end" id="historyOffcanvas-{{ $asset->id }}" tabindex="-1" aria-labelledby="historyOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="historyOffcanvasLabel">
            Transaction History for <span class="asset-code">{{ $asset->code }}</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mt-4">
            <table class="table table-hover" id="historyTable-{{ $asset->id }}">
                <thead>
                    <tr>
                        <th>Transfer Date</th>
                        <th>Action</th>
                        <th>Holder</th>
                        <th>Note</th>
                        <th>Documentation</th>
                    </tr>
                </thead>
                <tbody id="modalHistoryBody-{{ $asset->id }}">
                    <!-- History rows will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Depreciation Offcanvas -->
<div class="offcanvas offcanvas-end" id="depreciationOffcanvas-{{ $asset->id }}" tabindex="-1" aria-labelledby="depreciationOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold" id="depreciationOffcanvasLabel">
            Depreciation History for {{ $asset->code }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Asset Value</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="modalDepreciationBody-{{ $asset->id }}">
                <!-- Depreciation rows will be dynamically inserted here -->
            </tbody>
        </table>
    </div>
</div>




    @endforeach



    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.open-history-modal').forEach(button => {
            button.addEventListener('click', function () {
                var assetCode = this.getAttribute('data-code');
                var assetId = this.getAttribute('data-asset-id');

                // Load transaction history
                loadTransactionHistory(assetCode, assetId);

                // Load depreciation data
                loadDepreciationData(assetCode, assetId);
            });
        });
    });
    function closeDetailsModal(assetId) {
        const detailsModal = document.getElementById(`detailsModal-${assetId}`);
        const modalInstance = bootstrap.Modal.getInstance(detailsModal);
        if (modalInstance) {
            modalInstance.hide();
        }
    }
     // Function to update the countdown
    // Function to update the countdown
    function updateCountdown() {
        document.querySelectorAll('.countdown').forEach(function(element) {
            let timeRemaining = parseInt(element.getAttribute('data-time-remaining'));

            if (timeRemaining > 0) {
                timeRemaining++;  // Increment to keep the countdown running

                let days = Math.floor(timeRemaining / (24 * 60 * 60));
                let hours = Math.floor((timeRemaining % (24 * 60 * 60)) / (60 * 60));
                let minutes = Math.floor((timeRemaining % (60 * 60)) / 60);
                let seconds = timeRemaining % 60;

                element.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                element.setAttribute('data-time-remaining', timeRemaining);  // Update the remaining time in seconds

                // If asset age is exceeded, set text to red
                let assetAgeElement = element.closest('td');
                if (timeRemaining < 0) {
                    assetAgeElement.classList.add('text-danger');
                } else {
                    assetAgeElement.classList.remove('text-danger');
                }
            }
        });
    }

    // Call the updateCountdown function every second
    setInterval(updateCountdown, 1000);
    function loadTransactionHistory(assetCode, assetId) {
    var modalBody = document.getElementById('modalHistoryBody-' + assetId);

    fetch(`/transaction-history/${assetCode}`)
        .then(response => response.json())
        .then(data => {
            modalBody.innerHTML = '';

            data.forEach(item => {
                let typeBadge;
                let printButton = '';
                let docIcon = '';

                if (item.type_transactions === 'Return') {
                    typeBadge = '<span class="badge bg-depreciated text-danger">Return</span>';
                    printButton = `<button class="btn btn-sm btn-success" onclick="printReturnProof(${item.id})"><i class="fas fa-print"></i></button>`;
                } else if (item.type_transactions === 'Handover') {
                    typeBadge = '<span class="badge bg-hasno text-success">Handover</span>';
                    printButton = `<button class="btn btn-sm btn-success" onclick="printHandoverProof(${item.id})"><i class="fas fa-print"></i></button>`;
                } else {
                    typeBadge = `<span class="badge bg-secondary">${item.type_transactions}</span>`;
                }

                if (item.documentation) {
                    docIcon = `<a href="/storage/${item.documentation}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file-alt"></i></a>`;
                } else {
                    docIcon = '<span class="text-muted"><i class="fas fa-times"></i></span>';
                }

                var row = `<tr>
                                <td>${item.created_at}</td>
                                <td>${typeBadge}</td>
                                <td>${item.name_holder}</td>
                                <td>${item.note}</td>
                                <td>${docIcon}${printButton}</td> 
                            </tr>`;
                modalBody.innerHTML += row;
            });
        });
}

// Function to load depreciation data
function loadDepreciationData(assetCode, assetId) {
    var modalBody = document.getElementById('modalDepreciationBody-' + assetId);

    fetch(`/depreciation/${assetCode}`)
        .then(response => response.json())
        .then(data => {
            modalBody.innerHTML = '';

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(item => {
                    var currentDate = new Date();
                    var depreciationDate = new Date(item.date);

                    var status = (depreciationDate > currentDate) ? 'Has not depreciated' : 'Depreciated';
                    var badgeClass = (status === 'Depreciated') ? 'badge bg-depreciated text-danger' : 'badge bg-hasno text-success';

                    var row = `<tr>
                                    <td>${item.date}</td>
                                    <td>${formatNumber(item.depreciation_price)}</td>
                                    <td><span class="${badgeClass}">${status}</span></td>
                                </tr>`;
                    modalBody.innerHTML += row;
                });
            } else {
                modalBody.innerHTML = '<tr><td colspan="3">No depreciation data available</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching depreciation data:', error);
            modalBody.innerHTML = '<tr><td colspan="3">Error loading data</td></tr>';
        });
}

    // Basic number formatting function if formatNumber is not defined
    function formatNumber(number) {
        return new Intl.NumberFormat().format(number);
    }

    // Print Handover Proof
    function printHandoverProof(transactionId) {
        const route = `/prints/handover/${transactionId}`;
        window.open(route, '_blank');
    }

    // Print Return Proof
    function printReturnProof(transactionId) {
        const route = `/prints/return/${transactionId}`;
        window.open(route, '_blank');
    }
</script>






@section('scripts')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
@endsection
@endsection
<!-- Include QRCode.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const generateQRCodeButton = document.getElementById('generateQRCodeButton');
        const exportToExcelButton = document.getElementById('exportToExcelButton');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const assetCheckboxes = document.querySelectorAll('.assetCheckbox');

        function toggleActionButtons() {
            const isAnyCheckboxChecked = Array.from(assetCheckboxes).some(checkbox => checkbox.checked);
            generateQRCodeButton.style.display = isAnyCheckboxChecked ? 'inline-block' : 'none';
            exportToExcelButton.style.display = isAnyCheckboxChecked ? 'inline-block' : 'none';
        }

        // Toggle button visibility on 'Select All' checkbox change
        selectAllCheckbox.addEventListener('change', () => {
            assetCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
            toggleActionButtons();
        });

        // Toggle button visibility on individual checkbox changes
        assetCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', toggleActionButtons);
        });

        // QR Code button click handler
        generateQRCodeButton.addEventListener('click', function () {
            const selectedIds = Array.from(assetCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                alert('Please select at least one asset.');
                return;
            }

            const idsString = selectedIds.join(',');
            window.open(`{{ url('/print/qr') }}?ids=${idsString}`, '_blank');
        });

        // Export to Excel button click handler
        exportToExcelButton.addEventListener('click', function () {
            const selectedIds = Array.from(assetCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                alert('Please select at least one asset.');
                return;
            }

            // Send a request to the export route with selected IDs
            const idsString = selectedIds.join(',');
            window.location.href = `{{ url('/export/excel') }}?ids=${idsString}`;
        });
    });
</script>
<style>
    /* RESPONSIVE - Offcanvas */
@media (max-width: 768px) {
    .offcanvas {
        width: 100% !important; /* Offcanvas akan menutupi seluruh layar di mobile */
    }

    .offcanvas-body {
        padding: 5px; /* Kurangi padding untuk tampilan yang lebih baik */
    }
}

    /* DARK MODE - Offcanvas */
body.dark-mode .offcanvas {
    background-color: #0b0b0d;
    color: #eaeaea;
}

body.dark-mode .offcanvas-header {
    background-color: #0b0b0d;
    color: #ffffff;
    border-bottom: 1px solid #444;
}

body.dark-mode .offcanvas-title {
    color: #ffffff;
}

body.dark-mode .btn-close {
    filter: invert(1);
}

body.dark-mode .offcanvas-body {
    background-color: #0b0b0d;
    color: #eaeaea;
}

body.dark-mode .table-hover tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

body.dark-mode .table thead {
    background-color: #444444;
    color: #eaeaea;
}

body.dark-mode .table tbody {
    color: #eaeaea;
}

body.dark-mode .table td,
body.dark-mode .table th {
    border-color: #555;
}

    
      /* Custom styling for badges */
      .badge-style {
        background-color: rgba(0, 0, 255, 0.2);
        border-radius: 20px;
        padding: 5px 10px;
        display: inline-block;
        white-space: nowrap; /* Prevents text wrapping */
    }

    /* Table styling for smaller devices */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 100%;
            margin: 0;
        }

        .table {
            width: 100%;
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table td, .table th {
            white-space: nowrap;
        }
    }

    .card {
        box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
    }

    .no-border-table th,
    .no-border-table td {
        border: none !important;
        padding: 9px 12px;
    }

    .no-border-table td {
        margin-top: 6px;
    }

    .legend-list {
        font-size: 0.875em;
        line-height: 1.5;
        margin-top: 33px;
    }

    .legend-list li {
        display: flex;
        flex-direction: row;
        /* Align items horizontally */
        align-items: center;
        /* Center vertically */
        margin-bottom: 5px;
    }

    .legend-description {
        margin-left: 15px;
        /* Add margin for larger screens */
    }

    /* Responsive styles */
    @media (max-width: 576px) {
        .legend-list li {
            flex-direction: column;
            /* Stack items vertically on mobile */
            align-items: flex-start;
            /* Align items to the start */
        }

        .legend-colon {
            display: none;
            /* Hide colon on mobile */
        }

        .legend-description {
            margin-left: 0;
            /* Reset margin for mobile */
            text-align: left;
            /* Align description to the left */
        }
    }

    /* Container styles */
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        margin-top: 30px;
    }

    .back-wrapper {
        display: flex;
        align-items: center;
        margin-right: auto;
    }

    .back-icon {
        cursor: pointer;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -10%, #FCA918);
        height: 36px;
        width: 36px;
        border-radius: 4px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);
        padding-top: 9px;
        padding-left: 9px;
        transition: background 0.3s ease;
    }

    .back-icon:hover {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -13%, #FBCA07);
    }

    .back-text {
        display: flex;
        flex-direction: column;
        margin-left: 10px;
    }

    .back-text .title {
        font-weight: 600;
        font-size: 17px;
    }

    .back-text .small-text {
        font-size: 0.8rem;
        color: #aaa;
        margin-top: -3px;
    }

    .assetList-title {
        font-weight: bold;
        font-size: 1.125rem;
    }

    .icon-wrapper {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -10%, #FCA918);
        height: 36px;
        width: 36px;
        border-radius: 4px;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.25);
    }

    .previous-icon {
        font-size: 16px;
    }

    .btn {
        margin: 0 0.5rem;

    }

    .bg-depreciated {
        background-color:rgba(255, 0, 0, 0.2); 
    }

    .bg-hasno {
        background-color:rgba(2, 237, 61, 0.2);
    }

    .asset-code {
        background-color: rgba(128, 128, 128, 0.1);
        /* Light gray with transparency */
        padding: 4px 8px;
        /* Optional: Adjust padding for spacing */
        border-radius: 5px;
        /* Rounded corners */
        display: inline-block;
        /* Keeps the span as an inline element */
    }
</style>