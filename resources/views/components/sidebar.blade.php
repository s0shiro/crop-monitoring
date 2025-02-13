<div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <aside class="bg-base-200 w-64 min-h-screen">
        <div class="p-4">
            <h2 class="text-xl font-semibold">Dashboard</h2>
        </div>
        <ul class="menu p-4">
            <x-sidebar-item route="dashboard" icon="home" title="Home" />

            @role('admin')
            <li class="menu-title">
                <span>Administration</span>
            </li>
            <x-sidebar-item route="users.index" icon="users" title="Users Management" />
            <x-sidebar-item route="crops.index" icon="crop" title="Crops Management" />
            <x-sidebar-item route="farmers.index" icon="farmer" title="Farmers Management" />
            <x-sidebar-item route="associations.index" icon="association" title="Associations" />
            @endrole

            @role('technician')
            <li class="menu-title">
                <span>Crop Management</span>
            </li>

            <x-sidebar-item route="crops.index" icon="crop" title="Crops Management" />
            <x-sidebar-item route="farmers.index" icon="farmer" title="My Farmers" />
            @endrole

            @role('coordinator')
            <li class="menu-title">
                <span>Coordination</span>
            </li>

            <x-sidebar-item route="crops.index" icon="crop" title="Crops" />
            @endrole
        </ul>
    </aside>
</div>
