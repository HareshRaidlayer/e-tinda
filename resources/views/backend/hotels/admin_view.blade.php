@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('View Hotel and Rooms') }}</h1>
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
    <form action="" method="POST" enctype="multipart/form-data" id="hotel_room_form">
        @csrf

        <div class="main-row">
            <div class="row gutters-5">
                <div class="col-lg-12">
                    <!-- Hotel Information -->
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Hotel Name') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <input type="text" class="form-control" name="name" value="{{ $hotel->name }}" placeholder="{{ translate('Hotel Name') }}" disabled>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Description') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <textarea class="form-control" name="description" disabled>{{ $hotel->description }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Address') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <input type="text" class="form-control" name="address" value="{{ $hotel->address }}" placeholder="{{ translate('Address') }}" disabled>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Country') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <select class="form-control aiz-selectpicker rounded-0" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country" disabled>
                                        <option value="">{{ translate('Select your country') }}</option>
                                        @foreach (get_active_countries() as $key => $country)
                                            <option value="{{ $country->id }}" <?php echo ($country->id == $hotel->country ? 'selected' : '');?>>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>{{ translate('Region/State')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="state" disabled>
                                        @foreach ($states as $state)
                                            <option value="{{$state['id']}}"  <?php echo ($state['id'] == $hotel->state ? 'selected' : '');?>>{{$state['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('City') }}</label>
                                <div class="col-lg-9 mb-2">
                                    <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="city" disabled>
                                        @foreach ($cities as $citie)
                                            <option value="{{ $citie['id'] }}" <?php echo ($citie['id'] == $hotel->city ? 'selected' : '');?>>{{$citie['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Other hotel fields go here -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Hotel Image') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        {{-- <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div> --}}
                                        <input type="hidden" name="image" value="{{ $hotel->image }}" class="selected-files" disabled>
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
                            <!-- Existing Rooms -->
                            @foreach ($hotel->rooms as $index => $room)
                                <div class="room-row">
                                    <input type="hidden" name="rooms[{{ $index }}][id]" value="{{ $room->id }}" disabled>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label">{{ translate('Room Number') }}</label>
                                        <div class="col-lg-4 mb-2">
                                            <input type="text" class="form-control" name="rooms[{{ $index }}][room_number]" value="{{ $room->room_number }}" placeholder="{{ translate('Room Number') }}" disabled>
                                        </div>
                                        <label class="col-lg-2 col-form-label">{{ translate('Capacity') }}</label>
                                        <div class="col-lg-4 mb-2">

                                            <select class="form-control" name="rooms[{{ $index }}][capacity]" disabled>
                                                <option> Select Capacity</option>
                                                <option value="1" <?php echo ($room->capacity == 1) ? 'selected' : '' ;?> >1</option>
                                                <option value="2" <?php echo ($room->capacity == 2) ? 'selected' : '' ;?>>2</option>
                                                <option value="3" <?php echo ($room->capacity == 3) ? 'selected' : '' ;?>>3</option>
                                                <option value="4" <?php echo ($room->capacity == 4) ? 'selected' : '' ;?>>4</option>
                                                <option value="5" <?php echo ($room->capacity == 5) ? 'selected' : '' ;?>>5</option>
                                                <option value="6" <?php echo ($room->capacity == 6) ? 'selected' : '' ;?>>6</option>
                                                <option value="7" <?php echo ($room->capacity == 7) ? 'selected' : '' ;?>>7</option>
                                                <option value="8" <?php echo ($room->capacity == 8) ? 'selected' : '' ;?>>8</option>
                                                <option value="9" <?php echo ($room->capacity == 9) ? 'selected' : '' ;?>>9</option>
                                                <option value="10" <?php echo ($room->capacity == 10) ? 'selected' : '' ;?>>10</option>
                                            </select>
                                        </div>
                                        <label class="col-lg-2 col-form-label">{{ translate('Price') }}</label>
                                        <div class="col-lg-4 mb-2">
                                            <input type="number" class="form-control" name="rooms[{{ $index }}][price]" value="{{ $room->price }}" placeholder="{{ translate('Price') }}" disabled>
                                        </div>
                                        <label class="col-md-2 col-form-label">{{ translate('Room Images') }}</label>
                                        <div class="col-md-4">
                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                {{-- <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}</div> --}}
                                                <input type="hidden" name="rooms[{{ $index }}][images]" value="{{ $room->images }}" class="selected-files" disabled>
                                            </div>
                                            <div class="file-preview box sm"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

@endsection

