<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Admin Panel</h1>

        <div class="bg-gray-800 p-6 rounded-lg shadow-xl">
            <h2 class="text-xl font-bold mb-4">Manage Users</h2>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-2">Name</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b border-gray-700">
                            <td class="py-3">{{ $user->name }}</td>
                            <td class="py-3 text-gray-400">{{ $user->email }}</td>
                            <td class="py-3">
                                <span class="{{ $user->banned_at ? 'text-red-500' : 'text-green-500' }}">
                                    {{ $user->banned_at ? 'Banned' : 'Active' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST">
                                    @csrf
                                    <button class="bg-red-600 px-3 py-1 rounded text-sm hover:bg-red-700">
                                        {{ $user->banned_at ? 'Unban' : 'Ban' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>