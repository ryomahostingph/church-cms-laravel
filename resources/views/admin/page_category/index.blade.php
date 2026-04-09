@extends('layouts.admin.layout')

@section('content')
    <div class="relative">
        <div class="flex flex-wrap lg:flex-row justify-between">
            <div class="">
                <h1 class="admin-h1">Page Categories</h1>
            </div>
        </div>
        <div class="bg-white shadow my-3 p-4">
        @include('partials.message')
        <page-category-list url="{{ url('/') }}" mode="admin"></page-category-list>
        </div>
    </div>
@endsection
