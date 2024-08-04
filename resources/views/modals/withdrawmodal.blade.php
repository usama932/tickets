<div class="modal fade" tabindex="-1" id="deposit_modals">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deposit</h5>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"></span>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">
                <form action="{{ route('deposit.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" name="amount" id="amount" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method:</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value="">Select Payment Method</option>
                            <option value="bank">Bank</option>
                            <option value="mobile_bank">EasyPaisa Number (Till No:0310418)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="transaction_number">Transaction Number:</label>
                        <input type="text" name="transaction_number" id="transaction_number" class="form-control" required>
                    </div>
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Deposit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="loanRequestModal" tabindex="-1" aria-labelledby="loanRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loanRequestModalLabel">Request Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>You must have 25 tokens to avail the loan.</li>
                    <li>You should be in package status 3 or above.</li>
                </ul>
                <form id="loanRequestForm" action="{{ route('loan.request') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="easypaisaAccountNumber" class="form-label">Enter EasyPaisa Account Number</label>
                        <input type="text" class="form-control" id="easypaisaAccountNumber" name="easypaisaAccountNumber">
                        <label for="loanAmount" class="form-label">Enter Loan Amount</label>
                        <input type="text" class="form-control" id="loanAmount" name="loanamount">
                    </div>
                    
                    <div class="mb-3 form-check">
                       
                        <input type="checkbox" class="form-check-input" id="earningsCheckbox" name="earningsCheckbox">
                        <label class="form-check-label" for="earningsCheckbox">Loan in Earnings</label>
                        <div id="earningsFields" style="display: none;">
                            <label for="earningsLoanAmount" class="form-label">Enter Loan Amount</label>
                            <input type="text" class="form-control" id="earningsLoanAmount" name="loaninearningamount">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="loanRequestForm" class="btn btn-primary">Submit Request</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="buyTokensModal" tabindex="-1" aria-labelledby="buyTokensModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyTokensModalLabel">Buy Tokens</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to input number of tokens and select payment method -->
                <form action="{{ route('tokkenRequest') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="numberOfTokens" class="form-label">Number of Tokens</label>
                        <input type="number" class="form-control" id="numberOfTokens" name="numberOfTokens" required>
                    </div>
                    <div class="mb-3">
                        <label for="totalPrice" class="form-label">Total Price (The Price of 1 token is Rs 500)</label>
                        <input type="text" class="form-control" name="totalPrice" id="totalPrice" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method</label>
                        <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                            <option value="">Select Payment Method</option>
                            <option value="mobile_account">Mobile Account</option>
                            <option value="account_number">Bank Account</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transactionnumber" class="form-label">Transaction Number:</label>
                        <input type="text" class="form-control" id="transactionnumber" name="transactionnumber" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Buy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawModalLabel">Withdrawal Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('withdraws.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        @if(auth()->user()->subscription_status == 5)
                            $amount = auth()->user()->current_balance * 
                        @elseif(auth()->user()->subscription_status == 5)
                        @endif
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <input type="text" class="form-control" id="payment_method" name="payment_method"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>