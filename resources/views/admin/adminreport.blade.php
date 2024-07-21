@extends('layouts.content')
@section('title', 'Bug Report')
@section('scriptPages')
    @vite(['resources/js/admin_bug_report.js'])
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">BUG REPORT</h5>
                    <button type="button" class="btn btn-sm btn-light" id="btn_refresh" data-table="table_bug">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-reponsive">
                        <table id="table_bug" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>List Report</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
