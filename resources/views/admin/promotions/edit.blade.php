@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.promotions.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        {{ __('Back to List') }}
    </a>
    <h2 class="text-2xl font-bold text-slate-800">{{ __('Edit Promotion') }}</h2>
    <p class="text-slate-500 text-sm">{{ __('Modify the promotion details.') }}</p>
</div>

<div class="max-w-4xl">
    <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Promotion Title') }}</label>
                    <input type="text" name="title" id="title" value="{{ $promotion->title }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: Batam Weekend Getaway') }}" required>
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Promotion Type') }}</label>
                    <select name="type" id="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none bg-white">
                        <option value="general" {{ $promotion->type == 'general' ? 'selected' : '' }}>{{ __('General / Manual') }}</option>
                        <option value="tour" {{ $promotion->type == 'tour' ? 'selected' : '' }}>{{ __('Tour Package') }}</option>
                        <option value="transport" {{ $promotion->type == 'transport' ? 'selected' : '' }}>{{ __('Transport') }}</option>
                    </select>
                </div>

                <!-- Link to Tour Package -->
                <div id="tour_selection_wrapper">
                    <label for="tour_id" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Link to Tour Package (Optional)') }}</label>
                    <select name="tour_id" id="tour_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all appearance-none bg-white">
                        <option value="">{{ __('--- Select Tour Package ---') }}</option>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" {{ $promotion->tour_id == $tour->id ? 'selected' : '' }}>{{ $tour->title }}</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-slate-400 mt-1">{{ __('If selected, the promotion will automatically link to this tour.') }}</p>
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Badge (Optional)') }}</label>
                    <input type="text" name="badge" id="badge" value="{{ $promotion->badge }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: FLASH SALE') }}">
                </div>

                <!-- Link -->
                <div id="manual_link_wrapper">
                    <label for="link" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Manual Link (Optional)') }}</label>
                    <input type="text" name="link" id="link" value="{{ $promotion->link }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: /tours') }}">
                    <p class="text-[10px] text-slate-400 mt-1">{{ __('Ignored if a Tour Package is selected above.') }}</p>
                </div>

                <!-- Link Text -->
                <div>
                    <label for="link_text" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Button Text (Optional)') }}</label>
                    <input type="text" name="link_text" id="link_text" value="{{ $promotion->link_text }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Example: Book Now') }}">
                </div>

                <!-- Expires At -->
                <div>
                    <label for="expires_at" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Expiry Date (Optional)') }}</label>
                    <input type="datetime-local" name="expires_at" id="expires_at" value="{{ $promotion->expires_at ? $promotion->expires_at->format('Y-m-d\TH:i') : '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <!-- Is Active -->
                <div class="flex items-center space-x-3 pt-8">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $promotion->is_active ? 'checked' : '' }} class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="is_active" class="text-sm font-bold text-slate-700">{{ __('Promotion is Active') }}</label>
                </div>

                <!-- Image -->
                <div class="col-span-2">
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Promotion Image') }}</label>
                    @if($promotion->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $promotion->image) }}" alt="{{ $promotion->title }}" class="w-48 rounded-lg shadow-sm">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-xl p-1">
                    <p class="text-[10px] text-slate-400 mt-1">{{ __('Leave empty to keep current image. Recommended size: 1200x600 or 400x400.') }}</p>
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Description') }}</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="{{ __('Describe the promotion details...') }}">{{ $promotion->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-900/20">
                {{ __('Update Promotion') }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tourSelect = document.getElementById('tour_id');
        const typeSelect = document.getElementById('type');
        const manualLinkInput = document.getElementById('link');

        function updateState() {
            if (tourSelect.value) {
                typeSelect.value = 'tour';
                manualLinkInput.placeholder = 'Locked (linked to tour)';
            } else {
                manualLinkInput.placeholder = 'Example: /tours';
            }
        }

        tourSelect.addEventListener('change', updateState);
        updateState(); // Initialize on load
    });
</script>
@endpush
