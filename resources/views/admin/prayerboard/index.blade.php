@extends('layouts.admin.layout')

@section('content')
<div class="flex flex-row justify-between items-center mb-4">
    <h1 class="admin-h1">Prayer Board</h1>
    <a href="{{ url('/admin/prayercategories') }}"
        class="no-underline text-white px-4 py-1 flex items-center custom-green rounded text-sm font-semibold">
        Manage Categories
    </a>
</div>

{{-- Stats bar --}}
<div class="grid grid-cols-5 gap-3 mb-6">
    @php
        $tabs = [
            'pending'  => ['label' => 'Pending',  'icon' => '⏳', 'color' => 'yellow'],
            'active'   => ['label' => 'Active',   'icon' => '🟢', 'color' => 'green'],
            'answered' => ['label' => 'Answered', 'icon' => '✓',  'color' => 'blue'],
            'ended'    => ['label' => 'Ended',    'icon' => '⏰', 'color' => 'gray'],
            'rejected' => ['label' => 'Rejected', 'icon' => '✗',  'color' => 'red'],
        ];
        $colorMap = [
            'yellow' => 'bg-yellow-50 border-yellow-300 text-yellow-800',
            'green'  => 'bg-green-50 border-green-300 text-green-800',
            'blue'   => 'bg-blue-50 border-blue-300 text-blue-800',
            'gray'   => 'bg-gray-50 border-gray-300 text-gray-700',
            'red'    => 'bg-red-50 border-red-300 text-red-800',
        ];
    @endphp

    @foreach($tabs as $key => $tab)
    <button onclick="switchTab('{{ $key }}')"
        id="stat-{{ $key }}"
        class="stat-btn border rounded-lg p-3 text-center cursor-pointer transition {{ $colorMap[$tab['color']] }} {{ $key === 'pending' ? 'ring-2 ring-offset-1 ring-indigo-400' : '' }}">
        <div class="text-xl">{{ $tab['icon'] }}</div>
        <div class="text-2xl font-bold">{{ $counts[$key] ?? 0 }}</div>
        <div class="text-xs font-medium">{{ $tab['label'] }}</div>
    </button>
    @endforeach
</div>

{{-- Tab content --}}
<div id="tab-content" class="bg-white shadow rounded">
    <div id="tab-loading" class="hidden text-center py-12 text-gray-400">
        <div class="text-2xl mb-2">⏳</div>
        <div class="text-sm">Loading prayers...</div>
    </div>
    <div id="tab-body"></div>
</div>

<script>
    var currentTab = 'pending';

    function switchTab(status) {
        if (currentTab === status) return;
        currentTab = status;

        // Update stat button highlights
        document.querySelectorAll('.stat-btn').forEach(function(btn) {
            btn.classList.remove('ring-2', 'ring-offset-1', 'ring-indigo-400');
        });
        var activeBtn = document.getElementById('stat-' + status);
        if (activeBtn) {
            activeBtn.classList.add('ring-2', 'ring-offset-1', 'ring-indigo-400');
        }

        loadTab(status);
    }

    function loadTab(status) {
        var loading = document.getElementById('tab-loading');
        var body    = document.getElementById('tab-body');
        loading.classList.remove('hidden');
        body.innerHTML = '';

        var url = '{{ url("/admin/prayerboard/list") }}/' + status;
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(res) { return res.text(); })
        .then(function(html) {
            loading.classList.add('hidden');
            body.innerHTML = html;
            attachTabEvents();
        })
        .catch(function() {
            loading.classList.add('hidden');
            body.innerHTML = '<div class="p-8 text-center text-red-500">Failed to load. Please refresh the page.</div>';
        });
    }

    function attachTabEvents() {
        // Pagination links — intercept to reload within tab
        document.querySelectorAll('#tab-body .pagination a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var url = this.href;
                var loading = document.getElementById('tab-loading');
                var body    = document.getElementById('tab-body');
                loading.classList.remove('hidden');
                body.innerHTML = '';

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function(r) { return r.text(); })
                    .then(function(html) {
                        loading.classList.add('hidden');
                        body.innerHTML = html;
                        attachTabEvents();
                    });
            });
        });
    }

    // Load default tab on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadTab('pending');
    });
</script>
@endsection
