<x-base-layout>

    {{ theme()->getView('pages/account/_navbar', array('class' => 'mb-5 mb-xl-10', 'user' => $user, 'info' => $info)) }}

    {{ theme()->getView('pages/account/examinations/_appointment', array('class' => 'mb-5 mb-xl-10',
    'user' => $user, 'info' => $info, 'healthprofesionals' => $healthprofesional, 'servicecategories' => $servicecategories))
    }}
</x-base-layout>
