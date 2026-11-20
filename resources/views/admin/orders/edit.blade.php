@extends('admin.layouts.master')

@push('css')
    <style>
        .quantity-wrapper {
            display: flex;
            align-items: center;
        }

        .quantity-wrapper .btn {
            height: 20px;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .quantity-wrapper .quantity {
            border: none;
            width: 30px;
            text-align: center;
            padding: 0;
            height: 32px;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.order.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$order->id" />
                <div class="row justify-content-center">
                    @include('admin.orders.forms.edit-left')
                    @include('admin.orders.forms.edit-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('public/core/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/core/libs/ckeditor/adapters/jquery.js') }}"></script>

@endpush


@push('js')
    <script>
        function toggleInput(id) {
            let cdKeyInput = document.getElementById(`cdKeyInput_${id}`);
            let accountInput = document.getElementById(`accountInput_${id}`);
            let selectedType = document.querySelector(`input[name="data[account_type][${id}]"]:checked`).value;
            if (selectedType === "cd_key") {
                cdKeyInput.classList.remove("d-none");
                accountInput.classList.add("d-none");
            } else {
                cdKeyInput.classList.add("d-none");
                accountInput.classList.remove("d-none");
            }
        }
    </script>
@endpush
