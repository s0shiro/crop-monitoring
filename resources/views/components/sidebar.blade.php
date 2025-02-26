<div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <aside class="bg-base-200 w-64 min-h-screen flex flex-col">
        <!-- Profile Section -->
        <div class="p-4 bg-base-100 border-b border-base-300">
            <div class="flex items-center space-x-3">
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-10">
                        <span class="text-lg font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <div>
                    <h2 class="font-semibold">{{ auth()->user()->name }}</h2>
                    <span class="text-xs text-base-content/70 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-success"></span>
                        {{ ucfirst(auth()->user()->roles->first()->name) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto">
            <ul class="menu menu-md w-full">
                <!-- Common Menu Items -->
                <li class="menu-title mt-4">
                    <span>General</span>
                </li>
                <x-sidebar-item route="{{ auth()->user()->roles->first()->name }}.dashboard" icon="home" title="Dashboard" />

                @role('admin')
                <li class="menu-title mt-4">
                    <span>Administration</span>
                </li>
                <x-sidebar-item route="users.index" icon="users" title="Users" />
                <x-sidebar-item route="farmers.index" icon="farmer" title="Farmers" />
                <x-sidebar-item route="associations.index" icon="association" title="Associations" />

                <li class="menu-title mt-4">
                    <span>Crop Management</span>
                </li>
                <x-sidebar-item route="crops.index" icon="crop" title="Crops" />
                <x-sidebar-item route="crop_plantings.index" icon="crop_planting" title="Plantings" />
                <x-sidebar-item route="crop_inspections.index" icon="clipboard-check" title="Inspections" />
                @endrole

                @role('technician')
                <li class="menu-title mt-4">
                    <span>Management</span>
                </li>
                <x-sidebar-item route="farmers.index" icon="farmer" title="My Farmers" />
                <x-sidebar-item route="associations.index" icon="association" title="Associations" />

                <li class="menu-title mt-4">
                    <span>Field Work</span>
                </li>
                <x-sidebar-item route="crop_plantings.index" icon="crop_planting" title="Plantings" />
                <x-sidebar-item route="crop_inspections.index" icon="clipboard-check" title="Inspections" />

                <li class="menu-title mt-4">
                    <span>Crop Management</span>
                </li>
                <x-sidebar-item route="crops.index" icon="crop" title="Crops" />
                @endrole

                @role('coordinator')
                <li class="menu-title mt-4">
                    <span>Coordination</span>
                </li>
                <x-sidebar-item route="crops.index" icon="crop" title="Crops Overview" />
                <x-sidebar-item route="crop_plantings.index" icon="crop_planting" title="Planting Records" />
                <x-sidebar-item route="crop_inspections.index" icon="clipboard-check" title="Inspection Reports" />
                @endrole
            </ul>
        </nav>

        <!-- Footer -->
        <div class="p-4 bg-base-200 border-t border-base-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium">Crop Monitoring</p>
                    <p class="text-[10px] text-base-content/70">Version 1.0.0</p>
                </div>
                <div class="dropdown dropdown-top dropdown-end">
                    <button tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('profile.edit') }}">Settings</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-error">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>
