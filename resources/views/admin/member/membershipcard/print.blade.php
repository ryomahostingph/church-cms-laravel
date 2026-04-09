<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ strtoupper($church->name) }}</title>
     <style>
      body {
        font-family: Arial, sans-serif;

        height: 100vh;
        gap: 40px;
      }

      .card {
    width: 400px;
    height: 260px;
    border-radius: 15px;
    /* background: url(
) no-repeat center / cover; */

        border-radius: 12px;
    overflow: hidden;
    padding: 15px 10px 2px 16px;
    color: #000;
    margin-left: auto;
   margin-right: auto;
}

      .company-name {
        font-size: 20px;
        font-weight: bold;
      }

      .slogan {
        font-size: 12px;
        color: #555;
      }

      .website {
        text-align: center;
        font-size: 13px;
        color: #2196f3;
      }
    </style>
  </head>
  <body>
    <div class="card" style="border: 1px solid #888 !important;">
      <!-- Logo + QR Row -->
      <table style="width: 100%; padding-right: 0; padding-left: 0;">
        <tr style="padding-right:10px;">
          <td style="padding-right:10px;">


             @php
              $toPdfImageSrc = function ($value) {
                if (! $value) {
                  return null;
                }

                if (strpos($value, 'data:') === 0) {
                  return $value;
                }

                $localPath = null;
                $isHttp = strpos($value, 'http://') === 0 || strpos($value, 'https://') === 0;

                if ($isHttp) {
                  $urlPath = parse_url($value, PHP_URL_PATH);
                  if ($urlPath) {
                    $candidate = public_path(ltrim($urlPath, '/'));
                    if (is_file($candidate) && is_readable($candidate)) {
                      $localPath = $candidate;
                    }
                  }
                }

                if (! $localPath) {
                  $trimmed = ltrim((string) $value, '/');
                  $candidates = [
                    public_path($trimmed),
                    storage_path('app/public/' . preg_replace('#^storage/#', '', $trimmed)),
                  ];

                  foreach ($candidates as $candidate) {
                    if (is_file($candidate) && is_readable($candidate)) {
                      $localPath = $candidate;
                      break;
                    }
                  }
                }

                if ($localPath) {
                  $ext = strtolower(pathinfo($localPath, PATHINFO_EXTENSION));

                  // DomPDF commonly fails on WEBP; convert it to PNG when GD supports it.
                  if ($ext === 'webp' && function_exists('imagecreatefromwebp')) {
                    $img = @imagecreatefromwebp($localPath);
                    if ($img !== false) {
                      ob_start();
                      imagepng($img);
                      $pngData = ob_get_clean();
                      imagedestroy($img);

                      if ($pngData !== false) {
                        return 'data:image/png;base64,' . base64_encode($pngData);
                      }
                    }
                  }

                  $mime = mime_content_type($localPath) ?: 'image/png';
                  return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($localPath));
                }

                return $value;
              };

              $avatarSource = $toPdfImageSrc(optional($user->userprofile)->AvatarPath)
                ?: $toPdfImageSrc(url('images/default-user.png'));

              $churchLogoPath = Auth::user()->ChurchLogo['meta_value'] != '-'
                ? Auth::user()->ChurchLogoPath
                : url('images/church_cms_logo.jpg');
              $churchLogoSource = $toPdfImageSrc($churchLogoPath);
            @endphp

             @if($avatarSource)
          <img
            class="w-32 h-32 border-4 border-white"
            src="{{ $avatarSource }}"
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

        <img src="{{ $churchLogoSource }}" style="height:55px;"  class="w-32 h-32 border-4 border-white" alt="Logo" style="height: 120px; margin: 0">


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

          <!--  <div class="qr">
              <img
                src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=example.com"
                style="width: 120px; height: auto"
              />
            </div> -->
          </td>
           @if($user->userprofile->membership_type=='guest')
          <td style="padding-right: 100px;"></td>
          @endif

        </tr>
      </table>

      <!-- Profile + Details Row -->
      <table style="width: 100%">
        <tr>
          <td style="padding-top: 5px; text-align: left">
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
     <table style="width: 100%;margin-top:0 px;">

       <tr>
          <td style=" text-align: left">
            <p
              style="margin-bottom: 0em !important; margin-top: 2px !important"
            >
              <span style="font-weight: 600">ADDRESS -</span> <span style="font-size:10px;"> {{ strtoupper($user->userprofile->address) }}, {{strtoupper($user->userprofile->city->name)}} {{strtoupper($user->userprofile->state->name)}} ,{{strtoupper($user->userprofile->country->name)}}</span>
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

  </body>
</html>

