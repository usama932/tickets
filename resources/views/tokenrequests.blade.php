@include('header')
<br>
<br>
<br>
<br>
<table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>Name</th>
        <th>Number of Tokens</th>
        <th>Total Price</th>
        <th>Payment Method</th>
        <th>Transaction Number</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($pendingRequests as $request)
      <tr>
        <td>
          <div class="d-flex align-items-center">
            
            <div class="ms-3">
              <p class="fw-bold mb-1">{{  $request->user->name  }}</p>
              <p class="text-muted mb-0">{{ $request->user->email }}</p>
            </div>
          </div>
        </td>
        <td>
          <p class="fw-normal mb-1">{{  $request->number_of_tokens }}</p>
          <p class="text-muted mb-0"></p>
        </td>
        <td>
            <p class="fw-normal mb-1">{{  $request->total_price}}</p>
        
        </td>
        <td>{{ $request->payment_method }}</td>
        <td> {{  $request->transaction_number }} </td>
        <td>  {{ $request->status }} </td>
        <td>
            <form action="{{ route('admin.activateTokenRequest', $request->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link btn-sm btn-rounded badge badge-success rounded-pill d-inline">
                    Approved
                  </button>
            </form>
        </td>
      
      </tr>
      
      
      @endforeach
    </tbody>
  </table>
  
  