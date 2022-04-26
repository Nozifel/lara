@component('mail::message')
# Introduction

A new user has been created.

@component('mail::panel')
{{ $user->name }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
