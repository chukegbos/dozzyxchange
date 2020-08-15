@extends('layouts.sitemaster')
@section('pageTitle', 'Service')
@section('content')
  <div class="content pt-5">
    <div class="container">
      <div class="card card-primary card-shadow p-4" data-collapsed="0">
        <div class="card-heading">
          <div class="page-title text-center p-3">
            <strong><h2>Services<h2></strong>
          </div>
        </div>
        <div class="card-body">
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
    </div>
  </div>
@endsection
