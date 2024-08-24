@extends('layouts.app')

@section('container')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-3 flex-wrap pb-2 pt-3">
        <h1 class="h2">Leave Balances</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <a href="" class="btn btn-sm btn-success">
                            <i class="bi bi-plus"></i>
                            <span>Buat Cuti</span>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-bordered table-striped table-hover table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Induk</th>
                                <th>Nama</th>
                                <th>Sisa Cuti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $key => $employee)
                                <tr>
                                    <td>{{ $employees->firstItem() + $key }}</td>
                                    <td>{{ $employee->employee_number }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->leaveBalances->first()->leave_quota ?? 12 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
