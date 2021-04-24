<x-admin-layout :title="__('Dashboard')">

    <div class="row">
        <div class="col-4">
            <div class="alert alert info">
                <div class="display-4">{{ $temp }}</div>
                <div>{{ $weather }}</div>
            </div>
        </div>
    </div>

</x-admin-layout>