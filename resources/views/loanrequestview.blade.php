@include('header')
<br>
<br>
<br>
<br>
<table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>Name</th>
        <th>Easypaisa AccountNumber</th>
        <th>Loan Amount</th>
        <th>Loan In Earning Amount</th>
        <th>Status</th>
        
        <th>Action</th>

        
      </tr>
    </thead>
    <tbody>
        @foreach ($loanRequests as $loanRequest)
      <tr>
        <td>
          <div class="d-flex align-items-center">
            
            <div class="ms-3">
              <p class="fw-bold mb-1">{{  $loanRequest->user->name}}</p>
              <p class="text-muted mb-0"></p>
            </div>
          </div>
        </td>
        <td>
          <p class="fw-normal mb-1">{{ $loanRequest->easypaisa_account_number }}</p>
          <p class="text-muted mb-0"></p>
        </td>
        <td>
            <p class="fw-normal mb-1">{{ $loanRequest->loan_amount }}</p>
        
        </td>
       
        <td>{{ $loanRequest->loan_in_earnings }}</td>
        <td> {{ $loanRequest->status }}</td>
        
        
        <td>
            <form action="{{ route('approveLoanRequest', $loanRequest->id) }}" method="POST">
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
  
  