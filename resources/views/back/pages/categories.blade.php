@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle)? $pageTitle :'Blog Categories')
@section('content')
<div class="page-header d-print-none">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Blog Categories

            </h2>
        </div>
    </div>
</div>

@livewire('categories')
@endsection