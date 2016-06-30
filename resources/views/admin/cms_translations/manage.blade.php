@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            @if( ! isset( $translation ) )
                <h3>Opret ny oversættelse for side: {{ $page->title }} (/{{ $page->url_identifier }})</h3>
            @else
                <h3>Rediger oversættelse ({{ $translation->locale }}) for side: {{ $translation->page->title }} (/{{ $translation->page->url_identifier }})</h3>
            @endif
        </div>

        <div class="module-body">

            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{ isset( $translation ) ? URL::action('Dashboard\PageTranslationController@update', [ $translation->id ]) : URL::action('Dashboard\PageTranslationController@store') }}"
                  enctype="multipart/form-data">
                <div class="clear">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#main" data-toggle="tab">Indhold</a></li>
                        <li class=""><a href="#meta" data-toggle="tab">Meta</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="main">
                            <div class="control-group">
                                <label for="page_locale" class="control-label">Sprog</label>
                                <div class="controls">
                                    <select name="locale" id="page_locale" class="form-control span8">
                                        {{--<option @if((isset($translation) ? $translation->locale : '') == 'da') selected="selected" @endif value="da">Dansk</option>--}}
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'en') selected="selected" @endif value="en">Engelsk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'sv') selected="selected" @endif value="sv">Svensk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'no') selected="selected" @endif value="no">Norsk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'de') selected="selected" @endif value="de">Tysk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'es') selected="selected" @endif value="es">Spansk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'nl') selected="selected" @endif value="nl">Hollandsk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'fi') selected="selected" @endif value="fi">Finsk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'fr') selected="selected" @endif value="fr">Fransk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'tr') selected="selected" @endif value="tr">Tyrkisk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'is') selected="selected" @endif value="is">Islandsk</option>
                                        <option @if((isset($translation) ? $translation->locale : old('locale', '')) == 'it') selected="selected" @endif value="it">Italiensk</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="page_title" class="control-label">Sidens titel</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="title" id="page_title"
                                           value="{{ Request::old('title', isset($translation) ? $translation->title : '' ) }}"
                                           placeholder="Sidens titel"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="page_title" class="control-label">Sidens undertitel</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="sub_title" id="page_subtitle"
                                           value="{{ Request::old('sub_title', isset($translation) ? $translation->sub_title : '' ) }}"
                                           placeholder="Sidens undertitel"/>
                                </div>
                            </div>

                                <div class="control-group">
                                    <label for="page_body" class="control-label">Sidens indhold</label>
                                    <div class="controls">
                                        <textarea name="body" class="form-control" rows="10" id="page_body"
                                                  placeholder="Indhold...">{!! Request::old('body', isset($translation) ? $translation->body : '' ) !!}</textarea>
                                    </div>
                                </div>

                            <div class="control-group"></div> <!-- To fix :last-child bug -->
                        </div>

                        <div role="tabpanel" class="tab-pane" id="meta">
                            <div class="control-group">
                                <label for="meta_title" class="control-label">Meta titel</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="meta_title" id="meta_title"
                                           value="{{ Request::old('meta_title', isset($translation) ? $translation->meta_title : '' ) }}"
                                           placeholder="Meta titel"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="meta_description" class="control-label">Meta beskrivelse</label>
                                <div class="controls">
                                    <textarea class="form-control span8" rows="4" name="meta_description"
                                              id="meta_description"
                                              placeholder="Meta beskrivelse">{{ Request::old('meta_description', isset($translation) ? $translation->meta_description : '' ) }}</textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="meta_image" class="control-label">Meta billede</label>
                                <div class="controls">
                                    <input type="file" name="meta_image" id="meta_image"
                                           accept="image/jpeg,image/jpg,image/png,image/gif" class="form-control"/>
                                    @if( isset( $translation ) && $translation->meta_image )
                                        <p class="help-block">Tilføj et nyt billede for at skifte nuværende, ellers lad
                                            den feltet være tomt.</p>
                                        <img src="{{ $translation->meta_image }}" class="img-responsive" alt="Meta image"
                                             width="1200" height="630"/>
                                    @endif
                                </div>
                            </div>

                            <div class="control-group"></div> <!-- To fix :last-child bug -->
                        </div>
                    </div>

                </div>

                <div class="control-group">
                    <div class="controls clearfix">
                        <a href="{{ URL::action('Dashboard\PageTranslationController@index') }}"
                           class="btn btn-default pull-right">Annuller</a>
                        <button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($translation)) Gem @else
                                Opret @endif</button>
                    </div>
                </div>
                {{ csrf_field() }}

                @if(isset($translation))
                    {{ method_field('PUT') }}
                @endif

                @if(!isset($translation))
                    <input type="hidden" name="page_id" value="{{ $page->id }}" />
                @endif
            </form>
        </div>
    </div><!--/.module-->
        <div>
            @if( isset($translation) )
                <form method="POST" action="{{ URL::action('Dashboard\PageTranslationController@destroy', [ $translation->id ]) }}"
                      onsubmit="return confirm('Er du sikker på at du slette denne oversættelse?');">
                    <button type="submit" class="btn btn-link">Slet oversættelse</button>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            @endif
        </div>
@stop

@section('scripts')
    <script>
        CKEDITOR.replace('page_body', {
            height: 300,
            language: "da",
            filebrowserImageUploadUrl: '/dashboard/upload/image'
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