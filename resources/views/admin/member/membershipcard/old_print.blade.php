@extends('layouts.admin.layout')

@section('content')
    <div class="relative">
        <div class="flex flex-wrap lg:flex-row justify-between">
            <h1 class="admin-h1 mb-5 flex items-center">
                    <a href="{{ url('/admin/members') }}" title="Back" class="rounded-full bg-gray-100 p-2">
                        <img src="{{ url('uploads/icons/back.svg') }}" class="w-3 h-3">
                    </a>
                <span class="mx-3">Print Membership Card</span>
            </h1>

            <div class="relative flex items-center w-1/4 lg:justify-end">
                <div class="flex items-center">
                    <a href="{{ url('/admin/member/print/'.$user->name) }}">        
                        <h2 class="bg-blue-500 text-white rounded px-3 py-1">Print</h2>
                    </a> 
                </div>
            </div>
        </div>
        @include('partials.message')
         <div style="width: 33.33%;padding: 10px;">
        <div style="margin-top: 10px;box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);border-radius: 8px;background: url('/images/card-bg-1.png');background-size: cover;background-position: center;background-repeat: no-repeat;">
            <div style="border-radius: 8px;"> <!-- background: #ffffff; -->

                <div class="flex items-center justify-between" style="text-align: center;padding:10px;border-top-left-radius:8px;border-top-right-radius:8px;"> <!--  background-color: #bee3f8; -->
                <h4 class="text-base mx-2" style="text-align: center;font-weight: 500;">{{ strtoupper($church->name) }}</h4> 
                    @if($church->churchDetailLogo['meta_value'] != '-')
                        <img src="{{ $church->churchLogo }}" style="height:35px;">
                    @endif
                </div>    
                <!-- <h2 class="text-sm" style="text-align: center;"><strong>Membership Card</strong></h2> -->
                <div>
                    <!-- ***start*** -->
                    <div>    
                        <!-- <p style="width:35%;padding-top: 10px;padding-bottom: 10px;"><strong>User Detail :</strong></p> -->
                        <div style="padding: 10px;">
                            <div style="display: flex;font-size: 11px;" class="visitor-log">
                                <p style="width:20%;"><span><img src="{{ $user->userprofile->AvatarPath }}" class="w-20 h-20"></span></p>
                                <div style="width: 80%;padding-left: 15px;">
                                    <div style="display: flex; align-items: center;" class="visitor-log">
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;color: #2d3748;"><b>Name </b></p>
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;"><span >{{ ucfirst($user->FullName) }}</span></p>
                                    </div>
                                    <div style="display: flex; align-items: center;" class="visitor-log">
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;color: #2d3748;"><b>Address </b></p>
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;"><span>{{ $user->userprofile->address }}</span></p>
                                    </div>
                                    <div style="display: flex; align-items: center;" class="visitor-log">
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;color: #2d3748;"><b>Contact Number</b></p>
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;"><span >{{ $user->mobile_no }}</span></p>
                                    </div>
                                    <div style="display: flex; align-items: center;" class="visitor-log">
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;color: #2d3748;"><b>Membership Date</b></p>
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;"><span >{{ date('d-m-Y',strtotime($user->userprofile->membership_start_date)) }}</span></p>
                                    </div>
                                    <div style="display: flex; align-items: center;" class="visitor-log">
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;color: #2d3748;"><b>Age</b></p>
                                        <p style="width:50%;padding-top: 4px;padding-bottom: 4px;"><span >{{ $user->userprofile->present()->getAge($user->userprofile->date_of_birth) }}</span></p>
                                    </div>
                                   <div>

     @php
$from = [255, 0, 0];
$to = [0, 0, 255];

                             $url=url('/admin/attandance/'.$user->name);
                                    @endphp

                                    {!! QrCode::size(100)
    ->style('dot')
    ->eye('circle')
    ->gradient($from[0], $from[1], $from[2], $to[0], $to[1], $to[2], 'diagonal')
    ->margin(1)
    ->generate($url) !!}  
                                </div>
                                </div> 
                            </div>     
                        </div>
                    </div>
                </div>
                <!-- ***end*** -->
            </div> 
        </div>
        </div>
    </div>
@endsection