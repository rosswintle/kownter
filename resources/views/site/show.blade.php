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
                            <div class="card-header">
                                24 hours
                            </div>
                            <div class="card-body">
                                {{ $dayViews }}
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                7 days
                            </div>
                            <div class="card-body">
                                {{ $weekViews }}
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                All time
                            </div>
                            <div class="card-body">
                                {{ $allViews }}
                            </div>
                        </div>

                    </div>

                    <div class="card-deck mt-3">

                        <div class="card">
                            <div class="card-header">
                                Top pages
                            </div>
                            <div class="card-body">

                                    <top-pages-table site="{{ $site->id }}"></top-pages-table>

                            </div>
                        </div>

                    </div>

                    <div class="card-deck mt-3">

                        <div class="card">
                            <div class="card-header">
                                Top 20 referrers (all time)
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Referrer</th>
                                            <th scope="col">Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $topReferrers as $referrer )
                                            <tr>
                                                <td>{{ $referrer->domain }}</td>
                                                <td>{{ $referrer->views_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Top 20 browsers (all time)
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Browser</th>
                                            <th scope="col">Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ( $topBrowsers as $browser )
                                            <tr>
                                                <td>{{ $browser->browser_name . " " . $browser->browser_version }}</td>
                                                <td>{{ $browser->views_count }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="card-deck mt-3">

                        <div class="card">
                            <div class="card-header">
                                Recent views
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Time</th>
                                            <th scope="col">Page</th>
                                            <th scope="col">Browser</th>
                                            <th scope="col">Referrer</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach( $site->views as $view )
                                            <tr>
                                                <td>{{ $view->created_at }}</td>
                                                <td>{{ $view->page ? $view->page->url : 'None' }}</td>
                                                <td>{{ $view->user_agent->browser_name . " " . $view->user_agent->browser_version }}</td>
                                                <td>{{ $view->referring_domain ? $view->referring_domain->domain : 'None' }}</td>
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection


