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
        }
        .selected-attribute-header {
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

@section('page_title', 'Атрибуты товара')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-categories"></i>
        Атрибуты товара - {{ $product->name }}
    </h1>
@stop

@section('content')
    <div class="container-fluid" style="margin-bottom: 20px;">
        <a href="{{ route('voyager.products.edit', $product->id) }}" class="btn btn-sm btn-info m-5">
            <i class="voyager-angle-left"></i>
            <span class="hidden-xs hidden-sm">Продукт</span>
        </a>
    </div>

    <div class="page-content edit-add container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ route('voyager.products.attributes.update', $product->id) }}"
                            method="POST" enctype="multipart/form-data">

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            <div class="form-group">

                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 mb-10">
                                        <h4>Добавить атрибут</h4>
                                        <div class="position-relative d-flex align-items-center" id="search-attributes-input-parent">
                                            <input type="text" name="search-attributes" id="search-attributes-input" class="form-control" autocomplete="off">
                                            <i class="loading-icon voyager-refresh ml-5 animation-spin"></i>
                                            <div id="found-attributes" style="display: none"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 mb-10">
                                        <h4>Шаблон атрибутов</h4>
                                        <div class="position-relative d-flex align-items-center">
                                            <select name="templates" id="product-attributes-template-select" class="form-control select2">
                                                <option value="">-</option>
                                                @foreach ($productAttributesTemplates as $productAttributesTemplate)
                                                    <option value="{{ $productAttributesTemplate->id }}">{{ $productAttributesTemplate->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" id="product-attributes-template-btn" class="btn btn-primary m-0">Применить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <h4 class="mb-20">Атрибуты</h4>
                                <div id="selected-attributes">
                                    @foreach($attributes as $attribute)
                                        <div id="selected-attribute-{{ $attribute->id }}" class="selected-attribute" data-id="{{ $attribute->id }}">
                                            <div class="selected-attribute-header">
                                                <i class="voyager-handle"></i>
                                                <span>{{ $attribute->name }}</span>
                                                <i class="voyager-x"></i>
                                            </div>
                                            <div>
                                                <select name="attributes[{{ $attribute->id }}][values][]" class="form-control select2" multiple>
                                                    @foreach($attribute->attributeValues as $attributeValue)
                                                        <option value="{{ $attributeValue->id }}" @if(in_array($attributeValue->id, $productAttributeValueIds)) selected @endif>{{ $attributeValue->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" name="attributes[{{ $attribute->id }}][order]" value="{{ $attribute->pivot->order }}">
                                        </div>
                                    @endforeach
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
            let productAttributesTemplateSelect = $('#product-attributes-template-select');
            let productAttributesTemplateBtn = $('#product-attributes-template-btn');

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
                        <div class="selected-attribute-header">
                            <i class="voyager-handle"></i>
                            <span>${name}</span>
                            <i class="voyager-x"></i>
                        </div>
                        <div>
                            <select name="attributes[${id}][values][]" class="form-control select2" multiple></select>
                        </div>
                        <input type="hidden" name="attributes[${id}][order]" value="${selectedAttributesQuantity}">
                    </div>
                `);
                foundAttributes.hide();

                getAttributeValues(id)
                    .then(values => {
                        for (let value of values) {
                            $('[name="attributes[' + id + '][values][]"]').append(`
                                <option value="${value.id}">${value.name}</option>
                            `);
                        }
                        initSelects();
                    });

                initSortable();
            })

            $('body').on('click', '.selected-attribute .voyager-x', function(e){
                e.preventDefault();
                $(this).closest('.selected-attribute').remove();
                sortableUpdate();
            });

            productAttributesTemplateBtn.on('click', async function(e){
                e.preventDefault();
                let productAttributesTemplateId = productAttributesTemplateSelect.val();
                if (!productAttributesTemplateId) {
                    return;
                }
                let productAttributesTemplate = await getProductAttributesTemplate(productAttributesTemplateId);
                let body = productAttributesTemplate.body;
                $('.selected-attribute').addClass('processing');

                // add new attributes and clean old ones
                for (let i in body) {
                    if (!$('#selected-attribute-' + body[i].id).length) {
                        selectedAttributes.append(`
                            <div id="selected-attribute-${body[i].id}" class="selected-attribute" data-id="${body[i].id}">
                                <div class="selected-attribute-header">
                                    <i class="voyager-handle"></i>
                                    <span>${body[i].name}</span>
                                    <i class="voyager-x"></i>
                                </div>
                                <div>
                                    <select name="attributes[${body[i].id}][values][]" class="form-control select2" multiple></select>
                                </div>
                                <input type="hidden" name="attributes[${body[i].id}][order]" value="${i}">
                            </div>
                        `);
                        getAttributeValues(body[i].id)
                            .then(values => {
                                for (let value of values) {
                                    $('[name="attributes[' + body[i].id + '][values][]"]').append(`
                                        <option value="${value.id}">${value.name}</option>
                                    `);
                                }
                                initSelects();
                            });
                    } else {
                        $('#selected-attribute-' + body[i].id).removeClass('processing');
                    }
                }
                $('.selected-attribute.processing').remove();

                // sort
                for (let i in body) {
                    $('#selected-attribute-' + body[i].id).detach().appendTo(selectedAttributes);
                }

                initSortable();
                sortableUpdate();
            })

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

            async function getAttributeValues(attribute) {
                return fetch('/api/attributes/' + attribute + '/attribute-values')
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            return [];
                        }
                    });
            }

            async function getProductAttributesTemplate(id) {
                return fetch('/api/product-attributes-templates/' + id)
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
