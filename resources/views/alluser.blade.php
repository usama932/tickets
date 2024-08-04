@include('header')
<br>
<br>
<br>
<br>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>


@if (Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
@endif
<style>
    .filter_search {
        height: 40px;
        width: 368px;
        border-radius: 6px;
        padding: 8px 16px 8px 16px;
        padding-right: 48px;
        background: var(--white);
        border: 1px solid black;
        font-family: "Poppins";
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        color: var(--textblack);
        background-image: url(../images/icons/input-search-icon.svg);
        background-repeat: no-repeat;
        background-position: center right 16px;
        background-size: 24px;
    }

    [type=search] {
        outline-offset: -2px;
        -webkit-appearance: textfield;
    }
</style>
<div class="text-end mb-3">
    <input type="search" placeholder="Search" name="" id="filterSearch" class="filter_search ">
</div>

<table class="table align-middle mb-0 bg-white">
    <thead class="bg-light">
        <tr>
            <th> Name </th>
            <th>Referal code</th>
            <th> Email </th>
            <th>Rank</th>
            <th>Tokens</th>
            <th>Curent Balance</th>
            <th> Action </th>

        </tr>
    </thead>
    <tbody>
        @foreach ($user as $users)
            <tr class="user-row">
                <td> {{ $users->name }} </td>
                <td>{{ $users?->referral_code }}</td>
                <td> {{ $users->email }} </td>
                <td> Rank {{ $users->subscription_status }} </td>
                <td> {{ $users->number_of_tokens }}</td>
                <td> {{ $users->current_balance }}</td>
                <td> <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#editModal{{ $users->id }}">
                        Edit
                    </button>

                    <!-- Suspend button -->
                    @if ($users->status === 'active')
                        <form action="{{ route('suspendUser', ['id' => $users->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning"
                                onclick="return confirm('Are you sure you want to suspend this user?')">Suspend</button>
                        </form>
                    @else
                        <form action="{{ route('activateUser', ['id' => $users->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Are you sure you want to activate this user?')">Activate</button>
                        </form>
                    @endif

                    <!-- Delete button -->
                    <form action="{{ route('deleteUser', ['id' => $users->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to Delete this user?')">Delete</button>
                    </form>
                </td>

                </td>

            </tr>
        @endforeach
        <tr class="no-record-found text-center mt-3" style="display: none;font-size: 20px">
            <td colspan="7">No record found.</td>
        </tr>
    </tbody>
</table>

@foreach ($user as $users)
    <div class="modal fade" id="editModal{{ $users->id }}" tabindex="-1"
        aria-labelledby="editModalLabel{{ $users->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $users->id }}">Edit User: {{ $users->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('updateUser', ['id' => $users->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="number_of_tokens{{ $users->id }}" class="form-label">Number of
                                Tokens</label>
                            <input type="number" class="form-control" id="number_of_tokens{{ $users->id }}"
                                name="number_of_tokens" value="{{ $users->number_of_tokens }}">
                        </div>
                        <div class="mb-3">
                            <label for="current_balance{{ $users->id }}" class="form-label">Current Balance</label>
                            <input type="number" class="form-control" id="current_balance{{ $users->id }}"
                                name="current_balance" value="{{ $users->current_balance }}">
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
<script>
    $(document).ready(function() {
        $("#filterSearch").on("keyup", function() {
            var searchText = $(this).val().toLowerCase();
            var anyMatches = false;

            $(".user-row").each(function() {
                var referralCode = $(this).find("td:eq(1)").text().toLowerCase();

                if (referralCode.includes(searchText)) {
                    $(this).show();
                    anyMatches = true;
                } else {
                    $(this).hide();
                }
            });

            if (anyMatches) {
                $(".no-record-found").hide();
            } else {
                $(".no-record-found").show();
            }
        });
    });
</script>
