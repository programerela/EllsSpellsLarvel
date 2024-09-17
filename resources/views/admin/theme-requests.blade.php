<x-app-layout>
    <p class="my-8 text-xl font-semibold">Theme requests pending</p>

    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Approve</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Reject</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($themes->sortByDesc('created_at') as $theme)
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $theme->name }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $theme->user->name }}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.approve-theme') }}">
                        @csrf
                        <input type="hidden" name="theme_id" value="{{ $theme->id }}">
                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Approve</button>
                    </form>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.reject-theme') }}">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $theme->id }}">
                        <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>