(function($) {
    "use strict";
    var autocomplete;
    initialize();
    current_location(0);

    $(document).ready(function() {
        $('.current_location').on('click', function() {
            var id = $(this).attr('data-id');
            current_location(id);
        });
    });

    function initialize() {
        // Create the autocomplete object, restricting the search to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */
            (document.querySelector('.user_address')), {
                types: ['geocode']
            });

        google.maps.event.addDomListener(document.getElementById('user_address'), 'focus', geolocate);
        //when an address is selected from dropdown call the get_latitude_longitude function
        autocomplete.addListener('place_changed', get_latitude_longitude);
    }

    // get long and lat of the selected address in the auto-complete drop down
    function get_latitude_longitude() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        //  var key = $("#map_key").val();//alert(map_key);
        var key = "AIzaSyDeDLVAiaU13p2O0d3jfcPjscsbVsCQUzc";
        $.get('https://maps.googleapis.com/maps/api/geocode/json', { address: place.formatted_address, key: key }, function(data, status) {

            $(data.results).each(function(key, value) {
                $('#user_address').val(place.formatted_address);

                // Create Hidden for Latitude Input and attach it to the form
                let user_latitude = document.createElement("input");
                user_latitude.setAttribute("type", "hidden");
                user_latitude.setAttribute("name", "address_latitude");
                user_latitude.setAttribute("value", value.geometry.location.lat);
                document.getElementById("user_address").appendChild(user_latitude);

                // Create Hidden for Longitude Input and attach it to the form
                let user_longitude = document.createElement("input");
                user_longitude.setAttribute("type", "hidden");
                user_longitude.setAttribute("name", "address_longitude");
                user_longitude.setAttribute("value", value.geometry.location.lng);
                document.getElementById("user_address").appendChild(user_longitude);

                // $('#user_latitude').val(value.geometry.location.lat);
                // $('#user_longitude').val(value.geometry.location.lng);
                console.log(place.formatted_address);
                // console.log(value.geometry.location.lat);
                // console.log(value.geometry.location.lng);

            });
        });
    }

    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = new google.maps.LatLng(
                    position.coords.latitude, position.coords.longitude);
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }

    function current_location(session) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        function showPosition(position) {
            var user_address = $('#user_address_values').val();
            var user_latitude = $('#user_latitude_values').val();
            var user_longitude = $('#user_longitude_values').val();
            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function(results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[3]) {
                        if (session == 1) {
                            $('#user_address').val(results[3].formatted_address);
                            $('#user_latitude').val(position.coords.latitude);
                            $('#user_longitude').val(position.coords.longitude);
                        } else {
                            if (user_address == '' && user_latitude == '' && user_longitude == '') {
                                $('#user_address').val(results[3].formatted_address);
                                $('#user_latitude').val(position.coords.latitude);
                                $('#user_longitude').val(position.coords.longitude);
                            }
                        }
                    }
                }
            });
        }
    }


})(jQuery);
