@include('header')
<br>
<br>
<br>
<br>
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
        <th> Product Uploaded by </th>
        <th> User PhoneNumber</th>
        <th>Product Name</th>
        <th>Product Price</th>
        <th>Product Image</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach($pendingProducts as $product)
      <tr>
        <td>  {{ $product->user->name }} </td>
        <td>  {{ $product->user->phone }} </td>
        <td>
          <div class="d-flex align-items-center">
            
            <div class="ms-3">
               
              <p class="fw-bold mb-1">{{ $product->product_name  }}</p>
              <p class="text-muted mb-0">{{$product->product_description}}</p>
            </div>
          </div>
        </td>
        <td>
          <p class="fw-normal mb-1">{{ $product->product_price }}</p>
          <p class="text-muted mb-0"></p>
        </td>
        <td><img src="{{ $product->product_image }}" alt="Product Image" height="100"></td>
      
        <td>  {{ $product->status }} </td>
        <td>
            <form action="{{ route('approveProduct', ['id' => $product->id]) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Approve</button>
            </form>
        </td>
      
      </tr>
      
      
      @endforeach
    </tbody>
  </table>
  
  