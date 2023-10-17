@extends('back.layouts.auth-layout')
@section('pageTitle', isset($pageTitle)? $pageTitle :'Reset Password')


<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark"><img src="./back/static/logo.svg" height="36"
                    alt=""></a>
        </div>
        @livewire('Author-reset-form')
    </div>
</div>