@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Update your Church') }}</h1>
            </div>
        </div>
    </div>

    <!-- Error Meassages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="" action="{{ route('church.update', $church->id) }}" method="POST" enctype="multipart/form-data"
        id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-12">
                <input type="hidden" name="lang" value="">
                <input type="hidden" name="id" value="{{ $church->id }}">
                @csrf
                <input type="hidden" name="added_by" value="{{ $church->added_by }}">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{ translate('Church Name') }} <i
                                    class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ translate('Church Name') }}" value="{{ $church['name'] }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Email') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                                <input type="text" class="form-control" name="email"
                                    placeholder="{{ translate('Email') }}" value="{{ $church['email'] }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Bank Account Number') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                                <input type="text" class="form-control" name="bank_account_number"
                                    placeholder="{{ translate('Bank Account Number') }}" value="{{ $church['bank_account_number'] }}">
                                @error('bank_account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Bank Routing Number') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                                <input type="text" class="form-control" name="bank_routing_number"
                                    placeholder="{{ translate('Bank Routing Number') }}" value="{{ $church['bank_routing_number'] }}">
                                @error('bank_routing_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Bank Name') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                                <input type="text" class="form-control" name="bank_name"
                                    placeholder="{{ translate('Bank Name') }}" value="{{ $church['bank_name'] }}">
                                @error('bank_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Publish') }}</label>
                            <div class="col-md-9">
                                <select name="status" class="form-control">
                                    <option value="1" <?php echo $church['status'] == 1 ? 'selected' : ''; ?>>Yes</option>
                                    <option value="0"<?php echo $church['status'] == 0 ? 'selected' : ''; ?>>No</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Address') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                               <textarea class="form-control" name="address">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Church Images') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Thumbnail Image') }}
                                <small>(290x300)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="thumbnail_img" value="{{ $church->thumbnail_img }}"
                                        class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Church Description') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{ translate('Description') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9">
                                <textarea class="aiz-text-editor" name="description"> {{ $church['description'] }}
                            </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="mar-all text-right mb-2">
                <button type="submit" name="button" value="publish"
                    class="btn btn-primary">{{ translate('Update Church') }}</button>
            </div>
        </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ static_asset('assets/js/hummingbird-treeview.js') }}"></script>
@endsection
