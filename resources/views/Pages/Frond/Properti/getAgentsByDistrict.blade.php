@foreach ($agents as $user)
        <x-Layout.Item.UserProfileCard :user="$user">
            @slot('content')
            <x-Tool.UserPropertyStatistics :userId="$user->id" />
            @endslot
        </x-Layout.Item.UserProfileCard>
        @endforeach