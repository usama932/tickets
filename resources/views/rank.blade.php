@include('header')
<br>
<br>
<br>
<br>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
@endif
<table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
      <tr>
        <th>  Name </th>
        <th> Email </th>
        <th> Rank </th>
        <th> Number of Tokens  </th>
        <th> Curent Balance  </th>
       
      </tr>
    </thead>
    <tbody>
       @foreach($user as $users)
      
        <td> {{$users->name}}  </td>
       
        <td> {{ $users->email }}  </td>
        <td> Rank {{ $users->subscription_status }}  </td>
        <td> {{ $users->number_of_tokens }}  </td>
        <td> {{ $users->current_balance }}  </td>
       
       
          
      <tr>
      
      </tr>
      
      @endforeach
     
    </tbody>
  </table>
  
  