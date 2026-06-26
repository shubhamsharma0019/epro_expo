@extends('layouts.company')

@section('title', 'Edit Product')
@section('page-title', 'Products')

@section('content')
@include('company.products.product-form', ['mode' => 'Edit'])
@endsection
