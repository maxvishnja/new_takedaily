@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            @if( ! isset( $translation ) )
                <h3>New translation for: {{ $faq->question }}</h3>
            @else
                <h3>Edit translation ({{ $translation->locale }}) for: {{ $faq->question }}</h3>
            @endif
        </div>

        <div class="module-body">

            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{ isset( $translation ) ? URL::action('Dashboard\FaqTranslationController@update', [ $translation->id ]) : URL::action('Dashboard\FaqTranslationController@store') }}"
                  enctype="multipart/form-data">
                <div class="clear">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#main" data-toggle="tab">Content</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="main">
                            <div class="control-group">
                                <label for="page_locale" class="control-label">Language</label>
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
                                <label for="question" class="control-label">Question</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="question" id="question"
                                           value="{{ Request::old('question', isset($translation) ? $translation->question : '' ) }}"
                                           placeholder="Kan jeg..?"/>
                                </div>
                            </div>

                                <div class="control-group">
                                    <label for="answer" class="control-label">Answer</label>
                                    <div class="controls">
                                        <textarea name="answer" class="form-control" rows="10" id="answer"
                                                  placeholder="">{!! Request::old('answer', isset($translation) ? $translation->answer : '' ) !!}</textarea>
                                    </div>
                                </div>

                            <div class="control-group"></div> <!-- To fix :last-child bug -->
                        </div>

                    </div>

                </div>

                <div class="control-group">
                    <div class="controls clearfix">
                        <a href="{{ URL::action('Dashboard\FaqTranslationController@index') }}"
                           class="btn btn-default pull-right">Annuller</a>
                        <button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($translation)) Save @else
                                Add @endif</button>
                    </div>
                </div>
                {{ csrf_field() }}

                @if(isset($translation))
                    {{ method_field('PUT') }}
                @endif

                @if(!isset($translation))
                    <input type="hidden" name="faq_id" value="{{ $faq->id }}" />
                @endif
            </form>
        </div>
    </div><!--/.module-->
        <div>
            @if( isset($translation) )
                <form method="POST" action="{{ URL::action('Dashboard\FaqTranslationController@destroy', [ $translation->id ]) }}"
                      onsubmit="return confirm('Are you sure?');">
                    <button type="submit" class="btn btn-link">Delete?</button>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            @endif
        </div>
@stop