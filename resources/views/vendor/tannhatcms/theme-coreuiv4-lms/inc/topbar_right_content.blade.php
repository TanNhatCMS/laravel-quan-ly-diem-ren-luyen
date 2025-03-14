<li class="nav-item me-2">
    <button class="btn-link border-0 nav-link px-0 shadow-none bg-transparent" data-bs-toggle="modal" data-bs-target="#modal-layout" style="height: 1.25rem">
        <i class="la la-palette fs-5 me-1"></i>
    </button>
</li>

@section('before_scripts')
    <div class="modal modal-blur fade pe-0" id="modal-layout" tabindex="-1" style="display: none;" aria-modal="false" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('tabler.switch.layout') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chủ đề</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-selectgroup-boxes row mb-3">
                            <div class="col-lg-4 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start px-3" style="cursor: pointer;">
                                    <input @if(config('backpack.ui.view_namespace') === 'tannhatcms.theme-coreuiv4-lms::') checked @endif type="radio" name="theme" value="coreuiv4-lms" class="theme-choice">
                                    <span class="p-2 text-start ms-2">
                                        <span class="fw-bold mb-0 pb-0">Core UI</span><br>
                                        <span class="mb-0"><small>Bootstrap 5</small></span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start px-3" style="cursor: pointer;">
                                    <input @if(config('backpack.ui.view_namespace') === 'tanhatcms.theme-tabler-lms::') checked @endif type="radio" name="theme" value="tabler-lms" class="theme-choice">
                                    <span class="p-2 text-start ms-2">
                                        <span class="fw-bold mb-0 pb-0">Tabler</span><br>
                                        <span class="mb-0"><small>Bootstrap 5</small></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div id="tabler-layouts-selection" class="form-selectgroup-boxes row mb-3" style="display: none;">
                            <p>Bố cục</p>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'horizontal') checked @endif type="radio" name="layout" value="horizontal">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Horizontal</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'horizontal_dark') checked @endif type="radio" name="layout" value="horizontal_dark">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Horizontal Dark</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'horizontal_overlap') checked @endif type="radio" name="layout" value="horizontal_overlap">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Horizontal Overlap</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'vertical') checked @endif type="radio" name="layout" value="vertical">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Vertical</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'vertical_dark') checked @endif type="radio" name="layout" value="vertical_dark">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Vertical Dark</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'vertical_transparent') checked @endif type="radio" name="layout" value="vertical_transparent">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Vertical Transparent</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'right_vertical') checked @endif type="radio" name="layout" value="right_vertical">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Vertical Vertical</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'right_vertical_dark') checked @endif type="radio" name="layout" value="right_vertical_dark">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Right Vertical Dark</span><br>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label class="border rounded text-center d-flex justify-content-start p-2 px-3" style="cursor: pointer;">
                                    <input @if(backpack_theme_config('layout') === 'right_vertical_transparent') checked @endif type="radio" name="layout" value="right_vertical_transparent">
                                    <span class="p-2 text-start ms-2">
                                        <span class="mb-0 pb-0">Right Vertical Transparent</span><br>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-dismiss="modal" data-bs-dismiss="modal">
                            Hủy bỏ
                        </a>
                        <button class="btn btn-primary" type="submit"><i class="la la-check me-2"></i>Áp dụng bố cục</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('after_scripts')
<script>
    const layoutSelection = $('#tabler-layouts-selection');
    @if(config('backpack.ui.view_namespace') !== 'tannhatcms.theme-tabler-lms::')
        layoutSelection.hide();
    @endif
    $('.theme-choice').on('click', function () {
        $(this).val() === 'tabler-lms'
            ? layoutSelection.slideDown()
            : layoutSelection.slideUp();
    });
</script>
@endsection
