<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
             /* Set the size of the div element that contains the map */
            #map {
                height: 400px;
                /* The height is 400 pixels */
                width: 100%;
                /* The width is the width of the web page */
            }
            
        </style>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<style>
    .form-control-borderless {
    border: none;
}

.form-control-borderless:hover, .form-control-borderless:active, .form-control-borderless:focus {
    border: none;
    outline: none;
    box-shadow: none;
}
</style>
    </head>
    <body class="antialiased">
        <div class="container">
            <br/>
            <div class="row justify-content-center">
                                <div class="col-12 col-md-10 col-lg-8">
                                    <form class="card card-sm" method="GET" action="{{ url("") }}">
                                        @csrf
                                        <div class="card-body row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <i class="fas fa-search h4 text-body"></i>
                                            </div>
                                            <!--end of col-->
                                            <div class="col">
                                            <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Search topics or keywords" name="search" value="{{ request()->get("search") }}">
                                            </div>
                                            <!--end of col-->
                                            <div class="col-auto">
                                                <button class="btn btn-lg btn-success" type="submit">Search</button>
                                            </div>
                                            <!--end of col-->
                                        </div>
                                    </form>
                                </div>
                                <!--end of col-->
                            </div>
        </div>
        <div id="map" style="margin-top: 10px">

        </div>

        @if (count($histories) !== 0)
            <table class="table table-dark">
                <tbody>
                @foreach ($histories as $item)
                <tr>
                    <td>{{ $item->search }}</td>
                    <td>{{ $item->temp }}</td>
                    <td>{{ $item->created_at->format("Y-m-d H:i:s") }} </td>
                </tr>
                @endforeach
                </tbody>
            </table>
          @endif
    </body>
    @if($data)
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key={{ env("KEY_GOOGLE_MAPS") }}&callback=initMap"
      defer
    ></script>
    <script>
        let map;

        function initMap() {
            // The location of Uluru
            const uluru = { lat: {{ $data->location->lat }}, lng: {{ $data->location->long }} };
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 3,
                center: uluru,
            });

            marker = new google.maps.Marker({
                map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: uluru,
                title: '{{ $data->location->city }}',

            });
                
            infowindow = new google.maps.InfoWindow({
                content: "La ciudad de {{ $data->location->city }} temperatura es de {{ $data->current_observation->condition->temperature }}",
            });

            marker.addListener("click", toggleBounce);
        }

        function toggleBounce() {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }

            infowindow.open(map, marker);
        }
    
    </script>
@endif
</html> 
