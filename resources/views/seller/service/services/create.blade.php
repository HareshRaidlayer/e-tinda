@extends('seller.layouts.app')

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Add your Service') }}</h1>
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

<form class="" action="{{ route('seller.service.store') }}" method="POST" enctype="multipart/form-data"
    id="choice_form">
    <div class="row gutters-5">
        <div class="col-lg-8">
            <input name="_method" type="hidden" value="POST">
            <input type="hidden" name="lang" value="">
            @csrf
            <input type="hidden" name="added_by" value="seller">
            <div class="card">

                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Service Name')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{translate('Service Name')}}" value=""
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Price')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                        <div class="col-lg-9">
                            <input type="number" class="form-control" name="price"
                                placeholder="{{ translate('Service price') }}"
                                value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Status')}}</label>
                        <select name="status" class="col-md-8 form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Service Warranty')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                        <div class="col-lg-9">
                            <input type="number" class="form-control" name="warranty"
                                placeholder="{{translate('Service Warranty(in a Month)')}}" value=""
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 control-label"
                            for="start_date">{{ translate('Discount Date Range') }} </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control aiz-date-range" name="date_range"
                                placeholder="{{ translate('Select Date') }}" data-time-picker="true"
                                data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Discount') }} <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="number" lang="en" min="0" value="0" step="0.01"
                                placeholder="{{ translate('Discount') }}" name="discount" class="form-control"
                                required>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control aiz-selectpicker" name="discount_type">
                                <option value="amount">{{ translate('Flat') }}</option>
                                <option value="percent">{{ translate('Percent') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Tags') }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control aiz-tag-input" name="tags[]"
                                placeholder="{{ translate('Type and hit enter to add a tag') }}">
                        </div>
                    </div> --}}

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Service Images')}}</h5>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="signinSrEmail">{{translate('Gallery Images')}}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photos" value=""
                                    class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}}
                            <small>(290x300)</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="thumbnail_img" value=""
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
                    <h5 class="mb-0 h6">{{translate('Service Videos')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Video Link')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="video_link" value=""
                                placeholder="{{ translate('Video Link') }}">
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Service Description')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Description')}} <i class="las la-language text-danger" title="{{translate('Translatable')}}"></i></label>
                        <div class="col-lg-9">
                            <textarea class="aiz-text-editor"
                                name="description">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('SEO Meta Tags')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Meta Title')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}"
                                placeholder="{{translate('Meta Title')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Description')}}</label>
                        <div class="col-lg-8">
                            <textarea name="meta_description" rows="8"
                                class="form-control">{{ $product->meta_description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Meta Images')}}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="meta_img" value="{{ $product->meta_img }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">{{translate('Slug')}}</label>
                        <div class="col-lg-8">
                            <input type="text" placeholder="{{translate('Slug')}}" id="slug" name="slug"
                                value="{{ $product->slug }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- Frequently Bought Products --}}

        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Service Category') }}</h5>
                </div>
                <div class="card-body ">
                    <div class="h-300px overflow-auto c-scrollbar-light">
                        <select name="category" class="form-control">
                            <option selected>Select category</option>
                            @foreach ($serviceCategory as $category)
                            <option value="{{$category['id']}}">{{$category['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Cash On Delivery')}}</h5>
                </div>
                <div class="card-body">
                    @if (get_setting('cash_payment') == '1')
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{translate('Status')}}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="cash_on_delivery" value="1"
                                            @if($product->cash_on_delivery == 1) checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <p>
                        {{ translate('Cash On Delivery activation is maintained by Admin.') }}
                    </p>
                    @endif
                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Estimate Shipping Time')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">
                            {{translate('Shipping Days')}}
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="est_shipping_days"
                                value="{{ $product->est_shipping_days }}" min="1" step="1" placeholder="{{translate('Shipping Days')}}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">{{translate('Days')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('VAT & Tax')}}</h5>
                </div>
                <div class="card-body">
                    @foreach(\App\Models\Tax::where('tax_status', 1)->get() as $tax)
                    <label for="name">
                        {{$tax->name}}
                        <input type="hidden" value="{{$tax->id}}" name="tax_id[]">
                    </label>

                    @php
                        $tax_amount = 0;
                        $tax_type = '';
                        foreach($tax->product_taxes as $row) {
                            if($product->id == $row->product_id) {
                                $tax_amount = $row->tax;
                                $tax_type = $row->tax_type;
                            }
                        }
                    @endphp

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="number" lang="en" min="0" value="{{ $tax_amount }}" step="0.01"
                                placeholder="{{ translate('Tax') }}" name="tax[]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control aiz-selectpicker" name="tax_type[]">
                                <option value="amount" @if($tax_type=='amount' ) selected @endif>
                                    {{translate('Flat')}}
                                </option>
                                <option value="percent" @if($tax_type=='percent' ) selected @endif>
                                    {{translate('Percent')}}
                                </option>
                            </select>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div> --}}
        </div>
        <div class="col-12">
            <div class="mar-all text-right mb-2">
                <button type="submit" name="button" value="publish"
                    class="btn btn-primary">{{ translate('Add Service') }}</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('modal')
	<!-- Frequently Bought Product Select Modal -->
    {{-- @include('modals.product_select_modal') --}}
@endsection

@section('script')

<!-- Treeview js -->
<script src="{{ static_asset('assets/js/hummingbird-treeview.js') }}"></script>


@endsection
