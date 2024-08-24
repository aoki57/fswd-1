@extends('layouts.app')

@section('container')
<div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-3 flex-wrap pb-2 pt-3">
    <h1 class="h2">{{ $employee->employee_number . ' - ' . $employee->name }}</h1>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('employees.index') }}" class="text-decoration-none text-dark">
                        <i class="bi bi-arrow-left-circle"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col col-md-4">
                        <p class="font-weight-bold">Nomor Induk</p>
                    </div>
                    <div class="col">
                        <p>: {{ $employee->employee_number }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4">
                        <p class="font-weight-bold">Nama Karyawan</p>
                    </div>
                    <div class="col">
                        <p>: {{ $employee->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4">
                        <p class="font-weight-bold">Alamat</p>
                    </div>
                    <div class="col">
                        <p>: {{ $employee->address }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4">
                        <p class="font-weight-bold">Tanggal Lahir</p>
                    </div>
                    <div class="col">
                        <p>: {{ $employee->birth_date }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4">
                        <p class="font-weight-bold">Tanggal Bergabung</p>
                    </div>
                    <div class="col">
                        <p>: {{ $employee->join_date }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection