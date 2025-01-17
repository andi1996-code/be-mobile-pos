<!-- resources/views/report/index.blade.php -->
@extends('layouts.app')

@section('title', 'Reports')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Reports</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Reports</a></div>
                    <div class="breadcrumb-item">All Reports</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Reports</h2>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Filter Reports</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('report.generate') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="type">Type of Report</label>
                                        <select id="type" name="type" class="form-control">
                                            {{-- <option value="daily">Daily Report</option> --}}
                                            <option value="monthly">Monthly Report</option>
                                            <option value="yearly">Yearly Report</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="date-range">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                        <label for="end_date">End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                    </div>
                                    <div class="form-group" id="month-year">
                                        <label for="month">Month</label>
                                        <input type="month" id="month" name="month" class="form-control">
                                        <label for="year">Year</label>
                                        <select id="year" name="year" class="form-control">
                                            @for ($year = 2000; $year <= date('Y'); $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group" id="year-only">
                                        <div class="form-group" id="year-only">
                                            <label for="year">Year</label>
                                            <select id="year" name="year_only" class="form-control">
                                                @for ($year = 2000; $year <= date('Y'); $year++)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const dateRange = document.getElementById('date-range');
            const monthYear = document.getElementById('month-year');
            const yearOnly = document.getElementById('year-only');

            function toggleDateFields() {
                if (typeSelect.value === 'daily') {
                    dateRange.style.display = 'block';
                    monthYear.style.display = 'none';
                    yearOnly.style.display = 'none';
                } else if (typeSelect.value === 'monthly') {
                    dateRange.style.display = 'none';
                    monthYear.style.display = 'block';
                    yearOnly.style.display = 'none';
                } else {
                    dateRange.style.display = 'none';
                    monthYear.style.display = 'none';
                    yearOnly.style.display = 'block';
                }
            }

            typeSelect.addEventListener('change', toggleDateFields);
            toggleDateFields(); // Run on page load to set initial state
        });
    </script>
@endpush
