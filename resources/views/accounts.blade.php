@extends('layouts.sitemaster')
@section('pageTitle', 'Wallet Accountings')
@section('content')
  <div class="content pt-5">
    <div class="container">
      <div class="card card-primary card-shadow p-4" data-collapsed="0">
        <div class="card-heading">
          <div class="page-title text-center p-3">
            <strong><h2>Statement of Account<h2></strong>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive advance-table">
              <table id="example1" class="table display table-striped table-bordered">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($accounts as $account)
                    <tr>
                      <td>{{ $account->last_name }} {{ $account->first_name }}</td>
                      <td>{{ $account->txid }}</td>
                      <td>
                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($account->created_at))->toDateTimeString() }} 
                      </td>
                      <td>{{ $account->type }}</td>
                      <td>{{ $account->amount }}</td>
                      <td>{{ $account->purpose }}</td>
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
@endsection
