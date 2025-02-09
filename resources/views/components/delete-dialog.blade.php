@props(['user', 'route'])

<dialog id="delete-modal-{{ $user->id }}" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Confirm Deletion</h3>
        <p class="py-4">Are you sure you want to delete this user?</p>
        <div class="modal-action">
            <form method="POST" action="{{ route($route, $user) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error">Delete</button>
            </form>
            <button class="btn" onclick="document.getElementById('delete-modal-{{ $user->id }}').close()">Cancel</button>
        </div>
    </div>
</dialog>
