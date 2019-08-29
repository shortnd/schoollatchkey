@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('school:children.update', [$school, $child]) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $child->first_name }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $child->last_name }}" class="form-control" required>
                    </div>
                </div>
            </div>
            <h3>Emergency Contact Info</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="emergency_contact_name">Contact Name</label>
                        <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ $child->emergency_contact_name }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emergency_contact_number">Contact Number</label>
                        <input type="tel" name="emergency_contact_number" id="emergency_contact_number" value="{{ $child->emergency_contact_number }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emergency_contact_relationship">Contact Relationship</label>
                        <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship" value="{{ $child->emergency_contact_relationship }}" class="form-control" value="{{ $child->emergency_contact_relationship }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url()->previous() }}" class="btn btn-warning">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection

