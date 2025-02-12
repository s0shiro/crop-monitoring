<div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <aside class="bg-base-200 w-64 min-h-screen">
        <div class="p-4">
            <h2 class="text-xl font-semibold">Dashboard</h2>
        </div>
        <ul class="menu p-4">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Home
                </a>
            </li>

            @role('admin')
            <li class="menu-title">
                <span>Administration</span>
            </li>
            <li>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    Users Management
                </a>
            </li>
            <li>
                <a href="{{ route('crops.index') }}" class="{{ request()->routeIs('crops.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a6 6 0 0 0 6 6v12H6V8a6 6 0 0 0 6-6z"/>
                        <path d="M12 2c0 3.314 2.686 6 6 6"/>
                        <path d="M12 2c0 3.314-2.686 6-6 6"/>
                    </svg>
                    Crops Management
                </a>
            </li>
            <li>
                <a href="{{ route('farmers.index') }}" class="{{ request()->routeIs('farmers.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18V3H3zm16 16H5V5h14v14z"/>
                        <path d="M9 9h6v6H9z"/>
                    </svg>
                    Farmers Management
                </a>
            </li>
            @endrole

            @role('technician')
            <li class="menu-title">
                <span>Crop Management</span>
            </li>
            {{-- <li>
                <a href="#crops">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path d="M10 12a5 5 0 100-10 5 5 0 000 10z" />
                    </svg>
                    Monitor Crops
                </a>
            </li>
            <li>
                <a href="#reports">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" />
                    </svg>
                    Reports
                </a>
            </li> --}}
            <li>
                <a href="{{ route('crops.index') }}" class="{{ request()->routeIs('crops.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a6 6 0 0 0 6 6v12H6V8a6 6 0 0 0 6-6z"/>
                        <path d="M12 2c0 3.314 2.686 6 6 6"/>
                        <path d="M12 2c0 3.314-2.686 6-6 6"/>
                    </svg>
                    Crops Management
                </a>
            </li>
            <li>
                <a href="{{ route('farmers.index') }}" class="{{ request()->routeIs('farmers.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a6 6 0 0 0 6 6v12H6V8a6 6 0 0 0 6-6z"/>
                        <path d="M12 2c0 3.314 2.686 6 6 6"/>
                        <path d="M12 2c0 3.314-2.686 6-6 6"/>
                    </svg>
                    My Farmers
                </a>
            </li>
            @endrole

            @role('coordinator')
            <li class="menu-title">
                <span>Coordination</span>
            </li>
            {{-- <li>
                <a href="#tasks">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" />
                    </svg>
                    Task Management
                </a>
            </li>
            <li>
                <a href="#schedule">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" />
                    </svg>
                    Schedule
                </a>
            </li> --}}
            <li>
                <a href="{{ route('crops.index') }}" class="{{ request()->routeIs('crops.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a6 6 0 0 0 6 6v12H6V8a6 6 0 0 0 6-6z"/>
                        <path d="M12 2c0 3.314 2.686 6 6 6"/>
                        <path d="M12 2c0 3.314-2.686 6-6 6"/>
                    </svg>
                    Crops
                </a>
            </li>
            @endrole
        </ul>
    </aside>
</div>
