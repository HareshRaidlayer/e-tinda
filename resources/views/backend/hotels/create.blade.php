@extends('seller.layouts.app')

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Add New Hotel and Rooms') }}</h1>
            </div>
        </div>
    </div>
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('seller.hotels.store') }}" method="POST" enctype="multipart/form-data" id="hotel_room_form">
        @csrf
        <div class="main-row">
            <div class="row gutters-5">
                <div class="col-lg-12">
                    <input type="hidden" name="added_by" value="seller">
                    <!-- Hotel Information -->
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Hotel Name') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <input type="text" class="form-control" name="name" placeholder="{{ translate('Hotel Name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Category') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <select class="form-control aiz-selectpicker rounded-0" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="category_id" required>
                                        <option value="">{{ translate('Select Category') }}</option>
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Description') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <textarea class="form-control" name="description"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Address') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <input type="text" class="form-control" name="address" placeholder="{{ translate('Address') }}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Country') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <select class="form-control aiz-selectpicker rounded-0" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country" required>
                                        <option value="">{{ translate('Select your country') }}</option>
                                        @foreach (get_active_countries() as $key => $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>{{ translate('Region/State')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="state" required>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('City') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="city" required>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Hotel Image') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="image" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rooms Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Rooms') }}</h5>
                        </div>
                        <div class="card-body" id="roomsContainer">
                            <!-- Room template -->
                            <div class="room-row">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">{{ translate('Room Number') }}</label>
                                    <div class="col-lg-4 mb-2">
                                        <input type="text" class="form-control" name="rooms[0][room_number]" placeholder="{{ translate('Room Number') }}">
                                    </div>

                                    <label class="col-lg-2 col-form-label">{{ translate('Capacity') }}</label>
                                    <div class="col-lg-4 mb-2">
                                        <select class="form-control" name="rooms[0][capacity]">
                                            <option> Select Capacity</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>

                                    <label class="col-lg-2 col-form-label">{{ translate('Price') }}</label>
                                    <div class="col-lg-4 mb-2">
                                        <input type="number" class="form-control" name="rooms[0][price]" placeholder="{{ translate('Price') }}">
                                    </div>

                                    <label class="col-md-2 col-form-label">{{ translate('Room Images') }}</label>
                                    <div class="col-md-4">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="rooms[0][images]" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm"></div>
                                    </div>

                                    <label class="col-lg-2 col-form-label">{{ translate('Description') }}</label>
                                    <div class="col-lg-10 mb-2">
                                        <textarea class="form-control" name="rooms[0][description]" placeholder="{{ translate('Description') }}"></textarea>
                                    </div>
                                </div>
                                <!-- Remove Room Button -->
                                <div class="col-12 text-right mb-2">
                                    <button type="button" class="btn btn-danger remove-room-btn">{{ translate('Remove Room') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add More Rooms Button -->
                    <div class="card mt-4">
                        <div class="card-body text-right">
                            <button type="button" id="addRoomBtn" class="btn btn-success">{{ translate('Add Room') }}</button>
                            {{-- <div class="mar-all text-right mb-2"> --}}
                                <button type="submit" name="button" value="publish" class="ml-4 btn btn-primary">{{ translate('Submit') }}</button>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let roomCount = 0;
            const roomsContainer = document.getElementById('roomsContainer');
            const addRoomBtn = document.getElementById('addRoomBtn');

            // Add Room Button functionality
            addRoomBtn.addEventListener('click', function() {
                roomCount++;
                const roomTemplate = `
                    <div class="room-row">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">{{ translate('Room Number') }}</label>
                            <div class="col-lg-4 mb-2">
                                <input type="text" class="form-control" name="rooms[${roomCount}][room_number]" placeholder="{{ translate('Room Number') }}">
                            </div>
                            <label class="col-lg-2 col-form-label">{{ translate('Capacity') }}</label>
                            <div class="col-lg-4 mb-2">
                                <select class="form-control" name="rooms[${roomCount}][capacity]">
                                    <option> Select Capacity</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label">{{ translate('Price') }}</label>
                            <div class="col-lg-4 mb-2">
                                <input type="number" class="form-control" name="rooms[${roomCount}][price]" placeholder="{{ translate('Price') }}">
                            </div>
                            <label class="col-md-2 col-form-label">{{ translate('Room Images') }}</label>
                            <div class="col-md-4">
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="rooms[${roomCount}][images]" class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                            <label class="col-lg-2 col-form-label">{{ translate('Description') }}</label>
                                    <div class="col-lg-10 mb-2">
                                        <textarea class="form-control" name="rooms[${roomCount}][description]" placeholder="{{ translate('Description') }}"></textarea>
                                    </div>
                        </div>
                        <!-- Remove Room Button -->
                        <div class="col-12 text-right mb-2">
                            <button type="button" class="btn btn-danger remove-room-btn">{{ translate('Remove Room') }}</button>
                        </div>
                    </div>
                `;

                // Append the new room inputs to the rooms container
                roomsContainer.insertAdjacentHTML('beforeend', roomTemplate);
            });

            // Remove Room functionality
            roomsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-room-btn')) {
                    const roomRow = event.target.closest('.room-row');
                    roomRow.remove();
                }
            });
        });
    </script>
    <script type="text/javascript">

        $(document).on('change', '[name=country]', function() {
            var country_id = $(this).val();
            get_states(country_id);
        });

        $(document).on('change', '[name=state]', function() {
            var state_id = $(this).val();
            get_city(state_id);
        });

        function get_states(country_id) {
            $('[name="state"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get-state')}}",
                type: 'POST',
                data: {
                    country_id  : country_id
                },
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj != '') {
                        $('[name="state"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function get_city(state_id) {
            $('[name="city"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('get-city')}}",
                type: 'POST',
                data: {
                    state_id: state_id
                },
                success: function (response) {
                    var obj = JSON.parse(response);
                    if(obj != '') {
                        $('[name="city"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }
    </script>
@endsection
