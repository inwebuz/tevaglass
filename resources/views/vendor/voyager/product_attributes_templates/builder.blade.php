@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #found-attributes {
            position: absolute;
            padding: 10px;
            border: 1px solid #aaa;
            background-color: #fff;
            top: 100%;
            width: 100%;
        }
        .found-attribute {
            cursor: pointer;
        }
        .found-attribute:hover {
            color: #39B0F2;
        }
        .selected-attribute {
            padding: 10px 15px;
            border: 1px solid #ccc;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
        }
        .selected-attribute .voyager-handle {
            margin-right: 5px;
            line-height: 1;
        }
        .selected-attribute .voyager-x {
            margin-left: auto;
            line-height: 1;
            display: inline-block;
            cursor: pointer;
            padding: 10px;
            color: red;
        }
    </style>
@stop

@section('page_title', 'Конструктор')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-categories"></i>
        Конструктор - {{ $productAttributesTemplate->name }}
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ route('voyager.product_attributes_templates.builder', $productAttributesTemplate->id) }}"
                            method="POST" enctype="multipart/form-data">

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">
                            <div class="form-group">
                                <h4>Добавить атрибут</h4>
                                <div class="row">
                                    <div class="col-sm-4 mb-10">
                                        <div class="position-relative d-flex align-items-center" id="search-attributes-input-parent">
                                            <input type="text" name="search-attributes" id="search-attributes-input" class="form-control" autocomplete="off">
                                            <i class="loading-icon voyager-refresh ml-5 animation-spin"></i>
                                            <div id="found-attributes" style="display: none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <h4 class="mb-20">Атрибуты</h4>
                                <div id="selected-attributes">
                                    @if ($productAttributesTemplate->body)
                                        @foreach ($productAttributesTemplate->body as $value)
                                            <div id="selected-attribute-{{ $value['id'] }}" class="selected-attribute" data-id="{{ $value['id'] }}">
                                                <i class="voyager-handle"></i>
                                                <span>{{ $value['name'] }}</span>
                                                <i class="voyager-x"></i>
                                                <input type="hidden" name="attributes[{{ $value['id'] }}][name]" value="{{ $value['name'] }}">
                                                <input type="hidden" name="attributes[{{ $value['id'] }}][order]" value="{{ $value['order'] }}">
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                                @error('attributes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        $(function () {

            let sortable;
            let selectedAttributes = $('#selected-attributes');
            let foundAttributes = $('#found-attributes');
            let searchAttributesInput = $('#search-attributes-input');
            let searchingAttribute = false;

            initSortable();

            searchAttributesInput.on('input', searchAttribute);

            searchAttributesInput.on('focus', function(){
                if (foundAttributes.find('.found-attribute').length) {
                    foundAttributes.show();
                } else {
                    searchAttribute();
                }
            });

            $('body').on('click', function(e){
                if (!$(e.target).closest('#found-attributes').length && !$(e.target).closest('#search-attributes-input').length) {
                    foundAttributes.hide();
                }
            })

            $('body').on('click', '.found-attribute', function(e){
                e.preventDefault();
                let id = $(this).data('id');
                if ($('#selected-attribute-' + id).length) {
                    return;
                }
                let name = $(this).data('name');
                let selectedAttributesQuantity = selectedAttributes.find('.selected-attribute').length;
                selectedAttributes.append(`
                    <div id="selected-attribute-${id}" class="selected-attribute" data-id="${id}">
                        <i class="voyager-handle"></i>
                        <span>${name}</span>
                        <i class="voyager-x"></i>
                        <input type="hidden" name="attributes[${id}][name]" value="${name}">
                        <input type="hidden" name="attributes[${id}][order]" value="${selectedAttributesQuantity}">
                    </div>
                `);
                foundAttributes.hide();
                initSortable();
            })

            $('body').on('click', '.selected-attribute .voyager-x', function(e){
                e.preventDefault();
                $(this).closest('.selected-attribute').remove();
                sortableUpdate();
            });

            async function searchAttribute() {
                if (searchingAttribute) {
                    return;
                }
                searchingAttribute = true;
                searchAttributesInput.parent().addClass('loading');
                let search = searchAttributesInput.val();
                if (search.length < 3) {
                    foundAttributes.empty();
                    foundAttributes.hide();
                    searchingAttribute = false;
                    searchAttributesInput.parent().removeClass('loading');
                    return false;
                }
                let attributes = await getAttributes(search);
                foundAttributes.empty();
                if (attributes.length) {
                    foundAttributes.show();
                } else {
                    foundAttributes.hide();
                }
                for (const i in attributes) {
                    if (Object.hasOwnProperty.call(attributes, i)) {
                        const attribute = attributes[i];
                        foundAttributes.append(`<div class="found-attribute" data-id="${attribute.id}" data-name="${attribute.name}">${attribute.name}</div>`);
                    }
                }
                searchingAttribute = false;
                searchAttributesInput.parent().removeClass('loading');
            }

            async function getAttributes(search) {
                return fetch('/api/attributes?search=' + search)
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            return [];
                        }
                    });
            }

            function initSortable() {
                sortable = Sortable.create(selectedAttributes[0], {
                    animation: 150,
                    ghostClass: 'bg-blue-light',
                    onSort: function (evt) {
                        sortableUpdate();
                    },
                });
            }

            function sortableUpdate() {
                $('.selected-attribute').each(function(index){
                    let id = $(this).data('id');
                    $(this).find('input[name="attributes[' + id + '][order]"]').val(index);
                });
            }

        });
    </script>
@stop
