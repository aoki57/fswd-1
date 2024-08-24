@extends('layouts.app')

@section('container')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-3 flex-wrap pb-2 pt-3">
        <h1 class="h2">Create Leaves</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('leaves.index') }}" class="text-decoration-none text-dark">
                            <i class="bi bi-arrow-left-circle"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('leaves.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="employee_id">Karyawan</label>
                            <select name="employee_id" class="form-select">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->employee_number . ' - ' . $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="leave_date">Tanggal Cuti</label>
                            <input type="date" name="leave_date" class="form-control @error('leave_date') is-invalid @enderror" id="leave_date" autocomplete="off" {{ old('leave_date') }}>
                            @error('leave_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="leave_duration">Lama Cuti</label>
                            <select name="leave_duration" class="form-select">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('leave_duration')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                              <label for="leave_information" class="form-label">Keterangan</label>
                              <textarea name="leave_information" class="form-control @error('leave_information') is-invalid @enderror" id="leave_information" rows="3" autocomplete="off" {{ old('leave_information') }} style="resize: none"></textarea>
                            @error('leave_information')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info w-100 d-block" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-floppy me-2"></i>
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
