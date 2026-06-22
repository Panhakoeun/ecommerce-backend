@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
    <div class="topline">
        <div>
            <h1>Edit Product</h1>
            <p>Update catalog details.</p>
        </div>
    </div>

    <section class="panel">
        <div class="panel-body">
            <form class="stack" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.products.form', ['buttonText' => 'Save Changes'])
            </form>
        </div>
    </section>
@endsection
