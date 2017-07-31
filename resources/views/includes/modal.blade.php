<div class="kn_1">
    <div class="knopikBut md-trigger" data-modal="modal-1">
        Button for share
    </div>
    <div class="knopikCont">
        {!! trans('general.popup.title') !!}
    </div>
</div>

<div class="md-modal md-effect-1" id="modal-1">
    <div class="md-content">
        <h3>{!! trans('general.popup.title') !!}</h3>
        <div class="md-text">
            <p>{!! trans('general.popup.text') !!}</p>
        </div>
        <div class="md-form">
            <div class="mb-btn">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#email" aria-controls="email" role="tab"
                                                              data-toggle="tab">Email</a></li>
                    <li role="presentation"><a href="#facebook" aria-controls="facebook" role="tab" data-toggle="tab">Facebook</a>
                    </li>
                    <li role="presentation"><a href="#twitter" aria-controls="twitter" role="tab" data-toggle="tab">Twitter</a>
                    </li>
                </ul>
            </div>
            <div class="md-body tab-content">
                <div role="tabpanel" class="tab-pane active" id="email">
                    <form method="POST" class="form-horizontal row-fluid"
                          action=""
                          enctype="multipart/form-data">
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" class="form-control" name="to" id="page_subtitle"
                                       placeholder="{!! trans('general.popup.form.to') !!}"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" class="form-control" name="from" id="page_subtitle"
                                       placeholder="{!! trans('general.popup.form.from') !!}"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <textarea class="form-control"
                                          name="form-message"/>{!! str_replace('{link}', \App\Apricot\Helpers\ShareLink::get(Auth::user()->id), nl2br(trans('general.popup.form.message'))) !!}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-info submit" type="submit"><i class='fa fa-envelope'
                                                                             aria-hidden='true'></i>
                            | {!! trans('general.popup.form.send') !!}</button>
                        {{ csrf_field() }}
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="facebook">

                    <div class="control-group">
                        <div class="controls">
                            <textarea class="form-control"
                                      placeholder="{!! trans('general.popup.form.facebook-message') !!}"
                                      name="form-message"/></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-5"><img src="{{ asset('images/popup.jpeg') }}"></div>
                                <div class="col-sm-7">{!! str_replace('{link}', \App\Apricot\Helpers\ShareLink::get(Auth::user()->id), nl2br(trans('general.popup.form.message'))) !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <button class="btn btn-info submit"><i class='fa fa-facebook' aria-hidden='true'></i>
                            | {!! trans('general.popup.form.share') !!}</button>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="twitter">
                    <div class="pull-right"><span class="twit-count">110</span>/110</div>
                    <div class="control-group">
                     <textarea class="form-control" id="twitters"
                               placeholder="{!! trans('general.popup.form.twitter-message') !!}" rows="5"
                               name="form-message"/></textarea>

                    </div>
                    <div class="control-group">
                        <button class="btn btn-info submit"><i class='fa fa-twitter' aria-hidden='true'></i>
                            | {!! trans('general.popup.form.twit') !!}</button>
                    </div>
                </div>
            </div>

        </div>
        <i class='fa fa-times md-close' aria-hidden='true'></i>
    </div>

</div>
<div class="md-overlay"></div><!-- the overlay element -->