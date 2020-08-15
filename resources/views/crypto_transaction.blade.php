@extends('layouts.sitemaster')
@section('pageTitle', 'Crypto Transactions')
@section('content')
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card mt-3">
          @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
            </div>
          @endif

          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Error!</strong>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="card-header">
            <h4 class="page-title">Crypto Transactions</h4>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table display table-striped table-bordered text-center">
              <thead>
                <tr>
                  <th>Trans ID</th>
                  <th>Type</th>
                  <th>Rate/$</th>
                  <th>Crypto</th>
                  <th>Amount Sent</th>
                  <th>Sent to</th>
                  <th>You are paid</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($transactions as $transaction)
                  <tr>
                    <td>{{ $transaction->txid }}</td>
                    <td>{{ $transaction->type }}</td>
                    <td>
                      @if($transaction->type=='sell')
                        {{ $transaction->buying_rate }}
                      @else
                        {{ $transaction->selling_rate }}
                      @endif
                    </td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ $transaction->value }}</td>
                    <td>{{ $transaction->addr }}</td>
                    
                    <td>{{ $transaction->amount_rec }}</td>
                    <td>
                      @if($transaction->status==0)
                        <span class="btn bg-danger">Unconfirmed</span>
                      @elseif($transaction->status==1)
                        <span class="btn bg-warning">Partially Confirmed</span>
                      @else
                        <span v-else class="btn bg-success">Confirmed</span>
                      @endif
                    </td>
                  </tr>
                @empty
                @endforelse 
              </tbody>              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
