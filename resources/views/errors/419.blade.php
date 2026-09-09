@extends('layouts.guest')

@section('title', '419 - Page Expired')

@section('content')
    <x-error-display code="419"
        title="Session Expired"
        message="Your session has expired for security reasons. Please refresh the page and try again."
        action-text="Refresh"
        action-href="javascript:location.reload()" />
@endsection
