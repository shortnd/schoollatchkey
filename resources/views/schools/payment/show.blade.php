@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $child->fullName() }}</h2>
        @if ($child->past_due)
            <div class="alert alert-danger">
                Payment Past Due
            </div>
            <div class="card mb-3 text-danger">
                <div class="card-header">
                    Past Due
                </div>
                <div class="card-body">
                    @error('past_due_amount')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    Amount Due: ${{ $child->past_due }}
                    <br>
                    <form action="{{ route('school:children.pay-past-due', [$school, $child]) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="past_due_amount" class="col-md-4 text-right col-form-label">Payment Amount</label>
                            <div class="form-group col-md-6"><input type="number" name="past_due_amount" id="past_due_amount" class="form-control"></div>
                        </div>

                        @if ($child->payment_credit)
                        <div class="form-group">
                            <div class="offset-md-2">
                                <label for="payment_credit">
                                    Use Payment Credit
                                </label>
                                <input type="checkbox" name="payment_credit" id="payment_credit">
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if ($child->payment_credit)
            <div class="card mb-3">
                <div class="card-header">
                    Payment Credit
                </div>
                <div class="card-body">
                    Current credit - ${{ $child->payment_credit }}
                </div>
            </div>
        @endif
        <div class="card mb-3">
            <div class="card-header">
                Current Weeks Total Due
            </div>
            <div class="card-body">
                ${{ $child->current_week_total }}
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                Pay Total Amount
            </div>
            <div class="card-body">
                @error('total_amount')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                <form action="{{ route('school:children.pay-current-week', [$school, $child]) }}" method="post">
                    @csrf
                    @method("PATCH")

                    <div class="form-group row">
                        <label for="total_amount" class="col-md-4 text-right col-form-label">Total Amount</label>
                        <div class="col-md-6 form-group">
                            <input type="number" name="total_amount" id="total_amount" class="form-control" value="{{ $child->past_due ? 'disabled' : '' }}">
                        </div>
                    </div>

                    @if ($child->payment_credit)
                    <div class="form-group">
                        <div class="offset-md-2">
                            <label for="payment_credit">
                                Use Payment Credit
                            </label>
                            <input type="checkbox" name="payment_credit" id="payment_credit">
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary" {{ $child->past_due ? 'disabled' : '' }}>Submit Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

