@extends('layouts.member')

@section('title', 'Welcome')

@section('content')

@php
    $profile = optional($user->userprofile);
    $firstname = $profile->firstname ?? $user->name;
@endphp

{{-- Welcome banner --}}
<div class="bg-indigo-600 rounded-2xl px-8 py-10 text-white mb-6 relative overflow-hidden">
    <div class="relative z-10">
        <p class="text-sm font-medium opacity-75 uppercase tracking-widest mb-1">Welcome back</p>
        <h1 class="text-3xl font-bold">{{ $firstname }}</h1>
        <span class="inline-flex items-center mt-3 px-3 py-1 rounded-full text-xs font-semibold bg-white bg-opacity-20 text-white">
            Guest Member
        </span>
    </div>
    {{-- decorative circles --}}
    <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white opacity-5"></div>
    <div class="absolute -right-4 -bottom-10 w-56 h-56 rounded-full bg-white opacity-5"></div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Profile summary --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Your Profile</h3>

        <div class="flex items-center space-x-4 mb-5">
            @if($profile->avatar)
                <img src="{{ $profile->AvatarPath }}"
                    class="w-16 h-16 rounded-full object-cover ring-4 ring-indigo-100">
            @else
                <div class="w-16 h-16 rounded-full bg-indigo-100 ring-4 ring-indigo-200 flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl font-bold text-indigo-600">
                        {{ strtoupper(substr($firstname, 0, 1)) }}
                    </span>
                </div>
            @endif
            <div>
                <p class="font-semibold text-gray-800">{{ $profile->firstname }} {{ $profile->lastname }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <dl class="divide-y divide-gray-50">
            @foreach([
                ['Mobile',       $user->mobile_no],
                ['Gender',       ucfirst($profile->gender ?? '')],
                ['Date of Birth',$profile->date_of_birth ? date('d M Y', strtotime($profile->date_of_birth)) : null],
            ] as [$label, $value])
            <div class="flex justify-between py-2.5">
                <dt class="text-xs text-gray-400 font-medium">{{ $label }}</dt>
                <dd class="text-sm text-gray-800 font-semibold">{{ $value ?: '—' }}</dd>
            </div>
            @endforeach
        </dl>
    </div>

    {{-- Church info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Church</h3>

        <div class="flex items-start space-x-3 mb-5">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800 capitalize">{{ optional($user->church)->name }}</p>
                <p class="text-sm text-gray-500 mt-0.5 leading-snug">{!! optional($user->church)->fulladdress() !!}</p>
            </div>
        </div>

        <dl class="divide-y divide-gray-50">
            @foreach([
                ['Membership Type', ucfirst($profile->membership_type ?? 'Guest')],
                ['Status',          ucfirst($profile->status ?? 'Active')],
            ] as [$label, $value])
            <div class="flex justify-between py-2.5">
                <dt class="text-xs text-gray-400 font-medium">{{ $label }}</dt>
                <dd class="text-sm text-gray-800 font-semibold">{{ $value ?: '—' }}</dd>
            </div>
            @endforeach
        </dl>
    </div>

    {{-- Church info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
         <div class="flex justify-between items-center mb-2">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide ">Id Card</h3>&nbsp; <a href="{{ url('/member/print/'.$user->name) }}"
   class="text-xs font-semibold text-white bg-blue-500 px-3 py-1 rounded cursor-pointer">
   Print
</a>
        </div>
            <div class="flex items-start space-x-3">
                <!-- Front Side -->
    <div class="card">
      <!-- Logo + QR Row -->
      <table style="width: 100%; padding-right: 0; padding-left: 0;">
        <tr style="padding-right:10px;">
          <td style="padding-right:10px;">

             @if($user->userprofile->AvatarPath)
          <img
            class="w-32 h-32 border-4 border-white"
            src="{{ $user->userprofile->AvatarPath}}"
            alt="Profile Picture" style="height: 120px; margin: 0"
          />
          @else
          <img
            class="w-32 h-32 border-4 border-white"
            src="{{ url('images/default-user.png') }}"
            alt="Profile Picture" style="height: 120px; margin: 0">

          @endif
            <!-- <img style="height: 120px; margin: 0" src="{{ url('images/logo.png') }}" /> -->
          </td>
         <td style="padding-right: 10px;">
        @if (Auth::user()->ChurchLogo['meta_value'] != '-')
                    <img src="{{ Auth::user()->ChurchLogoPath }}" style="height:55px;"  class="w-32 h-32 border-4 border-white" alt="Logo" style="height: 120px; margin: 0">
                
        @else
        <img src="{{ asset('images/church_cms_logo.jpg') }}" style="height:55px;"  class="w-32 h-32 border-4 border-white" alt="Logo" style="height: 120px; margin: 0">
        @endif
      </td>
          <td style="">

            @php
$from = [255, 0, 0];
$to = [0, 0, 255];

                             $url=url('/admin/attandance/'.$user->name);
                                    @endphp

            <img src="data:image/png;base64, {!! base64_encode(QrCode::eye('square')->format('png')
    ->eye('circle')
    ->color(0, 0, 0)  
    ->margin(1)
    ->generate($url)) !!} " class="" style="width: 120px; height: auto;margin-left:auto;">

             
         <!-- <div class="qr">
              <img
                src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=example.com"
                style="width: 120px; height: auto"
              />
            </div> -->
          </td>

        </tr>
      </table>

      <!-- Profile + Details Row -->
      <table style="width: 100%">
        <tr>
          <td style="padding-top: 10px; text-align: left">
            <p
              style="margin-bottom: 0em !important; margin-top: 0em !important"
            >
              <span style="font-weight: 600">NAME -</span> {{ strtoupper($user->FullName) }}
            </p>
          </td>
        </tr>
      </table>
      <table style="width: 100%">
        <tr>
          <td style="text-align: left">
            <p
              style="margin-top: 2px !important; margin-bottom: 0px !important"
            >
              <span style="font-weight: 600">ID NUMBER -</span>
               #{{ $user->id }}
            </p>
          </td>
          <td style="padding-left: 16px; vertical-align: top">
            <p
              style="
                font-weight: 500;
                margin-top: 5px !important;
                margin-bottom: 0px !important;
                font-size: 15px;
              "
            >
              <span style="font-weight: 600">PHONE -</span>
              <span style="margin-left: 3px; border-bottom: 1px solid black"
                >{{ $user->mobile_no }}</span
              >
            </p>
          </td>
        </tr>
      </table>
      <table style="width: 100%">
        <tr>
          <td style=" text-align: left">
            <p
              style="margin-bottom: 0em !important; margin-top: 2px !important"
            >
              <span style="font-weight: 600">ADDRESS -</span> <span style="font-size:10px;"> {{ strtoupper($user->userprofile->address) }},{{strtoupper($user->userprofile->city->name)}} {{strtoupper($user->userprofile->state->name)}} ,{{strtoupper($user->userprofile->country->name)}}</span>
            </p>
              <p
              style="margin-bottom: 0em !important; margin-top: 5px !important"
            >

            @php
            $currentYear = date('Y');
          $nextYear = date('Y', strtotime('+1 year'));

           $year=$currentYear . ' - ' . $nextYear;


            @endphp
              <span style="font-weight: 600">Year :</span> <span style="font-size:10px;">{{$year}}</span>
            </p>
          </td>
        </tr>
      </table>
      <!-- Website Row -->
    </div>

    </div>

</div>

@endsection
