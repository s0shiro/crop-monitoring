<div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <aside class="bg-base-200 w-64 min-h-screen border-r border-base-300">
        <!-- Profile Section -->
        <div class="p-3 bg-base-100 shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="avatar placeholder">
                    <div class="bg-neutral text-neutral-content rounded-full w-10">
                        <span class="text-base">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <div>
                    <h2 class="text-base font-semibold">Dashboard</h2>
                    <p class="text-xs text-base-content/70">{{ auth()->user()->roles->first()->name }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <ul class="menu menu-md bg-base-200 w-full p-2 gap-1">
            <x-sidebar-item route="{{ auth()->user()->roles->first()->name }}.dashboard" icon="home" title="Home" />

            @role('admin')
            <div class="divider divider-neutral my-1 text-xs">Administration</div>

            <x-sidebar-item route="users.index" icon="users" title="Users Management" />
            <x-sidebar-item route="crops.index" icon="crop" title="Crops Management" />
            <x-sidebar-item route="farmers.index" icon="farmer" title="Farmers Management" />
            <x-sidebar-item route="associations.index" icon="association" title="Associations" />
            <x-sidebar-item route="crop_plantings.index" icon="crop_planting" title="Planting Records" />
            @endrole

            @role('technician')
            <div class="divider divider-neutral my-1 text-xs">Crop Management</div>

            <x-sidebar-item route="farmers.index" icon="farmer" title="My Farmers" />
            <x-sidebar-item route="crops.index" icon="crop" title="Crops Management" />
            <x-sidebar-item route="associations.index" icon="association" title="Associations" />
            <x-sidebar-item route="crop_plantings.index" icon="crop_planting" title="Planting Records" />
            @endrole

            @role('coordinator')
            <div class="divider divider-neutral my-1 text-xs">Coordination</div>

            <x-sidebar-item route="crops.index" icon="crop" title="Crops" />
            <x-sidebar-item route="crop_plantings.index" icon="crop_planting" title="Planting Records" />
            @endrole
        </ul>

        <!-- Footer -->
        <div class="absolute bottom-0 w-full p-3 bg-base-200 border-t border-base-300">
            <div class="flex items-center justify-between">
                <div class="text-xs text-base-content/70">
                    <p>Crop Monitoring System</p>
                    <p class="text-[10px]">v1.0.0</p>
                </div>
                <button class="btn btn-circle btn-ghost btn-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </aside>
</div>
