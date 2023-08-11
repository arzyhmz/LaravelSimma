<li class="nav-item {{ Request::is('contacts*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('contacts.index') }}">
        <!-- <i class="nav-icon icon-cursor"></i> -->
        <span>Contacts</span>
    </a>
</li>
<li class="nav-item {{ Request::is('logs*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('logs.index') }}">
        <!-- <i class="nav-icon icon-cursor"></i> -->
        <span>Contact Logs</span>
    </a>
</li>
<li class="nav-item {{ Request::is('wabHistories*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('wabHistories.index') }}">
        <!-- <i class="nav-icon icon-cursor"></i> -->
        <span>Wab Histories</span>
    </a>
</li>
<li class="nav-item {{ Request::is('chatLogs*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('chatLogs.index') }}">
        <!-- <i class="nav-icon icon-cursor"></i> -->
        <span>Wab Logs</span>
    </a>
</li>
<li class="nav-item {{ Request::is('childrens*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('childrens.index') }}">
        <span>Childrens</span>
    </a>
</li>
<li class="nav-item {{ Request::is('childrenLogs*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('childrenLogs.index') }}">
        <span>Children Logs</span>
    </a>
</li>
