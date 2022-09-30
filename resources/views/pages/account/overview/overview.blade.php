<x-base-layout>
{{ theme()->getView('pages/account/_navbar', array('class' => 'mb-5 mb-xl-10', 'user' => $user,  'info' => $user->info)) }}

{{ theme()->getView('pages/account/overview/_details', array('class' => 'mb-5 mb-xl-10', 'user' => $user, 'info' => $user->info)) }}
</x-base-layout>
