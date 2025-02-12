<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h2 class="text-2xl font-light mb-6 text-gray-700">Edit Association</h2>

        <form action="{{ route('associations.update', $association) }}" method="POST">
            @csrf @method('PUT')

            @if ($errors->any())
                <div class="bg-red-500 text-white p-2 my-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-control">
                <label for="name" class="label">
                    <span class="label-text">Association Name</span>
                </label>
                <input type="text" name="name" id="name" value="{{ $association->name }}" required
                       class="input input-bordered w-full">
            </div>

            <div class="form-control">
                <label for="description" class="label">
                    <span class="label-text">Description</span>
                </label>
                <textarea name="description" id="description" class="textarea textarea-bordered w-full">{{ $association->description }}</textarea>
            </div>

            <div class="form-control mt-6">
                <button type="submit" class="btn btn-primary">
                    Update Association
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
