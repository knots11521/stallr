@extends('layouts.guest')

@section('title', '404 - Page Not Found')

@section('content')
    <x-error-display code="404"
        title="Page Lost in Digital Space"
        message="The requested page could not be found. It may have been removed, renamed, or never existed."
        action-text="Go to Homepage"
        action-href="/" />
@endsection
