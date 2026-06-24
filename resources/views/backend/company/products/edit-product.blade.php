@extends('layouts.company')

@section('title', 'Edit Product')
@section('page-title', 'Products')

@section('content')
@include('backend.company.products.product-form', ['mode' => 'Edit'])
@endsection
