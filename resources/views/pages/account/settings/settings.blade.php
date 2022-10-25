<x-base-layout>

    {{ theme()->getView('pages/account/_navbar', array('class' => 'mb-5 mb-xl-10','user' => $user, 'info' => $info)) }}

    {{ theme()->getView('pages/account/settings/_profile-details', array('class' => 'mb-5 mb-xl-10', 'user' => $user,
    'info' => $info, 'countries' => $countries, 'provinces' => $provinces, 'cities' => $cities, 'districts' => $districts, 'subdistricts' => $subdistricts,
    'cards' => $cards, 'bloods' => $bloods,'religions' => $religions,'genders' => $genders,'works' => $works,'maritals' => $maritals,'educations' => $educations))
    }}
    @if(auth()->user()->hasRole('dokter'))
        {{ theme()->getView('pages/account/settings/_nakes', array('class' => 'mb-5 mb-xl-10', 'user' => $user, 'nakes' => $nakes,'specialities' => $specialities, 'types' => $types)) }}
    @endif

    {{ theme()->getView('pages/account/settings/_signin-method', array('class' => 'mb-5 mb-xl-10', 'user' => $user, 'info' => $info)) }}

</x-base-layout>
