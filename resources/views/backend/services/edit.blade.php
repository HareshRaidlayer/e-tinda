@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Update your Service') }}</h1>
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

    <form class="" action="{{ route('service.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        id="choice_form">
        <div class="row gutters-5">
            <div class="col-lg-12">
                <input name="_method" type="hidden" value="POST">
                <input type="hidden" name="lang" value="{{ $lang }}">
                <input type="hidden" name="id" value="{{ $product->id }}">
                @csrf
                <input type="hidden" name="added_by" value="seller">
                <div class="card">
                    <ul class="nav nav-tabs nav-fill language-bar">
                        @foreach (get_all_active_language() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link text-reset @if ($language->code == $lang) active @endif py-3"
                                    href="{{ route('service.edit', ['id' => $product->id, 'lang' => $language->code]) }}">
                                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                        height="11" class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{ translate('Service Name') }} <i
                                    class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ translate('Service Name') }}" value="{{ $product['name'] }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{ translate('Set Point') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" name="earn_point"
                                    placeholder="{{ translate('enter set point') }}" value="{{ $product['earn_point'] }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Status') }}</label>
                            <div class="col-lg-8">
                                <select name="status" class=" form-control">
                                    <option value="1" <?php echo $product['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo $product['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mar-all text-right mb-2">
                            <button type="submit" name="button" value="publish"
                                class="btn btn-primary">{{ translate('Update Service') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('modal')
    <!-- Frequently Bought Product Select Modal -->
    @include('modals.product_select_modal')
@endsection

@section('script')
    <!-- Treeview js -->
    <script src="{{ static_asset('assets/js/hummingbird-treeview.js') }}"></script>
@endsection
