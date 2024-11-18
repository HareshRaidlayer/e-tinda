@extends('backend.layouts.app')

@section('content')
    <div class="col-lg-6  mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Profile') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('profile.update', Auth::user()->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="{{ translate('Name') }}" name="name"
                                value="{{ Auth::user()->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Email') }}</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" placeholder="{{ translate('Email') }}" name="email"
                                value="{{ Auth::user()->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Address') }}</label>
                        <div class="col-sm-9">
                            <input type="text" id="autocomplete-address" class="form-control"
                                placeholder="{{ translate('Address') }}" name="address"
                                value="{{ $address->address }}">
                        </div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="new_password">{{ translate('New Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="{{ translate('New Password') }}"
                                name="new_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label"
                            for="confirm_password">{{ translate('Confirm Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="{{ translate('Confirm Password') }}"
                                name="confirm_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Avatar') }}
                            <small>(90x90)</small></label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="avatar" class="selected-files"
                                    value="{{ Auth::user()->avatar_original }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&callback=initAutocomplete"
        async defer></script>

    <script>
        function initAutocomplete() {
            // Get the input element for the address field
            const input = document.getElementById("autocomplete-address");
            const autocomplete = new google.maps.places.Autocomplete(input);

            // Restrict the fields returned by the API
            autocomplete.setFields(["geometry", "formatted_address"]);

            // Add a listener for when the user selects a place
            autocomplete.addListener("place_changed", function() {
                const place = autocomplete.getPlace();

                // Check if the place has a geometry location
                if (place.geometry) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();
                    const formattedAddress = place.formatted_address;

                    // Populate the hidden input fields with latitude and longitude
                    document.getElementById("latitude").value = lat;
                    document.getElementById("longitude").value = lng;

                    // Log the details for debugging
                    console.log("Formatted Address: ", formattedAddress);
                    console.log("Latitude: ", lat);
                    console.log("Longitude: ", lng);
                } else {
                    alert("No details available for the input: '" + input.value + "'");
                }
            });
        }
    </script>
@endsection
