<x-base-layout>

    {{ theme()->getView('pages/account/_navbar', array('class' => 'mb-5 mb-xl-10', 'user' => $user, 'info' => $info)) }}

    {{ theme()->getView('pages/account/payments/_payment', array('class' => 'mb-5 mb-xl-10',
    'user' => $user, 'info' => $info, 'examination' => $examination))
    }}
</x-base-layout>
