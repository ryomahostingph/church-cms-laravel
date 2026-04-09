{{-- AJAX partial: Pending prayers list --}}
<div class="bg-white p-4">
    {{-- Filter --}}
    <form id="pending-filter" class="flex flex-wrap gap-3 mb-4 items-end">
        <div>
            <label class="text-xs font-semibold text-gray-600 block mb-1">Category</label>
            <select name="category_id" class="border border-gray-300 rounded px-3 py-1.5 text-sm">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->emoji }} {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-600 block mb-1">Month</label>
            <input type="month" name="month" value="{{ request('month') }}" class="border border-gray-300 rounded px-3 py-1.5 text-sm">
        </div>
        <button type="button" onclick="applyPendingFilter()"
            class="bg-indigo-600 text-white text-sm px-4 py-1.5 rounded hover:bg-indigo-700">Filter</button>
        <a href="{{ url('/admin/prayerboard/list/pending') }}" class="text-sm text-gray-500 hover:underline self-center">Clear</a>
    </form>

    @include('partials.message')

    @forelse($prayers as $prayer)
    <div class="bg-white border-l-4 border-yellow-400 rounded-lg shadow mb-4 overflow-hidden" id="prayer-card-{{ $prayer->id }}">
        {{-- Card header --}}
        <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-200 flex justify-between items-start gap-3">
            <div class="flex items-start gap-3 flex-1">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                    {{ strtoupper(substr($prayer->submitter_name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-gray-900">{{ $prayer->submitter_name }}</div>
                    @if($prayer->user && $prayer->user->email)
                    <div class="text-xs text-gray-500">{{ $prayer->user->email }}</div>
                    @endif
                    <div class="text-xs text-gray-400 mt-0.5">Submitted {{ $prayer->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                @if($prayer->category)
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold"
                    style="background-color: {{ $prayer->category->gradient_start }}; color: {{ $prayer->category->display_color }}">
                    {{ $prayer->category->emoji }} {{ $prayer->category->name }}
                </span>
                @endif
                <span class="px-3 py-1 bg-yellow-200 text-yellow-900 rounded-full text-xs font-bold">⏳ PENDING</span>
            </div>
        </div>

        {{-- Prayer text (editable) --}}
        <div class="px-6 py-4">
            <p class="text-xs font-bold text-gray-500 uppercase mb-1">Prayer Request</p>
            <textarea id="text-{{ $prayer->id }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 bg-gray-50 focus:bg-white focus:outline-none"
                rows="4">{{ $prayer->text }}</textarea>
            <p class="text-xs text-blue-500 mt-1">💡 You may edit for clarity or to remove personal details before approving.</p>
        </div>

        {{-- Expiry + actions --}}
        <div class="px-6 pb-4 grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase mb-1">Set Expiry Duration</p>
                <select id="expiry-{{ $prayer->id }}" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 text-sm font-medium">
                    <option value="60" selected>60 Days (2 Months) — Default</option>
                    <option value="90">90 Days (3 Months)</option>
                    <option value="30">30 Days (1 Month)</option>
                    <option value="14">14 Days (2 Weeks)</option>
                    <option value="7">7 Days (1 Week)</option>
                    <option value="3">3 Days</option>
                    <option value="1">1 Day (Urgent)</option>
                </select>
                <p class="text-xs text-gray-400 mt-1" id="expiry-preview-{{ $prayer->id }}">Expires approx. 60 days from now</p>
            </div>
            <div class="flex flex-col justify-end gap-2">
                <button onclick="approvePrayer({{ $prayer->id }})"
                    class="w-full px-4 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 text-sm">
                    ✓ Approve &amp; Publish
                </button>
                <button onclick="showRejectModal({{ $prayer->id }})"
                    class="w-full px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 text-sm">
                    ✗ Reject
                </button>
            </div>
        </div>

        {{-- View detail link --}}
        <div class="bg-gray-50 px-6 py-2 border-t border-gray-100 flex justify-end">
            <a href="{{ url('/admin/prayerboard/' . $prayer->id) }}" class="text-xs text-indigo-600 hover:underline">View full detail &amp; audit log →</a>
        </div>
    </div>
    @empty
    <div class="text-center py-16 text-gray-400">
        <div class="text-4xl mb-3">🙏</div>
        <p class="font-semibold">No pending prayers</p>
        <p class="text-sm">All caught up!</p>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($prayers->hasPages())
    <div class="mt-4">{{ $prayers->links() }}</div>
    @endif
</div>

{{-- Reject modal --}}
<div id="rejectModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-3">✗ Reject Prayer Request</h3>
        <input type="hidden" id="rejectPrayerId" value="">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Reason for rejection</label>
        <textarea id="rejectReason" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" rows="3"
            placeholder="e.g. Does not meet community guidelines..."></textarea>
        <p id="rejectError" class="text-xs text-red-500 mt-1 hidden">Please enter a reason.</p>
        <div class="flex gap-3 mt-4">
            <button onclick="submitReject()"
                class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700">Confirm Reject</button>
            <button onclick="closeRejectModal()"
                class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300">Cancel</button>
        </div>
    </div>
</div>

<script>
(function() {
    // Expiry preview update
    document.querySelectorAll('[id^="expiry-"]').forEach(function(sel) {
        sel.addEventListener('change', function() {
            var id      = this.id.replace('expiry-', '');
            var days    = parseInt(this.value);
            var d       = new Date();
            d.setDate(d.getDate() + days);
            var preview = document.getElementById('expiry-preview-' + id);
            if (preview) {
                preview.textContent = 'Expires: ' + d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            }
        });
    });

    window.approvePrayer = function(id) {
        var expiryDays = document.getElementById('expiry-' + id).value;
        var text       = document.getElementById('text-' + id).value;
        var csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('{{ url("/admin/prayerboard") }}/' + id + '/approve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ expiry_days: parseInt(expiryDays), text: text }),
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                var card = document.getElementById('prayer-card-' + id);
                if (card) card.remove();
                showToast(data.message, 'green');
                updateStatCount('pending', -1);
                updateStatCount('active', 1);
            } else {
                showToast(data.message || 'Error', 'red');
            }
        });
    };

    window.showRejectModal = function(id) {
        document.getElementById('rejectPrayerId').value = id;
        document.getElementById('rejectReason').value = '';
        document.getElementById('rejectError').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('hidden');
    };

    window.closeRejectModal = function() {
        document.getElementById('rejectModal').classList.add('hidden');
    };

    window.submitReject = function() {
        var id     = document.getElementById('rejectPrayerId').value;
        var reason = document.getElementById('rejectReason').value.trim();
        if (!reason) {
            document.getElementById('rejectError').classList.remove('hidden');
            return;
        }

        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('{{ url("/admin/prayerboard") }}/' + id + '/reject', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ reason: reason }),
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            closeRejectModal();
            if (data.success) {
                var card = document.getElementById('prayer-card-' + id);
                if (card) card.remove();
                showToast(data.message, 'green');
                updateStatCount('pending', -1);
                updateStatCount('rejected', 1);
            } else {
                showToast(data.message || 'Error rejecting prayer.', 'red');
            }
        });
    };

    function showToast(msg, color) {
        var toast = document.createElement('div');
        toast.className = 'fixed bottom-6 right-6 px-6 py-3 rounded-lg shadow-xl text-white font-semibold text-sm z-50 '
            + (color === 'green' ? 'bg-green-600' : 'bg-red-600');
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 3500);
    }

    function updateStatCount(tab, delta) {
        var btn = document.getElementById('stat-' + tab);
        if (!btn) return;
        var countEl = btn.querySelector('.text-2xl');
        if (countEl) {
            var current = parseInt(countEl.textContent) || 0;
            countEl.textContent = Math.max(0, current + delta);
        }
    }

    function applyPendingFilter() {
        var form     = document.getElementById('pending-filter');
        var params   = new URLSearchParams();
        var catId    = form.querySelector('[name="category_id"]').value;
        var month    = form.querySelector('[name="month"]').value;
        if (catId)  params.set('category_id', catId);
        if (month)  params.set('month', month);

        var url = '{{ url("/admin/prayerboard/list/pending") }}?' + params.toString();
        var body = document.getElementById('tab-body');
        var loading = document.getElementById('tab-loading');
        loading.classList.remove('hidden');
        body.innerHTML = '';

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.text(); })
            .then(function(html) {
                loading.classList.add('hidden');
                body.innerHTML = html;
            });
    }

    window.applyPendingFilter = applyPendingFilter;
})();
</script>
