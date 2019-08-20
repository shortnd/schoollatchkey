@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $parent->name }}
            </div>
            <div class="card-body">
                <h2>Children</h2>
                @if (!empty($parent_account->children))
                    @foreach($parent_account->children as $child)
                    <div>
                        {{ $child->first_name }}
                    </div>
                    @endforeach
                @else
                    <h3>No Children Attached to {{ $parent->name }}</h3>
                @endif
                <hr>
                <h2>Assign Children</h2>
                @if ($children)
                <ul>
                    @foreach ($children as $child)
                    <li class="mb-2">
                        {{ $child->first_name }}
                        @if (count($child->childParent) > 0)
                        <form action="{{ route('school:parents.child-detach', [$school, $parent, $child]) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button class="btn btn-danger" type="submit">Detach</button>
                        </form>
                        @else
                        <form action="{{ route('school:parents.child-attach', [$school, $parent, $child]) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button class="btn btn-primary" type="submit">Assign</button>
                        </form>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
@endsection

