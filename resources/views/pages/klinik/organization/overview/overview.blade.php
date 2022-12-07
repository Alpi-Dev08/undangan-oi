<x-base-layout>
    {{ theme()->getView('pages/klinik/organization/_navbar', array('class' => 'mb-5 mb-xl-10', 'organization' => $organization)) }}
    {{ theme()->getView('pages/klinik/organization/settings/_profile-details', array('class' => 'mb-5 mb-xl-10', 'organization' => $organization, 'user' => $user,'info'=> $info, 'countries' => $countries, 'provinces' => $provinces, 'cities' => $cities, 'districts' => $districts, 'subdistricts' => $subdistricts)) }}

</x-base-layout>
