<h3>Showing {{ $site->views->count() }} views for {{ $site->domain }}</h3>
<ul>
@foreach( $site->views as $view )
    <li>Time: {{ $view->created_at }} Page: {{ $view->page ? $view->page->url : 'None' }}, UA: {{ $view->user_agent->name }}</li>
@endforeach
</ul>