@extends('layouts.app')

@section('container')
    <div class="d-flex justify-content-between flex-md-nowrap align-items-center border-bottom mb-3 flex-wrap pb-2 pt-3">
        <h1 class="h2">Leaves</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('leaves.create') }}" class="btn btn-sm btn-success">
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
                                <th>Tanggal Cuti</th>
                                <th>Lama Cuti</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $key => $leave)
                                <tr>
                                    <td>{{ $leaves->firstItem() + $key }}</td>
                                    <td>{{ $leave->employee->employee_number }}</td>
                                    <td>{{ $leave->employee->name }}</td>
                                    <td>{{ $leave->formatted_leave_date }}</td>
                                    <td>{{ $leave->leave_duration }} days</td>
                                    <td>{{ $leave->leave_information }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('leaves.edit', $leave->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger confirm-button">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $leaves->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
