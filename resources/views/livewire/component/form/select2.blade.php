<div wire:ignore>
    <label class="form-label">{{ $label }}</label>

    <select id="select2-{{ $model }}" class="select2 form-control" data-placeholder="{{ $placeholder }}"
        data-width="{{ $width }}" data-model="{{ $model }}" {{ $multiple ? 'multiple' : '' }} data-dropdown-parent="{{ $dropdownParent }}">
        <option></option>
        @foreach ($options as $option)
            <option value="{{ $option['value'] }}" @if (in_array($option['value'], $selected)) selected @endif>
                {{ $option['text'] }}
            </option>
        @endforeach
    </select>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            function initSelect2() {
                $('.select2').each(function() {
                    let selectId = $(this).attr('id');
                    let model = $(this).data('model'); // Ambil model spesifik
                    let isMultiple = $(this).attr('multiple') !== undefined;
                    let width = $(this).data('width');
                    let dropdownParent = $(this).data('dropdown-parent') || undefined;

                    if (this.select2) {
                        this.select2('destroy');
                    }

                    $(this).select2({
                        placeholder: $(this).data('placeholder'),
                        allowClear: false,
                        width: width,
                        dropdownParent: dropdownParent
                    });

                    $(this).on('change', function() {
                        let selectedValue = isMultiple ? $(this).val() || [] : $(this).val();
                        Livewire.dispatch('updateSelect2', {
                            model: model,
                            value: JSON.stringify(selectedValue)
                        });
                    });

                });
            }

            document.addEventListener("DOMContentLoaded", initSelect2);
            document.addEventListener("livewire:navigated", initSelect2);
        </script>
    @endpush
</div>
