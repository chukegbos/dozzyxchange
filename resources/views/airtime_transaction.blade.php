@extends('layouts.sitemaster')
@section('pageTitle', 'Airtime Transactions')
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
            <h4 class="page-title">Airtime Transactions</h4>
          </div>

          <div class="card-body table-responsive">
            <table id="example1" class="table display table-striped table-bordered text-center">
              <thead>
                <tr>
                  <th>Ref ID</th>
                  <th>User</th>
                  <th>Network</th>
                  <th>Phone</th>
                  <th>Amount Paid (<span>&#8358;</span>)</th>
                  <th>Amount (to) Recieve (<span>&#8358;</span>)</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($transactions as $transaction)
                  <tr>
                    <td>{{ $transaction->ref_id }}</td>
                    <td>{{ ucfirst($transaction->username) }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ $transaction->sender_phone }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->paying }}</td>
                    <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($transaction->created_at))->toFormattedDateString() }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>

                      <a href="{{ asset('storage/pop') }}/{{ $transaction->pop }}" class="text-green">
                        View POP
                      </a>
                      |
                      <a href="{{ url('admin/transactions/airtime') }}/{{ $transaction->ref_id }}" class="text-blue">
                        Approve
                      </a>
                      |
                      <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $transaction->ref_id }}').submit();" class="text-red">
                        Delete
                      </a>

                        <form id="delete{{ $transaction->ref_id }}" action="{{ url('admin/transactions/airtime') }}/{{ $transaction->ref_id }}" method="POST" style="display: none;">
                          {{ csrf_field() }}
                          {{ Method_field('DELETE') }}
                        </form>  
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
