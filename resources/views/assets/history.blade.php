@extends('layouts.app')
@section('title', 'Entry & Scrap')

@section('content')
<div class="container">
    <br>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div>
            <div class="header-container">
                <div class="back-wrapper">
                    <i class='bx bxs-chevron-left back-icon' id="back-icon"></i>
                    <div class="back-text">
                        <span class="title">Back</span>
                        <span class="small-text">to previous page</span>
                    </div>
                </div>
                <h3 class="assetHistory-title">
                    Entry & Scrap History&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-clock-rotate-left previous-icon"></i>
                    </span>
                </h3>
            </div>
            <div class="header-container-mobile">
                <h3 class="assetHistory-title">
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-clock-rotate-left previous-icon"></i>
                    </span>
                    &nbsp;&nbsp;Entry & Scrap History
                </h3>
            </div>
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Date</th>
                            <th scope="col">Asset Code</th>
                            <th scope="col">Merk</th>
                            <th scope="col">S/N</th>
                            <th scope="col">Action</th>
                            <th scope="col">Documentation</th> <!-- New Documentation column -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asset_histories as $index => $history)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($history->action_time)->format('d M Y, H:i') }}</td>
                                <td>{{ $history->code }}</td>
                                <td>{{ $history->merkDetail->name ?? 'N/A' }}</td>
                                <!-- Ensure to use the correct property for merk -->
                                <td>{{ $history->serial_number }}</td>
                                <td>
                                    @if ($history->action === 'INSERT')
                                        <span class="badge"
                                            style="padding: 5px 15px; color: #fff; border-radius: 0.5em; background-color:rgba(2, 237, 61, 0.2); color:#149c87;">Entry</span>
                                    @elseif ($history->action === 'DELETE')
                                        <span class="badge"
                                            style="padding: 5px 15px; color: #fff; border-radius: 0.5em; background-color:rgba(255, 0, 0, 0.2); color:red;">Scrap</span>
                                    @else
                                        <span class="badge"
                                            style="padding: 5px 15px; color: #fff; border-radius: 0.5em; background-color: #4fb0f1">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($history->documentation)
                                        <a href="{{ asset($history->documentation) }}" target="_blank" class="btn btn-sm"
                                            style="background-color: #4fb0f1; color: #fff; font-weight: 600;"> <i
                                                class="bi bi-file-earmark-image"></i> Documentation</a>
                                    @else
                                        <span class="text-muted">No Document</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    <ul class="list-unstyled legend-list">
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 10px; color:#fff; background-color:rgba(2, 237, 61, 0.2); color:#149c87;">Entry</span> : <span
                                class="legend-description">Assets added.</span>
                        </li>
                        <li>
                            <span class="badge legend-badge"
                                style="padding: 5px 10px; color:#fff; background-color:rgba(255, 0, 0, 0.2); color:red;">Scrap</span> : <span
                                class="legend-description">Assets have been removed or destroyed.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
    }

    /* Header Styles */
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        margin-top: 30px;
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
        margin-right: auto;
        transition: background 0.3s ease;
        /* Transition untuk efek hover */
    }

    .back-icon:hover {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) -13%, #FBCA07);
        /* Warna gradien saat hover dengan putih sedikit di kiri */
    }

    .back-wrapper {
        display: flex;
        align-items: center;
        /* Center vertically */
        margin-right: auto;
        /* Push the dashboard title to the right */
    }

    .back-text {
        display: flex;
        flex-direction: column;
        /* Stack text vertically */
        margin-left: 10px;
        /* Space between icon and text */
    }

    .back-text .title {
        font-weight: 600;
        font-size: 17px;
    }

    .back-text .small-text {
        font-size: 0.8rem;
        /* Smaller font size for the second line */
        color: #aaa;
        /* Optional: a lighter color for the smaller text */
        margin-top: -3px;
    }

    .assetHistory-title {
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

    /* CSS untuk menghapus garis tabel pada modal */
    .no-border-table th,
    .no-border-table td {
        border: none !important;
        padding: 0.5rem;
    }

    .modal-title {
        font-weight: bold;
        text-align: center;
        width: 100%;
    }

    .legend-list {
        font-size: 0.875em;
        line-height: 1.5;
    }

    .legend-list li {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }

    .legend-list li .badge {
        min-width: 80px;
        margin-right: 10px;
    }

    .legend-list li .legend-description {
        margin-left: 10px;
        text-align: left;
    }

    /* CSS for table row borders */
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

    .legend-colon {
        margin: 0 5px;
        /* Space around the colon */
    }

    /* Hide colon on mobile devices */
    @media (max-width: 576px) {
        .header-container {
            flex-direction: column;
            /* Stack items vertically on mobile */
            align-items: flex-start;
            /* Align items to the start */
            padding: 10px 20px;
            /* Adjust padding */
        }

        .back-text .title {
            font-size: 1rem;
            /* Adjust font size for mobile */
        }

        .back-text .small-text {
            font-size: 0.75rem;
            /* Smaller font size for mobile */
        }

        .legend-colon {
            display: none;
            /* Hide colon */
        }
    }
</style>

@endsection