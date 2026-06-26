@extends('layouts.company')

@section('title', 'Add Product')
@section('page-title', 'Products')

@section('content')
@include('company.products.product-form', ['mode' => 'Create'])
@endsection
