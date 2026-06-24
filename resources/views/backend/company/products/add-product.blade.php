@extends('layouts.company')

@section('title', 'Add Product')
@section('page-title', 'Products')

@section('content')
@include('backend.company.products.product-form', ['mode' => 'Create'])
@endsection
