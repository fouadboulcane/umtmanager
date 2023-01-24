<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-2">
    <div class="container">
        
        <a class="navbar-brand text-primary font-weight-bold text-uppercase" href="{{ url('/') }}">
            umtmanager
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Apps <span class="caret"></span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @can('view-any', App\Models\Client::class)
                            <a class="dropdown-item" href="{{ route('clients.index') }}">Clients</a>
                            @endcan
                            @can('view-any', App\Models\Currency::class)
                            <a class="dropdown-item" href="{{ route('currencies.index') }}">Currencies</a>
                            @endcan
                            @can('view-any', App\Models\Devi::class)
                            <a class="dropdown-item" href="{{ route('devis.index') }}">Devis</a>
                            @endcan
                            @can('view-any', App\Models\Project::class)
                            <a class="dropdown-item" href="{{ route('projects.index') }}">Projects</a>
                            @endcan
                            @can('view-any', App\Models\Task::class)
                            <a class="dropdown-item" href="{{ route('tasks.index') }}">Tasks</a>
                            @endcan
                            @can('view-any', App\Models\Leave::class)
                            <a class="dropdown-item" href="{{ route('leaves.index') }}">Leaves</a>
                            @endcan
                            @can('view-any', App\Models\Event::class)
                            <a class="dropdown-item" href="{{ route('events.index') }}">Events</a>
                            @endcan
                            @can('view-any', App\Models\Note::class)
                            <a class="dropdown-item" href="{{ route('notes.index') }}">Notes</a>
                            @endcan
                            @can('view-any', App\Models\Anouncement::class)
                            <a class="dropdown-item" href="{{ route('anouncements.index') }}">Anouncements</a>
                            @endcan
                            @can('view-any', App\Models\Ticket::class)
                            <a class="dropdown-item" href="{{ route('tickets.index') }}">Tickets</a>
                            @endcan
                            @can('view-any', App\Models\Article::class)
                            <a class="dropdown-item" href="{{ route('articles.index') }}">Articles</a>
                            @endcan
                            @can('view-any', App\Models\Expense::class)
                            <a class="dropdown-item" href="{{ route('expenses.index') }}">Expenses</a>
                            @endcan
                            @can('view-any', App\Models\Invoice::class)
                            <a class="dropdown-item" href="{{ route('invoices.index') }}">Invoices</a>
                            @endcan
                            @can('view-any', App\Models\Payment::class)
                            <a class="dropdown-item" href="{{ route('payments.index') }}">Payments</a>
                            @endcan
                            @can('view-any', App\Models\Presence::class)
                            <a class="dropdown-item" href="{{ route('presences.index') }}">Presences</a>
                            @endcan
                            @can('view-any', App\Models\User::class)
                            <a class="dropdown-item" href="{{ route('users.index') }}">Users</a>
                            @endcan
                            @can('view-any', App\Models\Manifest::class)
                            <a class="dropdown-item" href="{{ route('manifests.index') }}">Manifests</a>
                            @endcan
                            @can('view-any', App\Models\Category::class)
                            <a class="dropdown-item" href="{{ route('categories.index') }}">Categories</a>
                            @endcan
                            @can('view-any', App\Models\Post::class)
                            <a class="dropdown-item" href="{{ route('posts.index') }}">Posts</a>
                            @endcan
                            @can('view-any', App\Models\DeviRequest::class)
                            <a class="dropdown-item" href="{{ route('devi-requests.index') }}">Devi Requests</a>
                            @endcan
                        </div>

                    </li>
                    @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) || 
                        Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Access Management <span class="caret"></span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @can('view-any', Spatie\Permission\Models\Role::class)
                            <a class="dropdown-item" href="{{ route('roles.index') }}">Roles</a>
                            @endcan
                    
                            @can('view-any', Spatie\Permission\Models\Permission::class)
                            <a class="dropdown-item" href="{{ route('permissions.index') }}">Permissions</a>
                            @endcan
                        </div>
                    </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>