@extends('layouts.app')

@section('container')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-3 flex-wrap pb-2 pt-3">
        <h1 class="h2">Edit Employee</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('employees.index') }}" class="text-decoration-none text-dark">
                            <i class="bi bi-arrow-left-circle"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="employee_number">Nomor Induk</label>
                            <input type="text" name="employee_number" class="form-control @error('employee_number') is-invalid @enderror" id="employee_number" placeholder="Kosongkan jika tidak ingin ubah" autocomplete="off"
                                value="{{ old('employee_number', $employee->employee_number) }}">
                            @error('employee_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama Karyawan" autocomplete="off" value="{{ old('name', $employee->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="3" autocomplete="off" style="resize: none">{{ old('address', $employee->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="birth_date">Ulang Tahun</label>
                            <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" placeholder="Tanggal Ulang Tahun" value="{{ old('birth_date', $employee->birth_date) }}">
                            @error('birth_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="join_date">Bergabung Pada</label>
                            <input type="date" name="join_date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" placeholder="Tanggal Bergabung" value="{{ old('join_date', $employee->join_date) }}">
                            @error('join_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-info w-100 d-block confirm-button">
                            <i class="bi bi-floppy me-2"></i>
                            <span>Ubah</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
