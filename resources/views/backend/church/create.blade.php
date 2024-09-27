@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Add New Church') }}</h1>
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
    <form action="{{ route('church.store') }}" method="POST" enctype="multipart/form-data" id="choice_form">
        @csrf
        <div class="main-row">
            <div class="row gutters-5">
                <div class="col-lg-12">
                    <input type="hidden" name="lang" value="">
                    <input type="hidden" name="added_by" value="admin">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Church Name') }} <i
                                        class="las la-language text-danger"
                                        title="{{ translate('Translatable') }}"></i></label>
                                <div class="col-lg-9 mb-2">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ translate('Church Name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Email') }} <i
                                        class="las la-language text-danger"
                                        title="{{ translate('Translatable') }}"></i></label>
                                <div class="col-lg-9  mb-2">
                                    <input type="text" class="form-control" name="email"
                                        placeholder="{{ translate('Email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Phone Number') }} <i
                                        class="las la-language text-danger"
                                        title="{{ translate('Translatable') }}"></i></label>
                                <div class="col-lg-9  mb-2">
                                    <input type="text" class="form-control" name="phone_number"
                                        placeholder="{{ translate('Phone Number') }}">
                                    @error('Phone Number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Publish') }}</label>
                                <div class="col-md-9">
                                    <select name="status" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{ translate('Address') }} <i
                                        class="las la-language text-danger"
                                        title="{{ translate('Translatable') }}"></i></label>
                                <div class="col-lg-9  mb-2">
                                    <textarea class="form-control" name="address"></textarea>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Country') }}</label>
                                <div class="col-md-9">
                                    <select name="country" class="form-control">
                                        @foreach ($countrys as $country)
                                            <option value="{{ $country->code }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
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
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Thumbnail Image') }}
                                    <small>(300x300)</small></label>
                                <div class="col-md-9">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="thumbnail_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                    <small
                                        class="text-muted">{{ translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.') }}</small>
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
                                <label class="col-lg-3 col-form-label">{{ translate('Description') }} <i
                                        class="las la-language text-danger"
                                        title="{{ translate('Translatable') }}"></i></label>
                                <div class="col-lg-9">
                                    <textarea class="aiz-text-editor" name="description"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div id="branchFormContainer"></div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <div class="col-12">
                    <div class="mar-all text-right mb-2">
                        <button type="button" id="add_form"
                            class="btn btn-success">{{ translate('Add Church Branch') }}</button>
                        <button type="submit" name="button" value="publish"
                            class="btn btn-primary">{{ translate('Submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="d-none removeRow-data" id="moreFieldTemplate">
        <div class="aiz-titlebar mt-2 mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3">{{ translate('Add Church Branch') }}</h1>
                </div>
            </div>
        </div>
        <div class="row gutters-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="added_by" value="admin">
                        <input type="hidden" name="branches" value="branches">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Church Name') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9 mb-2">
                                <input type="text" class="form-control" name="branch_name[]"
                                    placeholder="{{ translate('Church Name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Email') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                                <input type="text" class="form-control" name="branch_email[]"
                                    placeholder="{{ translate('Email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Phone Number') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                                <input type="text" class="form-control" name="branch_phone_number[]"
                                    placeholder="{{ translate('Phone Number') }}">
                                @error('Phone Number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Publish') }}</label>
                            <div class="col-md-9">
                                <select name="branch_status[]" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">{{ translate('Address') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-lg-9  mb-2">
                                <textarea class="form-control" name="branch_address[]"></textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Country') }}</label>
                            <div class="col-md-9">
                                <select name="branch_country[]" class="form-control">
                                    @foreach ($countrys as $country)
                                        <option value="{{ $country->code }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mar-all text-right mb-2">
                                <button type="button"
                                    class="btn btn-danger remove_form">{{ translate('Remove Church Branch') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ static_asset('assets/js/hummingbird-treeview.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const addBranchBtn = document.getElementById('add_form');
    const branchFormContainer = document.getElementById('branchFormContainer');
    const branchTemplate = document.getElementById('moreFieldTemplate').innerHTML;
    let branchCount = 0;

    addBranchBtn.addEventListener('click', function() {
        branchCount++;

        // Create a new branch form
        const newBranchForm = document.createElement('div');
        newBranchForm.classList.add('branch-container'); // Adding a class to easily identify the container
        newBranchForm.innerHTML = branchTemplate;

        // Update the name attributes to include an index
        newBranchForm.querySelectorAll('input, textarea, select').forEach(element => {

        });

        // Add the new form to the container
        branchFormContainer.appendChild(newBranchForm);
    });

    // Event delegation for removing forms
    branchFormContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove_form')) {
            const branchContainer = event.target.closest('.branch-container');
            if (branchContainer) {
                branchContainer.remove(); // Ensure the correct container is removed
            }
        }
    });
});



        // $(document).ready(function() {
        //     $('#add_form').click(function() {
        //         let clonedField = $('#moreFieldTemplate').clone().removeClass('d-none');
        //         $(this).parents('#choice_form').find('.main-row').append(clonedField);
        //     });

        //     // remove more criteria
        //     $(document).on('click', '.remove_form', function() {
        //         $(this).closest('.removeRow-data').fadeOut(500, function() {
        //             $(this).remove();
        //         });
        //     });
        // });
    </script>
@endsection
