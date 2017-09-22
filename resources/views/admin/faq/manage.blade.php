@extends('layouts.admin')

@section('content')
    <div class="module">
        <div class="module-head">
            @if( ! isset( $faq ) )
                <h3>Add FAQ</h3>
            @else
                <h3>Edit FAQ {{ $faq->id }}</h3>
            @endif
        </div>

        <div class="module-body">

            <form id="cms_manage_form" method="POST" class="form-horizontal row-fluid"
                  action="{{ isset( $faq ) ? URL::action('Dashboard\FaqController@update', [ $faq->id ]) : URL::action('Dashboard\FaqController@store') }}"
                  enctype="multipart/form-data">
                <div class="clear">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#main" data-toggle="tab">Indhold</a></li>
                        @if(isset($faq))
                            <li class=""><a href="#translations" data-toggle="tab">Oversættelser</a></li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="main">
                            <div class="control-group">
                                <label for="faq_question" class="control-label">Question</label>
                                <div class="controls">
                                    <input type="text" class="form-control span8" name="question" id="faq_question"
                                           value="{{ Request::old('question', isset($faq) ? $faq->question : '' ) }}"
                                           placeholder="Can I...?"/>
                                </div>
                            </div>

							<div class="control-group">
								<label for="faq_answer" class="control-label">Answer</label>
								<div class="controls">
									<textarea name="answer" class="form-control" style="width: 100%;" rows="10" id="faq_answer"
											  placeholder="">{!! Request::old('answer', isset($faq) ? $faq->answer : '' ) !!}</textarea>
								</div>
							</div>

                            <div class="control-group"></div> <!-- To fix :last-child bug -->
                        </div>

                        @if(isset($faq))
                            <div role="tabpanel" class="tab-pane" id="translations">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Language</th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($faq->translations as $translation)
                                        <tr>
                                            <td>{{ $translation->locale }}</td>
                                            <td>
                                                <a href="{{ URL::action('Dashboard\FaqTranslationController@edit', [ 'id' => $translation->id ]) }}"
                                                   class="btn btn-primary">Edit</a>
                                                <a href="{{ URL::action('Dashboard\FaqTranslationController@delete', [ 'id' => $translation->id ]) }}"
                                                   class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <a href="{{ URL::action('Dashboard\FaqTranslationController@create', ['faq' => $faq->id]) }}"
                                               class="btn btn-success">Add new translation</a>
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
                        <a href="{{ URL::action('Dashboard\FaqController@index') }}"
                           class="btn btn-default pull-right">Annuller</a>
                        <button type="submit" class="btn btn-primary btn-large pull-left">@if(isset($faq)) Save @else
                                Add @endif</button>
                    </div>
                </div>
                {{ csrf_field() }}

                @if(isset($faq))
                    {{ method_field('PUT') }}
                @endif
            </form>
        </div>
    </div><!--/.module-->
    @if( isset($faq) )
        <div>
            <form method="POST" action="{{ URL::action('Dashboard\FaqController@destroy', [ $faq->id ]) }}"
                  onsubmit="return confirm('Are you sure?');">
                <button type="submit" class="btn btn-link">Delete FAQ</button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </div>
    @endif
@stop