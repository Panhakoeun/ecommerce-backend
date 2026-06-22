@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
    <div class="topline">
        <div>
            <h1>Edit Category</h1>
            <p>Update category details.</p>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <form class="stack" method="POST" action="{{ route('admin.categories.update', $category) }}">
                @method('PUT')
                @include('admin.categories.form', ['buttonText' => 'Save Changes'])
            </form>
        </div>
    </section>
@endsection
