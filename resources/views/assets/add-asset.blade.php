@extends('layouts.app')
@section('title', 'Add Asset')

@section('content')
<div class="container">
    <div>
        <div class="container">
            <div class="header-container">
                <div class="back-wrapper">
                    <i class='bx bxs-chevron-left back-icon' id="back-icon"></i>
                    <div class="back-text">
                        <span class="title">Back</span>
                        <span class="small-text">to previous page</span>
                    </div>
                </div>
                <h3 class="addAsset-title">
                    Add Asset&nbsp;&nbsp;
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-cubes previous-icon"></i>
                    </span>
                </h3>
            </div>
            <div class="header-container-mobile mt-4">
                <h3 class="addAsset-title">
                    <span class="icon-wrapper">
                        <i class="fa-solid fa-2xs fa-cubes previous-icon"></i>
                    </span>
                    &nbsp;&nbsp;Add Asset
                </h3>
            </div>
        </div>
        <br>
    </div>
    <div class="card">
        <div class="card-body" style="padding: 30px;">
            <script>
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
            <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data" id="addAsset">
                @csrf
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category"
                            name="category" value="{{ old('category') }}" placeholder="Enter asset category">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="code" class="form-label">Asset Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                            name="code" value="{{ old('code') }}" placeholder="Enter asset code">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="merk" class="form-label">Merk</label>
                        <select class="form-select @error('merk') is-invalid @enderror" id="merk" name="merk">
                            <option value="">Select Merk</option>
                            @foreach ($merkes as $merk)
                                <option value="{{ $merk->id }}" {{ old('merk') == $merk->id ? 'selected' : '' }}>
                                    {{ $merk->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('merk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="serial_number" class="form-label">Serial Number</label>
                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror"
                            id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                            placeholder="Enter serial number">
                        @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="spesification" class="form-label">Specification</label>
                        <input type="text" class="form-control @error('spesification') is-invalid @enderror" id="type"
                            name="spesification" value="{{ old('spesification') }}" placeholder="Enter spesification">
                        @error('spesification')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="condition" class="form-label">Condition</label>
                        <select class="form-select @error('condition') is-invalid @enderror" id="condition"
                            name="condition" required>
                            <option value="">Select Condition</option>
                            <option value="New" {{ old('condition') == 'New' ? 'selected' : '' }}>New</option>
                            <option value="Good" {{ old('condition') == 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Exception" {{ old('condition') == 'Exception' ? 'selected' : '' }}>Exception
                            </option>
                            <option value="Bad" {{ old('condition') == 'Bad' ? 'selected' : '' }}>Bad</option>
                        </select>
                        @error('condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="entry_date" class="form-label">Entry Date</label>
                        <input type="date" class="form-control @error('entry_date') is-invalid @enderror"
                            id="entry_date" name="entry_date" value="{{ old('entry_date') }}"
                            placeholder="Enter the entry date">
                        @error('entry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="starting_price" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control @error('starting_price') is-invalid @enderror"
                                id="starting_price" name="starting_price" value="{{ old('starting_price') }}"
                                placeholder="Enter price" oninput="formatPrice(this)"
                                onkeydown="return onlyNumberKey(event)">
                            @error('starting_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>





                    <div class="col-md-6 form-group">
                        <label for="documentation" class="form-label">Documentation</label>
                        <input type="file" class="form-control @error('documentation') is-invalid @enderror"
                            id="documentation" name="documentation" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">*Please upload documentation files for proof that the assets
                            have actually been added to the warehouse.</small>
                        @error('documentation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="scheduling_maintenance" class="form-label">Scheduling Maintenance</label>
                        <div class="input-group">
                            <input type="number"
                                class="form-control @error('scheduling_maintenance_value') is-invalid @enderror"
                                id="scheduling_maintenance_value" name="scheduling_maintenance_value"
                                placeholder="Enter number" required value="{{ old('scheduling_maintenance_value') }}">
                            <div class="input-group-append">
                                <select class="form-select @error('scheduling_maintenance_unit') is-invalid @enderror"
                                    id="scheduling_maintenance_unit" name="scheduling_maintenance_unit" required>
                                    <option value="Weeks" {{ old('scheduling_maintenance_unit') == 'Weeks' ? 'selected' : '' }}>Weeks&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                    <option value="Months" {{ old('scheduling_maintenance_unit') == 'Months' ? 'selected' : '' }}>Months&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                    <option value="Years" {{ old('scheduling_maintenance_unit') == 'Years' ? 'selected' : '' }}>Years&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                </select>
                            </div>
                            <small class="form-text text-muted">*Please enter the period for routine asset
                                maintenance</small>
                        </div>
                        @error('scheduling_maintenance_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('scheduling_maintenance_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="asset-age col-md-3 form-group text-end">
                        <label for="asset_age" class="form-label">Asset Age</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('asset_age_value') is-invalid @enderror"
                                id="asset_age_value" name="asset_age_value" placeholder="Enter number" required
                                value="{{ old('asset_age_value') }}">
                            <div class="input-group-append">
                                <select class="form-select @error('asset_age_unit') is-invalid @enderror"
                                    id="asset_age_unit" name="asset_age_unit" required>
                                    <option value="Months" {{ old('asset_age_unit') == 'Months' ? 'selected' : '' }}>
                                        Months&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                    <option value="Years" {{ old('asset_age_unit') == 'Years' ? 'selected' : '' }}>
                                        Years&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @error('asset_age_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('asset_age_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn" style="background-color:#1bcfb4;">Submit</button>
                    <a href="{{ route('assets.index') }}" class="btn ml-3" style="background-color:#FE7C96;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
<script>
    document.getElementById('addAsset').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

        // Show loading alert
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we create the asset.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate form submission
        setTimeout(() => {
            this.submit(); // Submit the form after the loading alert
        }, 1500);
    });
    function onlyNumberKey(evt) {
        let charCode = evt.which ? evt.which : evt.keyCode;
        // Izinkan hanya angka (0-9) dan tombol pengontrol (backspace, delete, dll.)
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function formatPrice(input) {
        // Hapus semua titik dari nilai input
        let value = input.value.replace(/\./g, '');

        // Tambahkan titik setiap tiga digit
        let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Perbarui nilai input dengan angka yang sudah diformat
        input.value = formattedValue;
    }

</script>
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
        margin-top: 54px;
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

    .addAsset-title {
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

    .form-label {
        font-weight: 550;
    }

    .btn {
        margin: 0 0.5rem;
        font-size: 16px;
        font-weight: bold;
        color: white;
    }

    /* Hide arrows in number input for Chrome, Safari, Edge, and Opera */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hide arrows in number input for Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endsection