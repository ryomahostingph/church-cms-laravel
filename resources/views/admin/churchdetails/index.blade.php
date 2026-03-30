@extends('layouts.admin.layout')
@section('content')
    <div class="flex items-center justify-between">
        <h1 class="admin-h1">Church Details</h1>
        <div class="flex">
            <div class="w-full ">
                <a href="{{ url('/admin/churchdetails/edit/' . \Auth::user()->church_id) }}"
                    class="no-underline text-white px-3 mx-1 flex items-center blue-bg py-1 justify-center text-xs rounded">
                    <span class="mx-1 text-sm font-semibold">Edit</span>
                </a>
            </div>
        </div>
    </div>
  @include('partials.message')
    <div class="flex my-3 flex-col lg:flex-row">
        <div class="bg-white shadow leading-loose px-4 w-full">
            <ul class="list-reset">
                <li class="flex pb-2 flex-col lg:flex-row md:flex-row py-3 items-center">
                    <p class="font-bold text-sm text-gray-800 capitalize w-full lg:w-1/4 md:w-1/3">Church Name</p>
                    <p class="font-bold text-lg text-black capitalize flex items-center w-full lg:w-1/2 md:w-2/3">
                        {{ $church_name }}</p>
                </li>
                @foreach ($churchdetails as $key => $value)
                    <li class="flex pb-2 flex-col lg:flex-row md:flex-row py-3 items-center">
                        <p class="font-bold text-sm text-gray-800 capitalize w-full lg:w-1/4 md:w-1/3">
                            {{ str_replace('_', ' ', ucwords($key)) }}</p>
                        <p class="font-medium text-sm text-black capitalize flex items-center w-full lg:w-1/2 lg:w-2/3">
                            @if ($key == 'facebook' || $key == 'twitter' || $key == 'instagram' || $key == 'website')
                                @if ($value->meta_value != null && $value->meta_value != '-')
                                    <a href="{{ $value->meta_value }}" target="_blank"><u>view</u></a>
                                @else
                                    NULL
                                @endif
                            @elseif($key != 'church_logo')
                                @if ($value->meta_value != null && $value->meta_value != '-')
                                    {{ $value->meta_value }}
                                @else
                                    NULL
                                @endif
                            @else
                                @if ($value->meta_value != null && $value->meta_value != '-')
                                    <img src="{{ $value->LogoPath }}" class="img-responsive w-32">
                                @else
                                    NULL
                                @endif
                            @endif
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
