@extends('layouts.app')

{{-- todo translate --}}

@section('pageClass', 'page-pick')

@section('mainClasses', 'm-b-50 m-t-50')

@section('title', trans('pick.title'))

@section('content')
    <div class="container" id="app">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6" v-for="vitamin in vitamins">
                    <div class="vitamin-item">
                        <div class="vitamin-item-action">
                            <a href="#" v-on:click="addVitamin(vitamin, $event)" v-show="!vitamin.isSelected"
                               class="button button--green button--circular">
                                <span class="icon icon-plus"></span> Vælg denne
                            </a>

                            <a href="#" v-on:click="removeVitamin(vitamin, $event)" v-show="vitamin.isSelected"
                               class="button button--green button--circular button--grey">
                                <span class="icon icon-cross-16"></span> Fravælg denne
                            </a>
                        </div>

                        <div class="vitamin-item-left">
                            <span class="icon pill-@{{ vitamin.code }}"></span>
                        </div>

                        <div class="vitamin-item-right">
                            <strong>@{{ vitamin.name }}</strong>
                            <p>@{{ vitamin.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <aside>
                <div class="card">
                    <div class="cart-selection" v-for="vitamin in selectedVitamins" style="display: table-row">
                        <div style="display: table-cell; padding: 5px">
                            <span class="icon pill-@{{ vitamin.code }}"></span>
                        </div>

                        <div style="display: table-cell; padding: 5px">
                            @{{ vitamin.name }}
                        </div>

                        <div style="display: table-cell; padding: 5px">
                            <a href="#" style="display: inline-block" v-on:click="removeVitamin(vitamin, $event)"><span
                                        class="icon icon-cross-16-gray"></span></a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                vitamins: [
                        @for($i = 1; $i<=10; $i++)
                    {
                        name: 'Demo',
                        code: '1a',
                        id: '{{ $i }}',
                        description: 'Understøtter din generelle sundhed og hjælper til med at opretteholde kroppens naturlige balance.',
                        isSelected: false
                    },
                    @endfor
                ]
            },
            computed: {
                selectedVitamins: function () {
                    return this.vitamins.filter(function (vitamin) {
                        return vitamin.isSelected;
                    });
                }
            },
            methods: {
                removeVitamin: function (vitamin, event) {
                    event.preventDefault();

                    vitamin.isSelected = false;
                },
                addVitamin: function (vitamin, event) {
                    event.preventDefault();

                    vitamin.isSelected = true;
                }
            }
        });
    </script>
@endsection