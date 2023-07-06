<li class="nav-item {{ Request::is('contacts*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('contacts.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Contacts</span>
    </a>
</li>
<li class="nav-item {{ Request::is('logs*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('logs.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Logs</span>
    </a>
</li>
