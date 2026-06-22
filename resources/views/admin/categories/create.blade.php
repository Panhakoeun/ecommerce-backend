@extends('admin.layout')

@section('title', 'Create Category')

@section('content')
    <div class="topline">
        <div>
            <h1>Create Category</h1>
            <p>Add a new category for your products.</p>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <form class="stack" method="POST" action="{{ route('admin.categories.store') }}">
                @include('admin.categories.form', ['buttonText' => 'Create Category'])
            </form>
        </div>
    </section>
@endsection
