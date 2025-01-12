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
                                <form action="{{ route('orders.filter') }}" method="GET">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>
                                @if(isset($orders))
                                <div class="table-responsive mt-4">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Transaction Time</th>
                                            <th>Total Price</th>
                                            <th>Total Item</th>
                                            <th>Kasir</th>
                                        </tr>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td><a href="{{ route('order.show', $order->id) }}">{{ $order->transaction_time }}</a></td>
                                                <td>{{ $order->total_price }}</td>
                                                <td>{{ $order->total_item }}</td>
                                                <td>{{ $order->kasir->name }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                @endif
                                <div class="list-group mt-4">
                                    <a href="{{ route('reports.daily') }}" class="list-group-item list-group-item-action">Daily Report</a>
                                    <a href="{{ route('reports.monthly') }}" class="list-group-item list-group-item-action">Monthly Report</a>
                                </div>
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
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
