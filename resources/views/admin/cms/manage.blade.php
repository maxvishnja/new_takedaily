@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            @if( ! isset( $page ) )
                <h3>Opret ny side</h3>
            @else
                <h3>Rediger side: {{ $page->title }} (/{{ $page->url_identifier }})</h3>
            @endif
        </div>

        <div class="module-body">

            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{ isset( $page ) ? URL::action('Dashboard\PageController@update', [ $page->id ]) : URL::action('Dashboard\PageController@store') }}"
                  enctype="multipart/form-data">
                <div class="clear">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#main" data-toggle="tab">Indhold</a></li>
                        <li class=""><a href="#meta" data-toggle="tab">Meta</a></li>
                        @if(isset($page))
                            <li class=""><a href="#translations" data-toggle="tab">Oversættelser</a></li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="main">
                            @if( !isset($page) || (isset($page) && !$page->isLocked() ))
                                <div class="control-group">
                                    <label for="page_title" class="control-label">Sidens layout</label>
                                    <div class="controls">
                                        {{--<label style="display: inline-block; border: 1px solid #eee; border-radius: 4px; padding: 10px; margin-right: 10px;">--}}
                                            {{--<input type="radio" name="layout" id="page_layout" value="plain"--}}
                                                   {{--@if(Request::old('layout', isset($page) ? $page->layout : 'plain') == 'plain') checked="checked" @endif />--}}
                                            {{--<img src="{{ asset('admin/images/icons/icon-cms-layout-plain.png') }}"--}}
                                                 {{--alt="">--}}
                                        {{--</label>--}}

                                        <label style="display: inline-block; border: 1px solid #eee; border-radius: 4px; padding: 10px;">
                                            <input type="radio" name="layout" id="page_layout" value="header" checked="checked" />
                                            <img src="{{ asset('admin/images/icons/icon-cms-layout-header.png') }}"
                                                 alt="">
                                        </label>

                                        {{--<label style="display: inline-block; border: 1px solid #eee; border-radius: 4px; padding: 10px;">--}}
                                            {{--<input type="radio" name="layout" id="page_layout" value="empty"--}}
                                                   {{--@if(Request::old('layout', isset($page) ? $page->layout : 'plain') == 'empty') checked="checked" @endif />--}}
                                            {{--<img src="{{ asset('admin/images/icons/icon-cms-layout-empty.png') }}"--}}
                                                 {{--alt="">--}}
                                        {{--</label>--}}
                                    </div>
                                </div>

                                <div id="layout_header_only" class="control-group" style="display: block">
                                    <label for="page_title" class="control-label">Top billede</label>
                                    <div class="controls">
                                        <input type="file" name="top_image" id="top_image"
                                               accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control"/>
                                        <p class="help-block">Anbefalet størrelse: 1920x800 pixels</p>
                                        <p class="help-block">Tilføj et nyt billede for at skifte nuværende, ellers lad
                                            den feltet være tomt.</p>
                                        @if( isset($page) ? $page->top_image : '' != '')
                                            <img src="{{ isset($page) ? $page->top_image : '' }}" class="img-responsive"
                                                 alt="Meta image" width="480" height="200"
                                                 style="max-height: 200px; width: auto;"/>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="control-group">
                                <label for="page_title" class="control-label">Sidens titel</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="title" id="page_title"
                                           value="{{ Request::old('title', isset($page) ? $page->title : '' ) }}"
                                           placeholder="Sidens titel"/>
                                    @if(!isset($page) || (isset($page) && !$page->isLocked()))<p class="help-block">
                                        Sidens url bliver:
                                        / <input type="text" id="page_handle_preview" class="input form-control"
                                                 maxlength="50" value="{{ isset($page) ? $page->url_identifier : '' }}"
                                                 name="slug" @if(isset($page)) data-changed-manually="true" @endif/>
                                        @if(isset($page))
                                            <br/>
                                    <div class="checkbox">
                                        <label>
                                            <small>
                                                <input type="checkbox" name="add_rewrite" checked="checked" value="1"/>
                                                Opret omdirigering <em>hvis slug ændres</em>, for at evt. SEO ikke går
                                                tabt.
                                            </small>
                                        </label>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="page_title" class="control-label">Sidens undertitel</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="sub_title" id="page_subtitle"
                                           value="{{ Request::old('sub_title', isset($page) ? $page->sub_title : '' ) }}"
                                           placeholder="Sidens undertitel"/>
                                </div>
                            </div>

                            <!-- Page intro -->
                            <div class="control-group">
                                <label for="page_intro" class="control-label">Sidens intro</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="intro" id="page_intro"
                                           value="{{ Request::old('intro', isset($page) ? $page->intro : '' ) }}"
                                           placeholder="Sidens intro"/>
                                </div>
                            </div>

                            <!-- Block Body (About vitamin) -->
                            <div class="control-group">
                                <label for="body" class="control-label">Sidens indhold</label>
                                <div class="controls">
                                <textarea name="body" class="form-control" rows="10" id="body"
                                          placeholder="About">{!! Request::old('body', isset($page) ? $page->body : '' ) !!}</textarea>
                                </div>
                            </div>

                            <!-- Block Main Characteristics -->
                            <div class="control-group">
                                <label for="characteristics" class="control-label">Main Characteristics</label>
                                <div class="controls">
                                    <input type="text" class="form-control span3 char_title" name="char_title[]" placeholder="Title">
                                    <input type="text" class="form-control span6 characteristics" name="characteristics[]"
                                           value=""
                                           placeholder="Characteristics"/> <input type="text" class="form-control span2 char_icon" name="char_icon[]" placeholder="Icon"><br><br>

                                    <input type="text" class="form-control span3 char_title" name="char_title[]" placeholder="Title">
                                    <input type="text" class="form-control span6 characteristics" name="characteristics[]"
                                           value=""
                                           placeholder="Characteristics"/> <input type="text" class="form-control span2 char_icon" name="char_icon[]" placeholder="Icon"> <br><br>

                                    <input type="text" class="form-control span3 char_title" name="char_title[]" placeholder="Title">
                                    <input type="text" class="form-control span6 characteristics" name="characteristics[]"
                                           value=""
                                           placeholder="Characteristics"/> <input type="text" class="form-control span2 char_icon" name="char_icon[]" placeholder="Icon"> <br><br>

                                    <input type="text" class="form-control span3 char_title" name="char_title[]" placeholder="Title">
                                    <input type="text" class="form-control span6 characteristics" name="characteristics[]"
                                           value=""
                                           placeholder="Characteristics"/> <input type="text" class="form-control span2 char_icon" name="char_icon[]" placeholder="Icon">
                                </div>
                            </div>

                            <!-- Block Recommended daily intake -->
                            <div class="control-group">
                                <label for="page_title" class="control-label">Recommended daily intake</label>
                                <div class="controls">
                                    Kvinder og mænd <input type="text" name="daily_intake" class="form-control span1 daily_intake"> µg
                                    <br><br>
                                    Kvinder og mænd over 70 år <input type="text" name="daily_intake_over_70" class="form-control span1 daily_intake_over_70"> µg
                                </div>
                            </div>

                            <!-- Block Good Sources -->
                            <div class="control-group">
                                <label for="sources" class="control-label">Gode Kilder</label>
                                <div class="controls">
                                    <input type="text" class="form-control span3" name="sources_title[]" placeholder="Source title">
                                    <input type="text" class="form-control span6 sources" name="sources_desc[]"
                                           value=""
                                           placeholder="Sources description"/>
                                    <input type="text" class="form-control span2 sources_icon" name="sources_icon[]" placeholder="Icon"><br><br>

                                    <input type="text" class="form-control span3" name="sources_title[]" placeholder="Source title">
                                    <input type="text" class="form-control span6 sources" name="sources_desc[]"
                                           value=""
                                           placeholder="Sources description"/>
                                    <input type="text" class="form-control span2 sources_icon" name="sources_icon[]" placeholder="Icon"><br><br>
                                </div>
                            </div>

                            <!-- Block Banner 1 -->
                            <div id="layout_header_only2" class="control-group" style="display: block">
                                <label for="page_title" class="control-label">Banner image 1</label>
                                <div class="controls">
                                    <input type="file" name="banner1" id="banner1"
                                           accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control"/>
                                    <p class="help-block">Anbefalet størrelse: 1920x800 pixels</p>
                                    <p class="help-block">Tilføj et nyt billede for at skifte nuværende, ellers lad
                                        den feltet være tomt.</p>
                                    @if( isset($page) ? $page->banner : '' != '')
                                        <img src="{{ isset($page) ? $page->banner : '' }}" class="img-responsive"
                                             alt="Meta image" width="480" height="200"
                                             style="max-height: 200px; width: auto;"/>
                                    @endif
                                    <br>
                                    <label for="banner1__title">Headline</label>
                                    <input type="text" id="banner1__title" name="banner1__title">
                                    <br>
                                    <label for="banner1__subtitle">Sub title</label>
                                    <input type="text" id="banner1__subtitle" name="banner1__subtitle">
                                </div>
                            </div>

                            <!-- Block Customer Reviews -->
                            <div class="control-group">
                                <label for="page_review" class="control-label">Customer reviews</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8 page_review" name="review[]"
                                           value=""
                                           placeholder="Review"/> by <input type="text" class="form-control span3 author" name="author[]" placeholder="Author"><br><br>
                                    <input type="text" class="form-control span8 page_review" name="review[]"
                                           value=""
                                           placeholder="Review"/> by <input type="text" class="form-control span3 author" name="author[]" placeholder="Author"> <br><br>
                                    <input type="text" class="form-control span8 page_review page_review" name="review[]"
                                           value=""
                                           placeholder="Review"/> by <input type="text" class="form-control span3 author" name="author[]" placeholder="Author">
                                </div>
                            </div>

                            <!-- Block Banner 2 -->
                            <div id="layout_header_only" class="control-group" style="display: block">
                                <label for="page_title" class="control-label">Banner image 2</label>
                                <div class="controls">
                                    <input type="file" name="banner2" id="banner2"
                                           accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control"/>
                                    <p class="help-block">Anbefalet størrelse: 1920x800 pixels</p>
                                    <p class="help-block">Tilføj et nyt billede for at skifte nuværende, ellers lad
                                        den feltet være tomt.</p>
                                    @if( isset($page) ? $page->banner2 : '' != '')
                                        <img src="{{ isset($page) ? $page->banner2 : '' }}" class="img-responsive"
                                             alt="Meta image" width="480" height="200"
                                             style="max-height: 200px; width: auto;"/>
                                    @endif
                                    <br>
                                    <label for="banner2__title">Headline</label>
                                    <input type="text" id="banner2__title" name="banner2__title">
                                </div>
                            </div>

                            <div class="control-group"></div> <!-- To fix :last-child bug -->
                        </div>

                        <div role="tabpanel" class="tab-pane" id="meta">
                            <div class="control-group">
                                <label for="meta_title" class="control-label">Meta titel</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="meta_title" id="meta_title"
                                           value="{{ Request::old('meta_title', isset($page) ? $page->meta_title : '' ) }}"
                                           placeholder="Meta titel"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="meta_description" class="control-label">Meta beskrivelse</label>
                                <div class="controls">
                                    <textarea class="form-control span8" rows="4" name="meta_description"
                                              id="meta_description"
                                              placeholder="Meta beskrivelse">{{ Request::old('meta_description', isset($page) ? $page->meta_description : '' ) }}</textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="meta_image" class="control-label">Meta billede</label>
                                <div class="controls">
                                    <input type="file" name="meta_image" id="meta_image"
                                           accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control"/>
                                    @if( isset( $page ) && $page->meta_image )
                                        <p class="help-block">Tilføj et nyt billede for at skifte nuværende, ellers lad
                                            den feltet være tomt.</p>
                                        <img src="{{ $page->meta_image }}" class="img-responsive" alt="Meta image"
                                             width="1200" height="630"/>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group"></div> <!-- To fix :last-child bug -->
                        </div>

                        @if(isset($page))
                            <div role="tabpanel" class="tab-pane" id="translations">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Sprog</th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($page->translations as $translation)
                                        <tr>
                                            <td>{{ $translation->locale }}</td>
                                            <td>
                                                <a href="{{ URL::action('Dashboard\PageTranslationController@edit', [ 'id' => $translation->id ]) }}"
                                                   class="btn btn-primary">Rediger</a>
                                                <a href="{{ URL::action('Dashboard\PageTranslationController@delete', [ 'id' => $translation->id ]) }}"
                                                   class="btn btn-danger">Slet</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ URL::action('Dashboard\PageTranslationController@create', ['page' => $page->id]) }}"
                                               class="btn btn-success">Tilføj ny oversættelse</a>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <hr/>
                                <div class="control-group"></div> <!-- To fix :last-child bug -->
                            </div>
                        @endif
                    </div>

                </div>

                <div class="control-group">
                    <div class="controls clearfix">
                        <a href="{{ URL::action('Dashboard\PageController@index') }}"
                           class="btn btn-default pull-right">Annuller</a>
                        <button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($page)) Gem @else
                                Opret @endif</button>
                    </div>
                </div>
                {{ csrf_field() }}

                @if(isset($page))
                    {{ method_field('PUT') }}
                @endif
            </form>
        </div>
    </div><!--/.module-->
    @if( isset($page) && !$page->isLocked() )
        <div>
            <form method="POST" action="{{ URL::action('Dashboard\PageController@destroy', [ $page->id ]) }}"
                  onsubmit="return confirm('Er du sikker på at du slette denne side?');">
                <button type="submit" class="btn btn-link">Slet siden</button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </div>
    @endif
@stop

@section('scripts')
    <script>
		var handlePreviewInput = $("#page_handle_preview");

		@if( !isset($page) || (isset($page) && !$page->isLocked() ))
			$("#page_title").on('input', function () {
				if (!handlePreviewInput.data('changed-manually')) {
					generateSlug($(this).val());
				}
			});

			handlePreviewInput.on('input', function () {
				$(this).data('changed-manually', true);
			});

			function generateSlug(value) {
				var handle = value;
				handle = handle.trim(' ');
				handle = handle.toLowerCase();
				handle = handle.replace(/(å)/g, 'a');
				handle = handle.replace(/(ø)/g, 'o');
				handle = handle.replace(/(æ)/g, 'ae');
				handle = handle.replace(/\s\s+/g, ' ');
				handle = handle.replace(/( )/g, '-');
				handle = handle.replace(/([^a-z0-9-])/g, '');
				handle = handle.replace(/\-\-+/g, '-');
				handle = handle.substr(0, 50);

				handlePreviewInput.val(handle);
			}

			if (!handlePreviewInput.data('changed-manually')) {
				generateSlug($("#page_title").val());
			}
        @endif

        CKEDITOR.replace('body', {
            height: 300,
            language: "da",
            filebrowserImageUploadUrl: '/dashboard/upload/image'
        });

        CKEDITOR.replace('page_recommended_intake', {
            height: 300,
            language: "da",
            filebrowserImageUploadUrl: '/dashboard/upload/image'
        });

        CKEDITOR.replace('page_sources', {
            height: 300,
            language: "da",
            filebrowserImageUploadUrl: '/dashboard/upload/image'
        });

        $("#cms_manage_form").on('change', function () {
            $("#layout_header_only").css('display', $(this).find('input[name="layout"]:checked').val() == 'header' ? 'block' : 'none');
        });
    </script>

    <style>
        iframe.cke_wysiwyg_frame.cke_reset,
        span#cke_1_top.cke_top.cke_reset_all {
            width: 100%;
            max-width: 1140px;
            height: 100%;
            margin: 0 auto !important;
            display: block;
        }
    </style>
@endsection