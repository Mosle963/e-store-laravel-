@extends('layouts.app')
@section('main')

<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
<div class="home-content">
    <div class="container">
        <h1 class="title">Welcome to E-store</h1>
        <p class="description">Here you can find all the information about the site.</p>
        <ul class="info-list">
            <li>Suppliers : A List of all suppliers</li>
            <li>Customers : A List of all customers</li>
            <li>Products : A List of all products with ability to add or edit </li>
            <li>Orders : A List of all products with ability to add or edit</li>
        </ul>
    </div>
</div>

@endsection