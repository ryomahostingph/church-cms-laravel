@extends('layouts.admin.layout')

@section('content')
    <div class="relative">
        <div class="flex flex-wrap lg:flex-row justify-between">
            <portal-target name="member_count"></portal-target>
            <!-- <div class="">
                    <h1 class="admin-h1">Members ( {{ $count }} )</h1>
                </div> -->
            <div class="w-full lg:w-2/4">
                <portal-target name="search"></portal-target>
                <portal-target name="memberfilter"></portal-target>
            </div>
            <div  class="relative flex items-center w-full lg:w-2/5 md:w-2/5 lg:justify-end">
                <div class="flex items-center" dusk="add-button">
                    <a href="{{ url('/admin/member/add/') }}"
                        class="no-underline text-white  px-4 mx-1 flex items-center custom-green py-1 justify-center rounded">
                        <span class="mx-1 text-sm font-semibold">Add</span>
                        <img src="{{ url('uploads/icons/plus.svg') }}" class="w-3 h-3">
                    </a>
                </div>
                <div class="">
                    <a href="{{ url('/admin/exportUsers/?' . $query . '&usergroup_id=5') }}" id="export-button"
                        class="no-underline text-white  px-4 mx-1 flex items-center custom-green py-1 rounded">
                        <span class="mx-1 text-sm font-semibold">Export</span>
                    </a>
                </div>
                <div class="">
                    <a href="{{ url('/admin/import') }}" id="import-button"
                        class="no-underline text-white px-4 mx-1 flex items-center custom-green py-1 rounded">
                        <span class="mx-1 text-sm font-semibold">Import</span>
                    </a>
                </div>
                 <div class="">
                    <a href="{{ url('/admin/membershipCard/create') }}" id="import-button" class="no-underline text-white  px-2 my-3 mx-1 flex items-center custom-green py-1">
                        <span class="text-xs font-semibold">Generate Membership Card</span>
                    </a> 
                </div>
            </div>
        </div>
        @include('partials.message')
        <member-list url="{{ url('/') }}" searchquery="{{ $query }}" letter="{{ $alphabet }}"
            type="{{ $type }}" location="{{ $location }}"></member-list>
        <search-filter url="{{ url('/') }}" searchquery="{{ $query }}"></search-filter>
    </div>
@endsection
