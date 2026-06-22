@extends('admin.layout')

@section('title', 'Create Product')

@section('content')
    <div class="topline">
        <div>
            <h1>Create Product</h1>
            <p>Add a new item to your catalog.</p>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <form class="stack" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @include('admin.products.form', ['buttonText' => 'Create Product'])
            </form>
        </div>
    </section>
@endsection
