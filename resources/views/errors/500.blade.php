@extends('layouts.guest')

@section('title', '500 - Server Error')

@section('content')
    <x-error-display code="500"
        title="Internal Server Error"
        message="Something went wrong on our end. The system has logged the error and our team is investigating. Please try again later."
        action-text="Return Home"
        action-href="/" />
@endsection
