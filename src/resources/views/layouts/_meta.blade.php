<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if (Auth::user())
<meta name="username" content="{{ Auth::user()->username }}" />
@endif
<meta name="title" content="@yield('title')" />
<meta name="description" content="@lang('site.meta_description')" />
<meta name="keywords" content="@lang('site.meta_keywords')" />
<meta name="robots" content="index, follow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="{{ app()->getLocale() }}" />

<link rel="author" type="text/plain" href="humans.txt" />