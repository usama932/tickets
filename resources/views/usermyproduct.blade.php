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
        <th> Product Name </th>
        <th> Product Image </th>
        <th>Product Price</th>
        <th> Action  </th>
       
      </tr>
    </thead>
    <tbody>
       @foreach($product as $products)
      
        <td> {{$products->product_name}}  </td>
        <td>
            <!-- Display the product image as a thumbnail with max width and height of 100 pixels -->
            <img src="{{ $products->product_image }}"  style="max-width: 100px; max-height: 100px;">
        </td>
        <td> {{ $products->product_price }}  </td>
       
        <td>
            <form action="{{ route('deleteProduct', ['id' => $products->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
            </form>
            <form action="{{ route('updateStatus', ['id' => $products->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-warning"> Out of Stock</button>
            </form>
        </td>
          
      <tr>
      
      </tr>
      
      @endforeach
     
    </tbody>
  </table>
  
  @foreach($product as $products)
<div class="modal fade" id="editModal{{$products->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$products->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$products->id}}">Edit User: {{$products->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('updateUser', ['id' => $products->id]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="number_of_tokens{{$products->id}}" class="form-label">Number of Tokens</label>
                        <input type="number" class="form-control" id="number_of_tokens{{$products->id}}" name="number_of_tokens" value="{{$products->number_of_tokens}}">
                    </div>
                    <div class="mb-3">
                        <label for="current_balance{{$products->id}}" class="form-label">Current Balance</label>
                        <input type="number" class="form-control" id="current_balance{{$products->id}}" name="current_balance" value="{{$products->current_balance}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
