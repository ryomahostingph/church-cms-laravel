@extends('layouts.admin.layout')
@section('content')

    {{-- Vue modals --}}
    <create-series sermons_id="{{ $sermon->id }}" base_url="/admin"></create-series>
    <edit-series base_url="/admin"></edit-series>
    <input type="hidden" id="edit_sermon_id" value="">

    <div class="flex items-center justify-between mb-3">
        <h1 class="admin-h1 flex items-center">
            <a href="{{ url('/admin/sermons') }}" title="Back" class="rounded-full bg-gray-100 p-2">
                <img src="{{ url('uploads/icons/back.svg') }}" class="w-3 h-3">
            </a>
            <span class="mx-3">{{ $sermon->title }}</span>
        </h1>
    </div>

    <div class="custom-table py-3 bg-white shadow px-3">
        <table class="w-full">
            <thead class="bg-grey-light">
                <tr class="border-t-2 border-b-2">
                    <th class="text-left text-sm px-2 py-2 text-grey-darker">#</th>
                    <th class="text-left text-sm px-2 py-2 text-grey-darker">Chapter Title</th>
                    <th class="text-left text-sm px-2 py-2 text-grey-darker">Date</th>
                    <th class="text-left text-sm px-2 py-2 text-grey-darker text-center">Video</th>
                    <th class="text-left text-sm px-2 py-2 text-grey-darker text-center">Audio</th>
                    <th class="text-left text-sm px-2 py-2 text-grey-darker text-center">PDF</th>
                    <th class="text-left text-sm px-2 py-2 text-grey-darker text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($sermonlinks as $index => $sermonlink)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-2 py-2 text-sm text-gray-500">{{ $sermonlinks->firstItem() + $index }}</td>
                    <td class="px-2 py-2 text-sm font-medium text-gray-800">{{ $sermonlink->title ?: '—' }}</td>
                    <td class="px-2 py-2 text-xs text-gray-600 whitespace-nowrap">{{ $sermonlink->date ? date('d M Y', strtotime($sermonlink->date)) : '—' }}</td>
                    <td class="px-2 py-2 text-center">
                        @if ($sermonlink->video_link)
                            <a href="{{ $sermonlink->video_link }}" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline">Watch</a>
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-2 py-2 text-center">
                        @if ($sermonlink->audio_link)
                            <a href="{{ $sermonlink->audio_link }}" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline">Listen</a>
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-2 py-2 text-center">
                        @if ($sermonlink->pdf_link)
                            <a href="{{ \Storage::url($sermonlink->pdf_link) }}" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline">Download</a>
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-2 py-2 text-center whitespace-nowrap">
                        <a href="#" onclick="editChapter({{ $sermonlink->id }})"
                           class="text-xs text-blue-600 hover:underline mr-2">Edit</a>
                        <a href="#" rel="{{ url('/admin/links/delete/' . $sermonlink->id) }}"
                           class="text-xs text-red-600 hover:underline delete-link">Delete</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-2 py-6 text-center text-gray-400 text-sm">No chapters added yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $sermonlinks->links() }}

@endsection

@push('scripts')
    <script>
        function editChapter(id) {
            $('#edit_sermon_id').val(id);
            $('#edit-series-modal').click();
        }
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.delete-link').on('click', function () {
                var link = $(this).attr('rel');
                swal({
                    icon: "warning",
                    text: "Delete this chapter?",
                    buttons: { cancel: true, confirm: { text: "Delete", className: "btn-danger" } },
                    allowOutsideClick: false,
                }).then(function (willDelete) {
                    if (willDelete) {
                        $.ajax({
                            url: link,
                            type: "DELETE",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function () {
                                swal({ icon: "success", text: "Chapter deleted." })
                                    .then(function () { window.location.reload(); });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

