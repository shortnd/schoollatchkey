@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-3">{{ $child->fullName() }}</h2>

        <a href="{{ route('school:children.edit', [$school, $child]) }}" class="btn btn-success">Edit</a>
        <a href="{{ route('school:children.delete-page', [$school, $child]) }}" class="btn btn-danger">Delete</a>

        @if (count($parents) > 0)
            {{ json_encode($child->childParent) }}
        @endif

        @if ($child->emergency_contact_name)
        <div class="card">
            <div class="card-header">
                Emergency Contact Info
            </div>
            <div class="card-body">
                <h3>Contact Name: {{ $child->emergency_contact_name }}</h3>
                <h4>Contact Number: {{ $child->emergency_contact_number }}</h4>
                <h4>Contact Relationship: {{ $child->emergency_contact_relationship }}</h4>
            </div>
        </div>
        @endif

        @if ($child->childParent)
            @foreach ($child->childParent as $parent)
                <div class="card">
                    <div class="card-header">
                        {{ $parent->name }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

