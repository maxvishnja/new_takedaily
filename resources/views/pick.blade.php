@extends('layouts.app')

{{-- todo translate --}}

@section('pageClass', 'page-pick')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick.title'))

@section('content')
    <div class="container">
        <div class="col-md-8">
            <div class="row">
                @for($i = 1; $i<=10;$i++)
                    <div class="col-md-6">
                        <div class="vitamin-item">
                            <div class="vitamin-item-left">
                                <span class="icon pill-1a"></span>
                            </div>

                            <div class="vitamin-item-right">
                                <strong>Red-White 17-63K/20-1K</strong>
                                <p>Understøtter din generelle sundhed og hjælper til med at opretteholde kroppens
                                    naturlige balance.</p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="col-md-4">
            <aside>
                <div class="card">hej</div>
            </aside>
        </div>
    </div>
@endsection

@section('footer_scripts')

@endsection