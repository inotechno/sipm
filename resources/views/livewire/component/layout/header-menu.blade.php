<div>
    @foreach ($menus as $menu)
        @if (!isset($menu['menus']))
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" data-url="{{ $menu['url'] }}" class="btn btn-header-menu header-item waves-effect @if($activePrevixMenu != $menu['prefix']) text-muted @endif font-size-14">
                    <i class="{{ $menu['icon'] }} me-2 align-middle"></i><span
                        class="align-middle">{!! $menu['name'] !!}</span>
                </button>
            </div>

            <!-- Mobile -->
            <div class="dropdown d-inline-block d-lg-none">
                <button type="button" data-url="{{ $menu['url'] }}" class="btn btn-header-menu header-item waves-effect @if($activePrevixMenu != $menu['prefix']) text-muted @endif font-size-14"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $menu['name'] }}">
                    <i class="{{ $menu['icon'] }} align-middle"></i>
                </button>
            </div>
        @endif
    @endforeach

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                $('.btn-header-menu').on('click', function() {
                    let url = $(this).data('url');
                    window.location.href = url;
                });
            });
        </script>
    @endpush
</div>
