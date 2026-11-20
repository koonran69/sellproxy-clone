@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form class="block-double-click" :action="route('admin.role.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$role->id" />
                <div class="row justify-content-center">
                    @include('admin.roles.forms.edit-left')
                    @include('admin.roles.forms.edit-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection
