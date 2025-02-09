@props(['user'])

<tr class="hover:bg-base-200/50 transition-colors duration-200">
    <td>
        <div class="font-medium">{{ $user->name }}
            @if (auth()->user()->id === $user->id)
                <span class="badge badge-info ml-2">You</span>
            @endif
        </div>
    </td>
    <td class="text-base-content/70">{{ $user->email }}</td>
    <td>
        @foreach($user->roles as $role)
            <div class="badge gap-1 normal-case {{
                match(strtolower($role->name)) {
                    'admin' => 'badge-error',
                    'coordinator' => 'badge-info',
                    'technician' => 'badge-success',
                    default => 'badge-neutral'
                }
            }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                {{ $role->name }}
            </div>
        @endforeach
    </td>
    <td>
        @if (auth()->user()->id === $user->id)
            <span class="text-base-content/70">Uneditable</span>
        @else
            <x-action-buttons :user="$user" />
        @endif
    </td>
</tr>
