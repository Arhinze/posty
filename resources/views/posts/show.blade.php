@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 p-6 bg-white rounded-lg">

            <div class="p-6 bg-white rounded-lg">
                <x-post :post="$post" />
            </div>
        </div>
    </div>
@endsection