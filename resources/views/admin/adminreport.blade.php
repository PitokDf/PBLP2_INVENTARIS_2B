@extends('layouts.content')
@section('title', 'Bug Report')
@section('scriptPages')
    <script src="/js/admin_bug_report.js"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-secondary">BUG REPORT</h5>
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
