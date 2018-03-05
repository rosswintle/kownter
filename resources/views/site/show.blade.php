@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class="card-header">{{ $site->domain }}</h3>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card-deck">
                        
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    All views
                                </h5>
                                {{ $site->views->count() }}
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    All views
                                </h5>
                                {{ $site->views->count() }}
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    All views
                                </h5>
                                {{ $site->views->count() }}
                            </div>
                        </div>

                    </div>

                    <div class="card-deck">

                        <div class="card">
                            <div class="card-header">
                                Top pages
                            </div>
                            <div class="card-body">
                                <ul>
                                    @foreach ( $topPages as $page )
                                        <li>
                                            {{ $page->url }}: {{ $page->views_count }} hits
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Top referrers
                            </div>
                            <div class="card-body">
                                <ul>
                                    @foreach ( $topReferrers as $referrer )
                                        <li>
                                            {{ $referrer->domain }}: {{ $referrer->views_count }} hits
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

<ul>
@foreach( $site->views as $view )
    <li>Time: {{ $view->created_at }}
        Page: {{ $view->page ? $view->page->url : 'None' }},
        UA: {{ $view->user_agent->name }},
        Referrer: {{ $view->referring_domain ? $view->referring_domain->domain : 'None' }}
    </li>
@endforeach
</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


