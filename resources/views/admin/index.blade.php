@extends('layouts.sitemaster')
@section('pageTitle', 'Admin Dashboard')
@section('content')
<div class="content pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ url('admin/users') }}">
                    <div class="info-box bg-blue p-3">
                        <span class="info-box-icon"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number"><h2>{{ $users }}</h2></span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ url('admin/withdraw') }}">
                    <div class="info-box bg-green p-3">
                        <span class="info-box-icon"><i class="fa fa-calculator"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending Withdrawals</span>
                            <span class="info-box-number"><h2>{{ $withdraws }}</h2></span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ url('admin/transactions/airtime') }}">
                    <div class="info-box bg-red p-3">
                        <span class="info-box-icon"><i class="fa fa-money"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pending Transactions</span>
                            <span class="info-box-number"><h2>{{ $transactions }}</h2></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
              <div class="portfolio-item text-center product-hover">
                <img src="{{ asset('img/btc.jpg') }}" class="img-fluid portfolio-image">
                <h3 class="header-title mb-4">Crypto Currency</h3>
                <a href="{{ url('admin/services/crypto') }}" class="btn btn-exel"> Add </a>
              </div>          
            </div>

            <div class="col-md-4">
              <div class="portfolio-item text-center product-hover">
                <img src="{{ asset('img/airtime.jpg') }}" class="img-fluid portfolio-image">
                <h3 class="header-title mb-4">Dozzy Airtime2Cash</h3>
                <a href="{{ url('admin/services/airtime') }}" class="btn btn-exel"> Add </a>
              </div>          
            </div>

            <div class="col-md-4">
              <div class="portfolio-item text-center product-hover">
                <img src="{{ asset('img/gcard.png') }}" class="img-fluid portfolio-image">
                <h3 class="header-title mb-4">Gift Card</h3>
                <button class="btn btn-exel"> Coming Soon </button>
              </div>          
            </div>
          </div>
    </div>
</div>
@endsection