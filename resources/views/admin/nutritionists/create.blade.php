@extends('layouts.admin')

@section('page-stylesheet')
    <link rel="stylesheet" href="/admin/css/croppie.css" />
@endsection

@section('content')
    <div class="module">
        <div class="module-head">
            <h3>Kunde</h3>
        </div>

        <div class="module-body">
         <div class="clear"></div>
            <hr/>
            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{  URL::action('Dashboard\NutritionistController@store') }}"
                  enctype="multipart/form-data">


                <div class="control-group">
                    <label for="page_title" class="control-label">First Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="first_name"
                               value="{{ Request::old('first_name') }}"
                               placeholder="First Name"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Last Name</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="last_name" id="page_subtitle"
                               value="{{ Request::old('last_name') }}"
                               placeholder="Last Name"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">E-mail</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="email"
                               value="{{ Request::old('email') }}"
                               placeholder="E-mail"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">About</label>
                    <div class="controls">
                        <input type="text" class="form-control span8" name="desc"
                               value="{{ Request::old('desc') }}"
                               placeholder="About"/>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Photo</label>
                    <input type="hidden" id="imagebase64" name="imagebase64">
                    <div class="controls">
                        <input type="file" class="form-control span8" id="upload" name="image" value="">
                        <div id="image_preview"></div>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Locale</label>
                    <div class="controls">
                        <select name="locale">
                            <option value="da" selected="selected">DK</option>
                            <option value="nl">NL</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="page_title" class="control-label">Active</label>
                    <div class="controls">
                        <select name="active">
                            <option value="1" selected="selected">Active</option>
                            <option value="0">Not Active</option>
                        </select>
                    </div>
                </div>

                   <div class="clear"></div>
                   <div class="pull-right">
                        <button class="btn btn-info"  type="submit"><i class="icon-pencil"></i>Create</button>
                   </div>
                   {{ csrf_field() }}
                   {{ method_field('POST') }}
                   <div class="clear"></div>

               </form>
           </div>
       </div><!--/.module-->
@stop

@section('scripts')
    <script src="/js/admin/croppie.min.js"></script>
    <script>
        var $uploadCrop,
            $imgPreview = $('#image_preview');

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    });
                    $imgPreview.addClass('ready');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $uploadCrop = $imgPreview.croppie({
            viewport: {
                width: 180,
                height: 180,
                type: 'circle'
            },
            boundary: {
                width: 180,
                height: 180
            }
        });

        $('#upload').on('change', function () {
            readFile(this);
        });

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