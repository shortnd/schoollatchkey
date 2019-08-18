@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $parent->name }}
            </div>
            <div class="card-body">
                <h2>Children</h2>
                {{-- @forelse ($collection as $item)

                @empty

                @endforelse --}}
                <hr>
                <h2>Assign Children</h2>
                @if ($children)
                <ul>
                    @foreach ($children as $child)
                    <li>{{ $child->first_name }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
@endsection

