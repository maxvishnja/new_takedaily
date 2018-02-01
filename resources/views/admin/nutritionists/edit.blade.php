@extends('layouts.admin')

@section('page-stylesheet')
    <link rel="stylesheet" href="/admin/css/croppie.css" />
@endsection

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Kunde (#{{ $nutritionist->id }}</h3>
        </div>

        <div class="module-body">
            <div class="clear"></div>
            <hr/>
            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{  URL::action('Dashboard\NutritionistController@update', [ $nutritionist->id ]) }}"
                  enctype="multipart/form-data">


                <div class="control-group">
                    <label for="page_title" class="control-label">First Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="first_name"
                               value="{{ Request::old('first_name', ($nutritionist->first_name) ? $nutritionist->first_name : '' ) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Last Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="last_name"
                               value="{{ Request::old('last_name', ($nutritionist->last_name) ? $nutritionist->last_name : '' ) }}"
                               placeholder="Sidens undertitel"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Title</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="title"
                               value="{{ Request::old('last_name', ($nutritionist->title) ? $nutritionist->title : '' ) }}"
                               placeholder=""/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">E-mail</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="email"
                               value="{{ Request::old('email', ($nutritionist->email) ? $nutritionist->email : '' ) }}"
                               placeholder="E-mail"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">About</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="desc"
                               value="{{ Request::old('email', ($nutritionist->desc) ? $nutritionist->desc : '' ) }}"
                               placeholder="About"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Photo</label>
                    <input type="hidden" id="imagebase64" name="imagebase64">
                    <div class="controls">
                        @if(!empty($nutritionist->image))
                            <img src="/images/nutritionist/{!! $nutritionist->image !!}" class="img-thumbnail"><br/><br/>
                        @endif
                        <input type="file" class="form-control span8" id="upload" name="image" value="">
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Locale</label>
                    <div class="controls">
                        <select name="locale">
                            <option value="da" {{ ($nutritionist->locale == 'dk') ? 'selected="selected"' : '' }}>DK</option>
                            <option value="nl" {{ ($nutritionist->locale == 'nl') ? 'selected="selected"' : '' }}>NL</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Active</label>
                    <div class="controls">
                        <select name="active">
                            <option value="1" {{ ($nutritionist->active == '1') ? 'selected="selected"' : '' }}>Active</option>
                            <option value="0" {{ ($nutritionist->active == '0') ? 'selected="selected"' : '' }}>Not Active</option>
                        </select>
                    </div>
                </div>

                <div class="clear"></div>
                <div class="pull-right">
                    <button class="btn btn-info" type="submit"><i class="icon-pencil"></i>Update</button>
                </div>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="clear"></div>

            </form>
        </div>
    </div><!--/.module-->
@stop

@section('scripts')
    <script src="/js/admin/croppie.min.js"></script>
    <script>
        var $uploadCrop,
            $imgThumb = $('.img-thumbnail');

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    });
                    $imgThumb.addClass('ready');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $uploadCrop = $imgThumb.croppie({
            viewport: {
                width: 180,
                height: 180,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            },
            enforceBoundy: false
        });

        $('#upload').on('change', function () { readFile(this); });

        $('.btn-info').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'original'
            }).then(function (resp) {
                $('#imagebase64').val(resp);
                $('#form').submit();
            });
        });
    </script>
@endsection